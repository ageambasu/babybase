<?php

namespace App;

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
	static $fieldsOnDatabase = [
		//Personal information
		['name', 'text', '', true, true, true],
		['application_date', 'date', '', true, true, false],
		['dob', 'date', '', true, true, false],
		['age_today', 'number', '', false, false, true],
		['sex', 'select', ['Female', 'Male'], true, true, true],
		['monolingual', 'select', ['yes', 'no'], true, true, true],
		['other_languages', 'text', '', true, false, false],
		['parent_firstname', 'text', '', true, true, false],
		['parent_lastname', 'text', '', true, true, false],
		['phone', 'tel', '', true, true, false],
		['email', 'email', '', true, true, false],
		['street', 'text', '', true, true, false],
		['house_number', 'number', '', true, true, false],
		['postcode', 'text', '', true, true, false],
		['city', 'text', '', true, true, true],
		['recruitment_source', 'select', ['Newsletter', 'Direct traffic'], true, true, false],

		//Appointment information
		['preferred_appointment_days', 'select', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], true, true, false],
		['appointment_date', 'date', '', true, true, false],
		['appointment_time', 'time', '', true, true, false],
		['age_at_appointment', 'number', '', false, false, false],
		['appointment_number', 'number', '', true, true, false],
		['appointment_status', 'select', ['New', 'Contacted', 'In progress', 'Completed'], true, true, false],

		//Study information
		['study_type', 'text', '', true, true, false],
		['study_name', 'text', '', true, true, false],
		['study_age_range', 'number', '', true, true, false],
		['prevous_studies_completed', 'text', '', true, false, false],
		['notes', 'text', '', true, false, false],
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

        return $dobToDate->diffInYears(\Carbon\Carbon::now());
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

    	$appDateToDate = \Carbon\Carbon::createFromFormat('Y-m-d', $this->appointment_date);
        
        return $dobToDate->diffInYears($appDateToDate);
    }
}