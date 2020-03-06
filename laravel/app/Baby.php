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
		['age_today', 'number', '', false, false, true, true],
		['sex', 'select', ['Female', 'Male'], true, true, true, true],
		['monolingual', 'select', ['Yes', 'No'], true, true, true, true],
		['other_languages', 'text', '', true, false, false, true],
		['parent_firstname', 'text', '', true, true, false, false],
		['parent_lastname', 'text', '', true, true, false, false],
		['phone', 'tel', '', true, true, false, false],
		['email', 'email', '', true, true, false, false],
		['street', 'text', '', true, true, false, false],
		['house_number', 'number', '', true, true, false, false],
		['postcode', 'text', '', true, true, false, true],
		['city', 'text', '', true, true, true, true],
		['recruitment_source', 'select', ['Mail', 'Website', 'Flyer consultatiebureau', 'Flyer daycare', 'Friend', 'Facebook'], true, true, false, true],

		//Appointment information
		['preferred_appointment_days', 'select', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], true, true, false, true],
		['appointment_date', 'date', '', true, true, false, false],
		['appointment_time', 'time', '', true, true, false, false],
		['age_at_appointment', 'number', '', false, false, false, false],
		['appointment_number', 'number', '', true, true, false, true],
		['appointment_status', 'select', ['New', 'Contacted', 'In progress', 'Completed'], true, true, false, true],

		//Study information
		['study_type', 'select', ['Linguistics', 'Pedagogy', 'NIRS'], true, true, false, true],
		['study_name', 'text', '', true, true, false, true],
		['study_age_range', 'number', '', true, true, false, true],
		['prevous_studies_completed', 'text', '', true, false, false, true],
		['notes', 'text', '', true, false, false, false],
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

    /**
     * Returns the url path for the instance.
     *
     * @param  $query
     * @param  \App\Filters  $filters
     * @return selected filters
     */
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
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
}