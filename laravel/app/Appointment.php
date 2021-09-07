<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    // status definitions
    const New = 'NEW';
    const Canceled = 'CANCELED';
    const Contacted = 'Contacted';
    const Completed = 'Completed';

    const Status = [
        Appointment::New => '📅 Scheduled',
        Appointment::Canceled => '❌ Canceled',

        // an appointment with status Contacted is not really an appointment but is used to indicate
        // that the parents were contacted about a certain study
        Appointment::Contacted => '📞 Contacted',
        Appointment::Completed => '🏆 Completed'
    ];


    protected $attributes = [
        'status' => 'NEW',
        'number' => 1,
    ];

    protected $dates = ['date'];
    protected $casts = [
        'date' => 'datetime:d/m/Y',
    ];

    protected $fillable = [
        'date', 'time', 'status'
    ];

    public static $validationRules = [
        'baby' => 'required|exists:babies,id',
        'study' => 'required|exists:studies,id',
        'date' => 'required|date_format:d/m/Y',
        'time' => 'required',
        'status' => 'nullable',

        'notes' => 'nullable|string|min:2|max:255',
    ];

    public static $validationRulesUpdate = [
        'date' => 'required|date_format:d/m/Y',
        'study' => 'required|exists:studies,id',
        'time' => 'required',
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

    public function prettyStatus()
    {
        return Appointment::Status[$this->status];
    }

    public function prettyDateTime()
    {
        return date('D, d/m/Y', strtotime($this->date)) . ' ' . date('H:i', strtotime($this->time));
    }

    public function editable()
    {
        return $this->status == Appointment::New;
    }

    public function canceled()
    {
        return $this->status == Appointment::Canceled;
    }
}
