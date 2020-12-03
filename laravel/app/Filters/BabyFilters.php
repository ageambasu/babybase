<?php

namespace App\Filters;

use Request;
use Carbon\Carbon;

/**
 * This helper class is used in BabiesController via dependency injection
 * to translater some filters to database queries.
 * TODO: remove methods that are not in use
 */
class BabyFilters extends QueryFilter
{
    /**
     * Returns the filtered values.
     *
     * @param  $value
     * @return filtered data
     */
    public function application_date($value = null)
    {
        if ($value) {
            return $this->builder->where('application_date', $value);
        }
    }

    public function older_than($value = null)
    {
        if (isset($value)) {
            $dateToday = Carbon::now('Europe/Amsterdam');
            $calcMinDob = $dateToday->subMonths($value);
            $min_dob = $calcMinDob->format('Y-m-d'); //no older than
            return $this->builder->where('dob', '<=', $min_dob);
        }
    }

    public function younger_than($value = null)
    {
        if (isset($value)) {
            $dateToday = Carbon::now('Europe/Amsterdam');
            $calcMinDob = $dateToday->subMonths($value);
            $max_dob = $calcMinDob->format('Y-m-d');
            return $this->builder->where('dob', '>', $max_dob);
        }
    }

    /**
     * Returns the filtered values.
     *
     * @param  $value
     * @return filtered data
     */
    public function age_today($value = null)
    {
        $value = Request::input('age_today');

        if (isset($value)) {

            $dateToday = Carbon::now('Europe/Amsterdam');

            $calcMinDob = $dateToday->subYears($value);
            $min_dob = $calcMinDob->format('Y-m-d'); //no older than

            if ($value > 1) {

                $maxYearValue = $value -1;

                $calcMaxDob = $dateToday->subYears($maxYearValue);
                $max_dob = $calcMaxDob->format('Y-m-d'); //no younger than

                return $this->builder->where('dob', '<=', $min_dob)->where('dob', '>', $max_dob);

            } elseif ($value == 1) {

                $maxYearValue = $value;

                $calcMaxDob = $dateToday->subYears($maxYearValue);
                $max_dob = $calcMaxDob->format('Y-m-d'); //no younger than

                return $this->builder->where('dob', '<=', $min_dob)->where('dob', '>', $max_dob);

            } else {

                $calcMinDob = $dateToday->subDays(364);
                $min_dob = $calcMinDob->format('Y-m-d'); //no older than

                return $this->builder->where('dob', '>', $min_dob);

            }

        }
    }

    /**
     * Returns the filtered values.
     *
     * @param  $value
     * @return filtered data
     */
    public function dob($value = null)
    {
        if ($value) {
            return $this->builder->where('dob', 'LIKE', "%$value%");
        }
    }

    /**
     * Returns the filtered values.
     *
     * @param  $value
     * @return filtered data
     */
    public function sex($value = null)
    {
        if ($value) {
            return $this->builder->where('sex', $value);
        }
    }

    /**
     * Returns the filtered values.
     *
     * @param  $value
     * @return filtered data
     */
    public function monolingual_dutch($value = null)
    {
        if ($value) {
            return $this->builder->where('monolingual_dutch', $value);
        }
    }

    /**
     * Returns the filtered values.
     *
     * @param  $value
     * @return filtered data
     */
    public function other_languages($value = null)
    {
        if ($value) {
            return $this->builder->where('other_languages', $value);
        }
    }

    /**
     * Returns the filtered values.
     *
     * @param  $value
     * @return filtered data
     */
    public function postcode($value = null)
    {
        if ($value) {
            return $this->builder->where('postcode', $value);
        }
    }

    /**
     * Returns the filtered values.
     *
     * @param  $value
     * @return filtered data
     */
    public function city($value = null)
    {
        if ($value) {
            return $this->builder->where('city', $value);
        }
    }

    /**
     * Returns the filtered values.
     *
     * @param  $value
     * @return filtered data
     */
    public function recruitment_source($value = null)
    {
        if ($value) {
            return $this->builder->where('recruitment_source', $value);
        }
    }

    /**
     * Returns the filtered values.
     *
     * @param  $value
     * @return filtered data
     */
    public function preferred_appointment_days($value = null)
    {
        if ($value) {
            return $this->builder->where('preferred_appointment_days', $value);
        }
    }

    /**
     * Returns the filtered values.
     *
     * @param  $value
     * @return filtered data
     */
    public function appointment_number($value = null)
    {
        if ($value) {
            return $this->builder->where('appointment_number', $value);
        }
    }

    /**
     * Returns the filtered values.
     *
     * @param  $value
     * @return filtered data
     */
    public function appointment_status($value = null)
    {
        if ($value) {
            return $this->builder->where('appointment_status', $value);
        }
    }

    /**
     * Returns the filtered values.
     *
     * @param  $value
     * @return filtered data
     */
    public function study_type($value = null)
    {
        if ($value) {
            return $this->builder->where('study_type', $value);
        }
    }

    /**
     * Returns the filtered values.
     *
     * @param  $value
     * @return filtered data
     */
    public function study_name($value = null)
    {
        if ($value) {
            return $this->builder->where('study_name', $value);
        }
    }

    /**
     * Returns the filtered values.
     *
     * @param  $value
     * @return filtered data
     */
    public function study_age_range($value = null)
    {
        if ($value) {
            return $this->builder->where('study_age_range', $value);
        }
    }

    /**
     * Returns the filtered values.
     *
     * @param  $value
     * @return filtered data
     */
    public function prevous_studies_completed($value = null)
    {
        if ($value) {
            return $this->builder->where('prevous_studies_completed', $value);
        }
    }
}
