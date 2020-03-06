<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Study extends Model
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
		//Study information
		['study_type', 'select', ['Linguistics', 'Pedagogy', 'NIRS'], true, true, false, true],
		['study_name', 'text', '', true, true, false, true],
		['study_age_range_start', 'number', '', true, true, false, true],
		['study_age_range_end', 'number', '', true, true, false, true],
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
     * @param  \App\Study  $study
     * @return url path
     */
    public function path()
    {
        return route('studies.show', $this);
    }

    /**
     * Returns all the babies linked to the study.
     *
     * @param  \App\Study  $study
     * @return selected filters
     */
    public function babies()
    {
        return $this->belongsToMany(Baby::class)->withTimestamps();
    }
}
