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
        ['ongoing', 'boolean', '', true, false, true, true],
    ];

    /**
     * The rules to validate.
     *
     * @var array
     */
    public static $validationRules = [
            'study_type' => 'required|string|min:2|max:255',
            'study_name' => 'required|string|min:2|max:255',
            'study_age_range_start' => 'required|numeric',
            'study_age_range_end' => 'required|numeric',
            'notes' => 'nullable|string|min:2|max:255',
            'ongoing' => 'nullable'
        ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function appointments()
    {
        return $this->hasMany('App\Appointment');
    }

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
    public function getBabiesAttribute()
    {
        $babies = array();
        foreach($this->appointments as $a) {
            array_push($babies, $a->baby);
        }
        return array_unique($babies);
    }

    /**
     * Returns all keys of Study.
     *
     * @param  \App\Study  self
     * @return all keys
     */
    public function getFilterColumns() : array
    {
        return array_keys(self::$validationRules);
    }

    public function getAgeStartAttribute()
    {
        return implode(';', [intdiv($this->study_age_range_start, 30),
                             $this->study_age_range_start % 30]);
    }

    public function getAgeEndAttribute()
    {
        return implode(';', [intdiv($this->study_age_range_end, 30),
                             $this->study_age_range_end % 30]);
    }

    public static function ongoing()
    {
        return Study::where('ongoing', true)->get();
    }
}
