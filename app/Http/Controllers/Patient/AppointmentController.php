<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Service;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    private function getPatient()
    {
        return Patient::where('email', auth()->user()->email)->first();
    }

    public function create()
    {
        $patient  = $this->getPatient();
        $doctors  = Doctor::where('status', 'Active')->orderBy('full_name')->get();
        $services = Service::orderBy('service_name')->get();
        return view('patient.appointments.create', compact('patient', 'doctors', 'services'));
    }

    public function store(Request $request)
    {
        $patient = $this->getPatient();

        if (!$patient) {
            return redirect()->route('patient.appointments')
                ->with('error', 'Your account is not linked to a patient profile.');
        }

        $request->validate([
            'doctor_id'  => 'required|exists:doctors,id',
            'service_id' => 'required|exists:services,id',
            'date'       => 'required|date|after_or_equal:today',
            'time'       => 'required',
        ]);

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id'  => $request->doctor_id,
            'service_id' => $request->service_id,
            'date'       => $request->date,
            'time'       => $request->time,
            'status'     => 'Scheduled',
        ]);

        return redirect()->route('patient.appointments')
            ->with('success', 'Appointment booked successfully.');
    }

    public function cancel(Appointment $appointment)
    {
        $patient = $this->getPatient();

        // Only allow cancelling own appointments that are still scheduled
        if (!$patient || $appointment->patient_id !== $patient->id) {
            abort(403);
        }

        if ($appointment->status !== 'Scheduled') {
            return redirect()->route('patient.appointments')
                ->with('error', 'Only scheduled appointments can be cancelled.');
        }

        $appointment->update(['status' => 'Cancelled']);

        return redirect()->route('patient.appointments')
            ->with('success', 'Appointment cancelled.');
    }
}
