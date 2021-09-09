<?php

namespace App;

use App\Appointment;
use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Baby extends Model
{
    use SoftDeletes;
    protected $dates = ['application_date', 'dob'];
    protected $casts = [
        'dob' => 'datetime:d/m/Y',
    ];
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
		['application_date', 'date', '', true, true, false, false],
		['dob', 'date', '', true, true, false, false],
		['older_than', 'text', [], false, false, false, true],
		['younger_than', 'text', [], false, false, false, true],
		['age_today', 'text', [], false, false, true, false],
		['sex', 'select', ['Female', 'Male'], true, true, true, true],
		['monolingual_dutch', 'boolean', ['Yes', 'No'], true, true, true, true],
		['has_sibling', 'boolean', ['Yes', 'No'], true, false, false, true],
		['other_languages', 'multiselect', [], true, false, false, true],
		['parent_firstname', 'text', '', true, true, false, false],
		['parent_lastname', 'text', '', true, true, false, false],
		['phone', 'tel', '', true, false, false, false],
		['phone_2', 'tel', '', true, false, false, false],
		['email', 'email', '', true, true, false, false],
		['street', 'text', '', true, false, false, false],
		['house_number', 'number', '', true, false, false, false],
		['postcode', 'text', '', true, false, false, false],
		['city', 'text', '', true, false, true, true],
		['recruitment_source', 'select', ['Mail', 'Website', 'Flyer consultatiebureau', 'Flyer daycare', 'Friend', 'Facebook', 'Instagram'], true, false, false, true],

		//Appointment information
		['preferred_appointment_days', 'multiselect', ['None', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], true, false, false, true],

        ['notes', 'text', '', true, false, false, false],
    ];

    static $prettyNames = [ 'dob' => 'Date of birth' ];

    public static function fieldName($key) {
        if (isset(self::$prettyNames[$key])) {
            return self::$prettyNames[$key];
        }
        return ucfirst(str_replace('_', ' ', $key));
    }

    public function languages() {
        return $this->belongsToMany('App\Language');
    }

    /**
     * The rules to validate.
     *
     * @var array
     */
    public static $validationRules = [
            //Personal information
            'name' => 'required|string|min:2|max:255',
            'application_date' => 'required|date_format:d/m/Y',
            'dob' => 'required|date_format:d/m/Y',
            'sex' => 'required',
            'monolingual_dutch' => 'required',
            'parent_firstname' => 'required|string|min:2|max:255',
            'parent_lastname' => 'required|string|min:2|max:255',
            'phone' =>  'nullable|string',
            'phone_2' =>  'nullable|string',
            'email' => 'required|email',
            'street' => 'nullable|string|min:2|max:255',
            'house_number' =>  'nullable|numeric',
            'postcode' =>  'nullable|string|min:2|max:255',
            'city' =>  'nullable|string|min:2|max:255',
            'recruitment_source' =>  'nullable',

            'preferred_appointment_days' =>  'nullable',
            'has_sibling' =>  'nullable',

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
        $carbonDate = $this->dob->diff(\Carbon\Carbon::now())->format('%y,%m,%d');

        $carbonArray = explode(',', $carbonDate);

        $dateMonthsDays=[0=>(int)$carbonArray[0] * 12 + (int)$carbonArray[1], 1=>(int)$carbonArray[2]];

        $dateMonthsDays = implode(';', $dateMonthsDays);

        return $dateMonthsDays;
    }

    public function getStudiesAttribute()
    {
        $studies = array();
        foreach($this->appointments as $a) {
            array_push($studies, $a->study);
        }
        return $studies;
    }

    public function getRelatedAttribute()
    {
        return Baby::where(function($q) {
            if ($this->phone) {
                $q->where('phone', $this->phone);
            }
            if ($this->email) {
                $q->orWhere('email', $this->email);
            }
        })->where('id', '!=', $this->id)->get();
    }


    public function scopeFilterBabies($query, array $filters = [])
    {
        $query->where('approved', true);

        if ($filters) {
            foreach ($filters as $column => $value) {
                if (in_array($column, $this->getFilterColumns())) {
                    $query->where($column, '=', $value);
                }
            }
        }
    }

    public function scopeFilterLanguages($query, array $languages = [])
    {
        $q = $this;
        if ($languages) {
            foreach($languages as $lang) {
                $q = $q->whereHas('languages' , function ($query) use ($lang) {
                    $query->where('name', $lang);
                });
            };
            return $q;
        }
    }

    public function scopeFilterStudy($query, $study_id)
    {
        if ($study_id) {
            return $this->whereHas('appointments' , function ($query) use ($study_id) {
                $query->where('study_id', $study_id)->where('status', '!=', Appointment::Canceled);
            });
        }
    }

    public function scopeSignups($query)
    {
        return $this->where('approved', false);
    }


    /**
     * Returns all keys of Baby.
     *
     * @param  \App\Baby  self
     * @return all keys
     */
    public function getFilterColumns() : array
    {
        $keys = array_keys(self::$validationRules);
        $keys = array_diff($keys, array('preferred_appointment_days'));
        return $keys;
    }

    public function appointments()
    {
        return $this->hasMany('App\Appointment');
    }
}
