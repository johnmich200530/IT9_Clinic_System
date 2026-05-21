<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;

class DoctorController extends Controller
{
    public function dashboard()
    {
        $doctor = Doctor::where('email', auth()->user()->email)->first();

        $totalAppointments    = $doctor ? Appointment::where('doctor_id', $doctor->id)->count() : 0;
        $scheduledCount       = $doctor ? Appointment::where('doctor_id', $doctor->id)->where('status', 'Scheduled')->count() : 0;
        $completedCount       = $doctor ? Appointment::where('doctor_id', $doctor->id)->where('status', 'Completed')->count() : 0;

        $todayAppointments = $doctor
            ? Appointment::with(['patient', 'service'])
                ->where('doctor_id', $doctor->id)
                ->whereDate('date', today())
                ->orderBy('time')
                ->get()
            : collect();

        return view('doctor.dashboard', compact(
            'doctor',
            'totalAppointments',
            'scheduledCount',
            'completedCount',
            'todayAppointments'
        ));
    }

    public function appointments()
    {
        $doctor = Doctor::where('email', auth()->user()->email)->first();

        $appointments = $doctor
            ? Appointment::with(['patient', 'service'])
                ->where('doctor_id', $doctor->id)
                ->orderBy('id', 'asc')
                ->get()
            : collect();

        return view('doctor.appointments', compact('appointments', 'doctor'));
    }
}
