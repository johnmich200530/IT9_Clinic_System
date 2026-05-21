<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Service;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $appointments = Appointment::with(['patient', 'doctor', 'service'])
            ->when($search, function ($q) use ($search) {
                $q->whereHas('patient', fn($p) => $p->where('full_name', 'like', "%{$search}%"))
                  ->orWhereHas('doctor', fn($d) => $d->where('full_name', 'like', "%{$search}%"))
                  ->orWhereHas('service', fn($s) => $s->where('service_name', 'like', "%{$search}%"))
                  ->orWhere('status', 'like', "%{$search}%");
            })
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.appointments.index', compact('appointments', 'search'));
    }

    public function create()
    {
        $services = Service::all();
        $patients = Patient::where('status', 'Active')->get();
        $doctors  = Doctor::where('status', 'Active')->get();
        return view('admin.appointments.create', compact('services', 'patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'patient_id' => 'required|exists:patients,id',
            'doctor_id'  => 'required|exists:doctors,id',
            'status'     => 'required|in:Scheduled,Completed,Cancelled',
            'date'       => 'required|date',
            'time'       => 'required',
        ]);

        Appointment::create($request->only([
            'service_id', 'patient_id', 'doctor_id', 'status', 'date', 'time',
        ]));

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    public function edit(Appointment $appointment)
    {
        $services = Service::all();
        $patients = Patient::all();
        $doctors  = Doctor::all();
        return view('admin.appointments.edit', compact('appointment', 'services', 'patients', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'patient_id' => 'required|exists:patients,id',
            'doctor_id'  => 'required|exists:doctors,id',
            'status'     => 'required|in:Scheduled,Completed,Cancelled',
            'date'       => 'required|date',
            'time'       => 'required',
        ]);

        $appointment->update($request->only([
            'service_id', 'patient_id', 'doctor_id', 'status', 'date', 'time',
        ]));

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }
}
