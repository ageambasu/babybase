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
		['study_type', 'select', ['Linguistics', 'Pedagogy', 'NIRS'], true, true, true, true],
		['study_name', 'text', '', true, true, true, true],
		['study_age_range_start', 'number', '', true, true, true, true],
		['study_age_range_end', 'number', '', true, true, true, true],
		['notes', 'text', '', true, false, false, false],
    ];

    public static $validationRules = [
            'study_type' => 'required|string|min:2|max:255',
            'study_name' => 'required|string|min:2|max:255',
            'study_age_range_start' => 'required|numeric',
            'study_age_range_end' => 'required|numeric',
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


    public function getFilterColumns() : array 
    {
        return array_keys(self::$validationRules);
        // return array_map(function ($attribute) {
        //     return $this->qualifyColumn($attribute);
        // }, array_keys(self::$validationRules));
    }

}
