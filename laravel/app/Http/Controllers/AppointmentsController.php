<?php

namespace App\Http\Controllers;

use App\Appointment;
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

    public function update(Appointment $appointment)
    {
        $validatedAttributes = $this->validateAppointment();
        Log::alert($validatedAttributes);
        $appointment->update($validatedAttributes);
        $appointment->sync();
        return redirect(route('appointments.show'), $appointment);
    }

    protected function validateAppointment()
    {
        return request()->validate(Appointment::$validationRules);
    }
}
