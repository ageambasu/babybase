<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $attributes = [
        'status' => 'NEW'
    ];

    public static $validationRules = [
            'date' => 'nullable|date|date_format:Y-m-d',
            'time' => 'nullable',
            'number' => 'required|numeric',
            'status' => 'required',

            'notes' => 'nullable|string|min:2|max:255',
        ];

    public function baby()
    {
        return $this->belongsTo('App\Baby');
    }

    public function study()
    {
        return $this->belongsTo('App\Study');
    }
}
