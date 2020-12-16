<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Baby;
use App\Study;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AppointmentsController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all();
        return view('appointments.index', ['appointments' => $appointments]);
    }

    public function show(Appointment $appointment)
    {
        return view('appointments.show', ['appointment' => $appointment]);
    }

    public function edit(Appointment $appointment)
    {
        return view('appointments.edit', ['appointment' => $appointment]);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validatedAttributes = $request->validate(Appointment::$validationRulesUpdate);
        $appointment->update($validatedAttributes);
        return redirect(route('appointments.show', $appointment));
    }


    public function create(Baby $baby)
    {
        $appointment = new Appointment();
        $appointment->baby = $baby;
        return view('appointments.create', ['appointment' => $appointment,
                                            'all_studies' => Study::all()]);
    }

    public function store(Request $request)
    {
        $fields = $request->validate(Appointment::$validationRules);
        $appointment = new Appointment($fields);
        $appointment->baby_id = (int)$fields['baby'];
        $appointment->study_id = (int)$fields['study'];
        $appointment->save();
        return redirect(route('appointments.show', ['appointment' => $appointment]));
    }

    public function cancel(Appointment $appointment)
    {
        $appointment->status = Appointment::Canceled;
        $appointment->save();
        return redirect(route('appointments.show', ['appointment' => $appointment]));
    }

}
