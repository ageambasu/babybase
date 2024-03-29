<?php

namespace App\Http\Controllers;

use App\Baby;
use App\Language;
use App\Study;
use App\Filters\BabyFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BabiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\BabyFilters  $filters
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(BabyFilters $filters, Request $request)
    {
        $sortColumn = $request->get('sortColumn', 'id');
        $sortOrder = $request->get('sortOrder', 'asc');
        if (isset($request['preferred_appointment_days'])){
            $request['preferred_appointment_days'] = $this->daysToBits($request['preferred_appointment_days']);
        }

        $babyFilterColumns = Baby::query()->getModel()->getFilterColumns();
        $babyColumns = array_filter($request->only($babyFilterColumns));

        $languages = $request->get('languages', []);
        $ageMin = $request->get('older_than');
        $ageMax = $request->get('younger_than');
        $study = $request->get('study', null);

        $babies = Baby::filterBabies($babyColumns)
                ->filterStudy($study)
                ->filterLanguages($languages);

        $filters->apply($babies);

        $activeFilters = array_merge(array(), $babyColumns);

        if($study) $activeFilters['study'] = Study::find($study)->study_name;
        $activeFilters = array_merge($activeFilters, $filters->activeFilters());
        if($languages) $activeFilters['languages'] = $languages;

        if (isset($activeFilters['preferred_appointment_days'])) {
            $activeFilters['preferred_appointment_days'] = $this->bitsToDays($activeFilters['preferred_appointment_days']);
        }

        for ($i = 0; $i < count(Baby::$fieldsOnDatabase); $i++) {
            $fieldName = Baby::$fieldsOnDatabase[$i][0];
            $fieldType = Baby::$fieldsOnDatabase[$i][1];
            if($fieldType == 'boolean' && isset($activeFilters[$fieldName])) {
                $activeFilters[$fieldName] = $activeFilters[$fieldName] ? 'Yes' : 'No';
            }
        }

        $results = $babies->orderBy($sortColumn, $sortOrder);
        return view ('babies.index', ['babies' => $results->paginate(10),
                                      'total' => $results->count(),
                                      'fieldsOnDatabase' => Baby::$fieldsOnDatabase,
                                      'activeFilters' => $activeFilters]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('babies.create', ['fieldsOnDatabase' => Baby::$fieldsOnDatabase,
                                      'all_languages' => Language::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (isset($request['preferred_appointment_days'])){
            $request['preferred_appointment_days'] = $this->daysToBits($request['preferred_appointment_days']);
        }

        if (isset($request['phone'])) {
            $request['phone'] = str_replace(['-', '+', ' '], '', $request['phone']);
        }

        if (is_null($request['has_sibling'])) {
            $request['has_sibling'] = false;
        }

        $validated = $this->validateBaby();
    	$validated['application_date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['application_date'])->format('Y-m-d');
    	$validated['dob'] = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['dob'])->format('Y-m-d');
        $baby = Baby::create($validated);

        $languages = request('other_languages', []);
        $lang_ids = array();
        foreach($languages as $lang_name) {
            $lang = Language::firstOrCreate(['name' => $lang_name]);
            array_push($lang_ids, $lang->id);
        }

        $baby->languages()->sync($lang_ids);

        // when creating a new baby record in the system, it should be automatically approved
        $baby->approved = true;
        $baby->save();

        return redirect(route('babies.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Baby  $baby
     * @return \Illuminate\Http\Response
     */
    public function show(Baby $baby)
    {
        $baby->preferred_appointment_days = implode(', ', $this->bitsToDays($baby->preferred_appointment_days));
        return view('babies.show', ['baby' => $baby, 'fieldsOnDatabase' => Baby::$fieldsOnDatabase, 'studyFieldsOnDatabase' => Study::$fieldsOnDatabase]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Baby  $baby
     * @return \Illuminate\Http\Response
     */
    public function edit(Baby $baby)
    {
        $babyStudiesIds = [];

        foreach ($baby->studies as $study) {
            array_push($babyStudiesIds, $study->id);
        }

        $baby->preferred_appointment_days = $this->bitsToDays($baby->preferred_appointment_days);
        $baby->other_languages = explode(',', $baby->other_languages);

        return view('babies.edit', ['baby' => $baby,
                                    'fieldsOnDatabase' => Baby::$fieldsOnDatabase,
                                    'studies' => Study::all(),
                                    'babyStudiesIds' => $babyStudiesIds,
                                    'all_languages' => Language::all()]);
    }

    protected function daysToBits(array $days) {
        if ($days[0] == 'None') {
            return 255;
        }

        $mask = 0;
        $week = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $i = 1;
        foreach ($week as $dow) {
            if (in_array($dow, $days)) {
                $mask |= $i;
            }
            $i = $i << 1;
        }

        return $mask;
    }

    protected function bitsToDays(int $bitmask) {
        $week = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $days = array();
        for ($i = 0; $i < 7; $i++) {
            if ($bitmask & (2**$i))
                array_push($days, $week[$i] );
        }
        return $days;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Baby  $baby
     * @return \Illuminate\Http\Response
     */
    public function update(Baby $baby)
    {
        $validated = $this->validateBaby();

        unset($validated['other_languages']);

        if (isset($validated['preferred_appointment_days'])){
            $validated['preferred_appointment_days'] = $this->daysToBits($validated['preferred_appointment_days']);
        }

    	$validated['application_date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['application_date'])->format('Y-m-d');
    	$validated['dob'] = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['dob'])->format('Y-m-d');
        $baby->update($validated);

        $languages = request('other_languages', []);
        $lang_ids = array();
        foreach($languages as $lang_name) {
            $lang = Language::firstOrCreate(['name' => $lang_name]);
            array_push($lang_ids, $lang->id);
        }

        $baby->languages()->sync($lang_ids);

        return redirect(route('babies.show', $baby));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // check if baby was approved so that we can redirect to signups page if necessary
        $baby = Baby::withTrashed()->where('id', $id)->first();
        $approved = $baby->approved;
        $trashed = $baby->trashed();

        if ($trashed && Auth::user()->isAdmin()) {
            // hard delete
            $baby->forceDelete();
        }
        else {
            // soft delete
            $baby->delete();
        }

        if ($trashed) {
            return redirect(route('archive.index'))->with('success','Baby deleted successfully.');
        }
        else if ($approved) {
            return redirect(route('babies.index'))->with('success','Baby deleted successfully.');
        }
        return redirect(route('signups.index'))->with('success','Baby deleted successfully.');
    }

    /**
     * Show the form for creating a new filter.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $allValueTypes = $this->getAllValueTypes();

        return view('babies.filter', ['allValueTypes' => $allValueTypes,
                                      'fieldsOnDatabase' => Baby::$fieldsOnDatabase,
                                      'all_languages' => Language::all(),
                                      'all_studies' => Study::all()]);
    }

    /**
     * Returns all babies and studies value types.
     *
     * @return $allValueTypes
     */
    protected function getAllValueTypes()
    {
        $allValueTypes = [];

        //Including babies
        $babies = Baby::all();
        $fieldsOnDatabase = Baby::$fieldsOnDatabase;

        foreach ($fieldsOnDatabase as $key => $fieldOnDatabase) {

            $fieldName = $fieldsOnDatabase[$key][0];
            $babyValueTypes = [];

            foreach ($babies as $baby) {

                if ($fieldName == 'age_today') {
                } else {
                    array_push($babyValueTypes, $baby->$fieldName);
                }
            }

            $babyValueTypes = array_unique(array_map('strtolower', $babyValueTypes));
            sort($babyValueTypes);

            $allValueTypes[$fieldName] = $babyValueTypes;
        }

        //Including studies
        $studies = Study::all();
        $fieldsOnDatabase = Study::$fieldsOnDatabase;

        foreach ($fieldsOnDatabase as $key => $fieldOnDatabase) {

            $fieldName = $fieldsOnDatabase[$key][0];

            foreach ($studies as $study) {
                array_push($babyValueTypes, $study->$fieldName);
            }

            $babyValueTypes = array_unique(array_map('strtolower', $babyValueTypes));
            sort($babyValueTypes);

            $allValueTypes[$fieldName] = $babyValueTypes;
        }

        return $allValueTypes;
    }

    /**
     * Validates the submitted fields.
     *
     * @return \Illuminate\Http\Response
     */
    protected function validateBaby()
    {
        return request()->validate(Baby::$validationRules + [
            'studies' => 'exists:studies,id',
        ]);
    }

    public function signups(Request $request)
    {
        $sortColumn = $request->get('sortColumn', 'id');
        $sortOrder = $request->get('sortOrder', 'asc');

        $babies = Baby::signups();
        return view ('babies.index', ['babies' => $babies->orderBy($sortColumn, $sortOrder)->paginate(10),
                                      'total' => $babies->count(),
                                      'fieldsOnDatabase' => Baby::$fieldsOnDatabase,
                                      'activeFilters' => array()]);

    }

    public function signupApprove(Baby $baby)
    {
        $baby->approved = true;
        $baby->save();
        return redirect(route('babies.show', $baby));
    }

    public function signupReject(Baby $baby)
    {
        // this is a separate delete action that is open to all users but is limited to babies that
        // were not already approved
        if (!$baby->approved) {
            $baby->delete();

            return redirect(route('signups.index'))->with('success','Baby deleted successfully.');
        }
    }

    public function archive()
    {
        $results = Baby::onlyTrashed();
        return view ('babies.index', ['archive' => true,
                                      'babies' => $results->paginate(10),
                                      'total' => $results->count(),
                                      'fieldsOnDatabase' => Baby::$fieldsOnDatabase,
                                      'activeFilters' => []]);

    }
}
