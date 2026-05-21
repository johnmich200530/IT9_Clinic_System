<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Service;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    private function getDoctor()
    {
        return Doctor::where('email', auth()->user()->email)->first();
    }

    public function create()
    {
        $doctor   = $this->getDoctor();
        $patients = Patient::where('status', 'Active')->orderBy('full_name')->get();
        $services = Service::orderBy('service_name')->get();
        return view('doctor.appointments.create', compact('doctor', 'patients', 'services'));
    }

    public function store(Request $request)
    {
        $doctor = $this->getDoctor();

        if (!$doctor) {
            return redirect()->route('doctor.appointments')
                ->with('error', 'Your account is not linked to a doctor profile.');
        }

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'service_id' => 'required|exists:services,id',
            'date'       => 'required|date|after_or_equal:today',
            'time'       => 'required',
        ]);

        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id'  => $doctor->id,
            'service_id' => $request->service_id,
            'date'       => $request->date,
            'time'       => $request->time,
            'status'     => 'Scheduled',
        ]);

        return redirect()->route('doctor.appointments')
            ->with('success', 'Appointment booked successfully.');
    }

    public function cancel(Appointment $appointment)
    {
        $doctor = $this->getDoctor();

        // Only allow cancelling own appointments that are still scheduled
        if (!$doctor || $appointment->doctor_id !== $doctor->id) {
            abort(403);
        }

        if ($appointment->status !== 'Scheduled') {
            return redirect()->route('doctor.appointments')
                ->with('error', 'Only scheduled appointments can be cancelled.');
        }

        $appointment->update(['status' => 'Cancelled']);

        return redirect()->route('doctor.appointments')
            ->with('success', 'Appointment cancelled.');
    }

    public function edit(Appointment $appointment)
    {
        $doctor = $this->getDoctor();

        if (!$doctor || $appointment->doctor_id !== $doctor->id) {
            abort(403);
        }

        $patients = Patient::where('status', 'Active')->orderBy('full_name')->get();
        $services = Service::orderBy('service_name')->get();

        return view('doctor.appointments.edit', compact('appointment', 'doctor', 'patients', 'services'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $doctor = $this->getDoctor();

        if (!$doctor || $appointment->doctor_id !== $doctor->id) {
            abort(403);
        }

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'service_id' => 'required|exists:services,id',
            'status'     => 'required|in:Scheduled,Completed,Cancelled',
            'date'       => 'required|date',
            'time'       => 'required',
        ]);

        $appointment->update($request->only([
            'patient_id', 'service_id', 'status', 'date', 'time',
        ]));

        return redirect()->route('doctor.appointments')
            ->with('success', 'Appointment updated successfully.');
    }
}
