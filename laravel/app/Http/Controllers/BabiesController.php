<?php

namespace App\Http\Controllers;

use App\Baby;
use Illuminate\Http\Request;

class BabiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('babies.index', ['babies' => Baby::paginate(10), 'fieldsOnDatabase' => Baby::$fieldsOnDatabase]);
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
        return view('babies.show', ['baby' => $baby, 'fieldsOnDatabase' => Baby::$fieldsOnDatabase]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Baby  $baby
     * @return \Illuminate\Http\Response
     */
    public function edit(Baby $baby)
    {
        return view('babies.edit', ['baby' => $baby, 'fieldsOnDatabase' => Baby::$fieldsOnDatabase]);
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
        $baby->update($this->validateBaby());

        return redirect(route('babies.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Baby  $baby
     * @return \Illuminate\Http\Response
     */
    public function destroy(Baby $baby)
    {
        //
    }

    /**
     * Validates the submitted fields.
     *
     * @return \Illuminate\Http\Response
     */
    protected function validateBaby()
    {
        return request()->validate([
            //Personal information
            'name' => 'required|string|min:2|max:255',
            'application_date' => 'required|date|date_format:Y-m-d',
            'dob' => 'required|date',
            'sex' => 'required',
            'monolingual' => 'required',
            'other_languages' => 'nullable|string|min:2|max:255',
            'parent_firstname' => 'required|string|min:2|max:255',
            'parent_lastname' => 'required|string|min:2|max:255',
            'phone' =>  'required|numeric|digits_between:3,16',
            'email' => 'required|email',
            'street' => 'required|string|min:2|max:255',
            'house_number' =>  'required|numeric',
            'postcode' =>  'required|string|min:2|max:255',
            'city' =>  'required|string|min:2|max:255',
            'recruitment_source' =>  'required',

            //Appointment information
            'preferred_appointment_days' =>  'required',
            'appointment_date' => 'required|date|date_format:Y-m-d',
            'appointment_time' => 'required',
            'appointment_number' => 'required|numeric',
            'appointment_status' => 'required',

            //Study information
            'study_type' => 'required|string|min:2|max:255',
            'study_name' => 'required|string|min:2|max:255',
            'study_age_range' => 'required|numeric',
            'prevous_studies_completed' => 'nullable|string|min:2|max:255',
            'notes' => 'nullable|string|min:2|max:255',
        ]);
    }
}
