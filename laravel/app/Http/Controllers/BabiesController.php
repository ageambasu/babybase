<?php

namespace App\Http\Controllers;

use App\Baby;
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
        $sortColumn = $request->get('sortColumn', null);
        $sortOrder = $request->get('sortOrder', null);

        $babyColumns = array_filter($request->only( 
                    Baby::query()->getModel()->getFilterColumns()
                ));
        $studyColumns = array_filter($request->only(
                    Study::query()->getModel()->getFilterColumns()
                ));

        if (isset($sortColumn) && $sortColumn != NULL && isset($sortOrder) && $sortOrder != NULL) {

            return view ('babies.index', ['babies' => Baby::filterBabies($babyColumns)->filterStudies($studyColumns)->orderBy($sortColumn, $sortOrder)->paginate(10), 'fieldsOnDatabase' => Baby::$fieldsOnDatabase]);

        } else {
            
            return view ('babies.index', ['babies' => Baby::filterBabies($babyColumns)->filterStudies($studyColumns)->paginate(10), 'fieldsOnDatabase' => Baby::$fieldsOnDatabase]);
        
        }
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
        $request['preferred_appointment_days'] = implode(',', $request['preferred_appointment_days']);
        
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

        return view('babies.edit', ['baby' => $baby, 'fieldsOnDatabase' => Baby::$fieldsOnDatabase, 'studies' => Study::all(), 'babyStudiesIds' => $babyStudiesIds]);
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

        $baby->update($validatedAttributes);

        $baby->studies()->sync(request('studies'));

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

        return view('babies.filter', ['allValueTypes' => $allValueTypes, 'fieldsOnDatabase' => Baby::$fieldsOnDatabase, 'studyFieldsOnDatabase' => Study::$fieldsOnDatabase]);
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
                    array_push($babyValueTypes, $baby->getBabyAgeToday());
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
