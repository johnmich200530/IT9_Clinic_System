<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;

class PatientController extends Controller
{
    public function dashboard()
    {
        $patient = Patient::where('email', auth()->user()->email)->first();

        $totalAppointments = $patient ? Appointment::where('patient_id', $patient->id)->count() : 0;
        $scheduledCount    = $patient ? Appointment::where('patient_id', $patient->id)->where('status', 'Scheduled')->count() : 0;
        $completedCount    = $patient ? Appointment::where('patient_id', $patient->id)->where('status', 'Completed')->count() : 0;

        $upcomingAppointments = $patient
            ? Appointment::with(['doctor', 'service'])
                ->where('patient_id', $patient->id)
                ->where('status', 'Scheduled')
                ->whereDate('date', '>=', today())
                ->orderBy('date')
                ->orderBy('time')
                ->get()
            : collect();

        return view('patient.dashboard', compact(
            'patient',
            'totalAppointments',
            'scheduledCount',
            'completedCount',
            'upcomingAppointments'
        ));
    }

    public function appointments()
    {
        $patient = Patient::where('email', auth()->user()->email)->first();

        $appointments = $patient
            ? Appointment::with(['doctor', 'service', 'payment'])
                ->where('patient_id', $patient->id)
                ->orderBy('id', 'asc')
                ->get()
            : collect();

        return view('patient.appointments', compact('appointments', 'patient'));
    }
}
