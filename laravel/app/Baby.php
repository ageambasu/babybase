<?php

namespace App;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;

class Baby extends Model
{
	/**
     * The dataframe equivalent.
     *
     * @var array
     */
	static $fieldName = 0;
    static $fieldType = 1;
	static $fieldValues = 2;
	static $fieldOnForm = 3;
	static $fieldRequiredOnForm = 4;
	static $fieldOnIndex = 5;
    static $fieldOnFilter = 6;
	static $fieldsOnDatabase = [
		//Personal information
		['name', 'text', '', true, true, true, false],
		['application_date', 'date', '', true, true, false, true],
		['dob', 'date', '', true, true, false, true],
		['age_today', 'text', '', false, false, true, true],
		['sex', 'select', ['Female', 'Male'], true, true, true, true],
		['monolingual', 'select', ['Yes', 'No'], true, true, true, true],
		['other_languages', 'text', '', true, false, false, true],
		['parent_firstname', 'text', '', true, true, false, false],
		['parent_lastname', 'text', '', true, true, false, false],
		['phone', 'tel', '', true, true, false, false],
		['email', 'email', '', true, true, false, false],
		['street', 'text', '', true, false, false, false],
		['house_number', 'number', '', true, false, false, false],
		['postcode', 'text', '', true, false, false, true],
		['city', 'text', '', true, false, true, true],
		['recruitment_source', 'select', ['Mail', 'Website', 'Flyer consultatiebureau', 'Flyer daycare', 'Friend', 'Facebook'], true, true, false, true],

		//Appointment information
		['preferred_appointment_days', 'multiselect', ['None', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], true, true, false, true],
		['appointment_date', 'date', '', true, false, false, false],
		['appointment_time', 'time', '', true, false, false, false],
		['age_at_appointment', 'text', '', false, false, false, false],
		['appointment_number', 'number', '', true, true, false, true],
		['appointment_status', 'select', ['New', 'Contacted', 'In progress', 'Completed'], true, true, false, true],

        ['notes', 'text', '', true, false, false, false],
    ];

    /**
     * The rules to validate.
     *
     * @var array
     */
    public static $validationRules = [
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
            'street' => 'nullable|string|min:2|max:255',
            'house_number' =>  'nullable|numeric',
            'postcode' =>  'nullable|string|min:2|max:255',
            'city' =>  'nullable|string|min:2|max:255',
            'recruitment_source' =>  'required',

            //Appointment information
            'preferred_appointment_days' =>  'required',
            'appointment_date' => 'nullable|date|date_format:Y-m-d',
            'appointment_time' => 'nullable',
            'appointment_number' => 'required|numeric',
            'appointment_status' => 'required',

            'notes' => 'nullable|string|min:2|max:255',
        ];

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Returns the url path for the instance.
     *
     * @param  \App\Baby  $baby
     * @return url path
     */
    public function path()
    {
        return route('babies.show', $this);
    }

    /**
     * Returns the current age of a baby.
     *
     * @param  \App\Baby  $baby->dob
     * @return current age
     */
    public function getBabyAgeToday()
    {
    	$dobToDate = \Carbon\Carbon::createFromFormat('Y-m-d', $this->dob);      

        $carbonDate = $dobToDate->diff(\Carbon\Carbon::now())->format('%y,%m,%d');
        
        $carbonArray = explode(',', $carbonDate);
        
        $dateMonthsDays=[0=>(int)$carbonArray[0] * 12 + (int)$carbonArray[1], 1=>(int)$carbonArray[2]];

        $dateMonthsDays = implode(';', $dateMonthsDays);

        return $dateMonthsDays;
    }

    /**
     * Returns the age of a baby at the appointment date.
     *
     * @param  \App\Baby  $baby->dob
     * @param  \App\Baby  $baby->appointment_date
     * @return age at appointment
     */
    public function getBabyAgeAtAppointment()
    {
        $dobToDate = \Carbon\Carbon::createFromFormat('Y-m-d', $this->dob);
        $appDateToDate = \Carbon\Carbon::createFromFormat('Y-m-d', $this->application_date);    

        $carbonDate = $dobToDate->diff($appDateToDate)->format('%y,%m,%d');

        $carbonArray = explode(',', $carbonDate);
        
        $dateMonthsDays=[0=>(int)$carbonArray[0] * 12 + (int)$carbonArray[1], 1=>(int)$carbonArray[2]];

        $dateMonthsDays = implode(';', $dateMonthsDays);

        return $dateMonthsDays;
    }

    /**
     * Returns all the studies linked to the baby.
     *
     * @param  \App\Baby  $baby
     * @return collection of studies for the selected baby
     */
    public function studies()
    {
        return $this->belongsToMany(Study::class)->withTimestamps();
    }


    /**
     * Returns the url path for the instance.
     *
     * @param  $query
     * @param  \App\Filters  $filters
     * @return selected filters
     */
    public function scopeFilterBabies($query, array $filters = []) 
    {
        if ($filters) {
            foreach ($filters as $column => $value) {
                if (in_array($column, $this->getFilterColumns())) {
                    $query->where($column, '=', $value); 
                }
            }

        }
    }

    /**
     * Returns the url path for the instance.
     *
     * @param  $query
     * @param  \App\Filters  $filters
     * @return selected filters
     */
    public function scopeFilterStudies($query, array $filters = []) 
    {
        if ($filters) {
            return $this->whereHas('studies' , function ($query) use ($filters) {
                foreach ($filters as $column => $value) {
                    if (in_array($column, $query->getModel()->getFilterColumns())) { 
                        $query->where($column, '=', $value); 
                    }
                }
            });
        }
    }

    /**
     * Returns all keys of Baby.
     *
     * @param  \App\Baby  self
     * @return all keys
     */
    public function getFilterColumns() : array 
    {
        return array_keys(self::$validationRules);
    }
}