<?php

namespace App\Http\Controllers;

use App\Baby;
use App\Language;
use App\Study;
use App\Filters\BabyFilters;
use Illuminate\Http\Request;

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

        $babyFilterColumns = Baby::query()->getModel()->getFilterColumns();
        $babyColumns = array_filter($request->only($babyFilterColumns));
        $studyColumns = array_filter($request->only(
                    Study::query()->getModel()->getFilterColumns()
                ));

        $languages = $request->get('languages', []);
        $ageMin = $request->get('older_than');
        $ageMax = $request->get('younger_than');

        $babies = Baby::filterBabies($babyColumns)
                ->filterStudies($studyColumns)
                ->filterLanguages($languages);

        $filters->apply($babies);

        $activeFilters = array_merge($babyColumns, $studyColumns);
        $activeFilters = array_merge($activeFilters, $filters->activeFilters());
        if($languages) $activeFilters = array_merge($activeFilters, array('languages' => $languages));

        return view ('babies.index', ['babies' => $babies->orderBy($sortColumn, $sortOrder)->paginate(10),
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
        return view('babies.create', ['fieldsOnDatabase' => Baby::$fieldsOnDatabase]);
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
            $request['preferred_appointment_days'] = implode(',', $request['preferred_appointment_days']);
        }
        if (isset($request['other_languages'])){
            $request['other_languages'] = implode(',', $request['other_languages']);
        }

        Baby::create($this->validateBaby());

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

        $baby->preferred_appointment_days = explode(',', $baby->preferred_appointment_days);
        $baby->other_languages = explode(',', $baby->other_languages);

        return view('babies.edit', ['baby' => $baby,
                                    'fieldsOnDatabase' => Baby::$fieldsOnDatabase,
                                    'studies' => Study::all(),
                                    'babyStudiesIds' => $babyStudiesIds,
                                    'all_languages' => Language::all()]);
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
        $validatedAttributes = $this->validateBaby();

        unset( $validatedAttributes['studies'] ); //Not saving 'studies' on babies table

        $validatedAttributes['preferred_appointment_days'] = implode(',', $validatedAttributes['preferred_appointment_days']);

        unset($validatedAttributes['other_languages']);
        $baby->update($validatedAttributes);

        $baby->studies()->sync(request('studies'));

        $languages = request('other_languages');
        $lang_ids = array();
        foreach($languages as $lang_name) {
            $lang = Language::firstOrCreate(['name' => $lang_name]);
            array_push($lang_ids, $lang->id);
        }

        $baby->languages()->sync($lang_ids);

        //return redirect(route('babies.show', $baby));
        return redirect(route('babies.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Baby::where('id', $id)->delete();

        return redirect(route('babies.index'))->with('success','Baby deleted successfully.');
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
                                      'studyFieldsOnDatabase' => Study::$fieldsOnDatabase,
                                      'all_languages' => Language::all()]);
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
}
