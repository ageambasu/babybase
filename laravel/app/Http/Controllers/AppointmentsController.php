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
        $appointments = Appointment::where('status', '!=', Appointment::Contacted)->has('baby')->orderBy('date')->get();
        return view('appointments.index', ['appointments' => $appointments]);
    }

    public function show(Appointment $appointment)
    {
        return view('appointments.show', ['appointment' => $appointment]);
    }

    public function edit(Appointment $appointment)
    {
        return view('appointments.edit', ['appointment' => $appointment,
                                          'all_studies' => Study::ongoing()]);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validatedAttributes = $request->validate(Appointment::$validationRulesUpdate);
    	$validatedAttributes['date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $validatedAttributes['date'])->format('Y-m-d');
        $appointment->update($validatedAttributes);
        $appointment->study_id = (int)$validatedAttributes['study'];
        $appointment->save();
        return redirect(route('appointments.show', $appointment));
    }


    public function create(Baby $baby)
    {
        $appointment = new Appointment();
        $appointment->baby = $baby;
        return view('appointments.create', ['appointment' => $appointment,
                                            'all_studies' => Study::ongoing()]);
    }

    public function contacted(Baby $baby)
    {
        $appointment = new Appointment();
        $appointment->baby = $baby;
        $appointment->status = Appointment::Contacted;
        return view('appointments.create', ['appointment' => $appointment,
                                            'all_studies' => Study::ongoing()]);
    }

    public function store(Request $request)
    {
        $fields = $request->validate(Appointment::$validationRules);
    	$fields['date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $fields['date'])->format('Y-m-d');
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
