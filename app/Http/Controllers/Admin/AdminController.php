<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Service;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPatients      = Patient::count();
        $totalDoctors       = Doctor::count();
        $totalServices      = Service::count();
        $totalAppointments  = Appointment::count();

        $recentAppointments = Appointment::with(['patient', 'doctor', 'service'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPatients',
            'totalDoctors',
            'totalServices',
            'totalAppointments',
            'recentAppointments'
        ));
    }
}
