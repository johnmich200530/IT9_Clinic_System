<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private function getPatient()
    {
        return Patient::where('email', auth()->user()->email)->first();
    }

    /** List all payments for the logged-in patient */
    public function index()
    {
        $patient = $this->getPatient();

        $payments = $patient
            ? Payment::with(['appointment.doctor', 'appointment.service'])
                ->where('patient_id', $patient->id)
                ->orderBy('id', 'asc')
                ->get()
            : collect();

        return view('patient.payments.index', compact('payments', 'patient'));
    }

    /** Show the payment form for a specific appointment */
    public function create(Appointment $appointment)
    {
        $patient = $this->getPatient();

        // Must own this appointment
        if (!$patient || $appointment->patient_id !== $patient->id) {
            abort(403);
        }

        // Already paid
        if ($appointment->isPaid()) {
            return redirect()->route('patient.payments.index')
                ->with('error', 'This appointment has already been paid.');
        }

        // Must be Scheduled or Completed to pay
        if ($appointment->status === 'Cancelled') {
            return redirect()->route('patient.payments.index')
                ->with('error', 'Cannot pay for a cancelled appointment.');
        }

        $appointment->load(['service', 'doctor']);

        return view('patient.payments.create', compact('appointment', 'patient'));
    }

    /** Store the payment */
    public function store(Request $request, Appointment $appointment)
    {
        $patient = $this->getPatient();

        if (!$patient || $appointment->patient_id !== $patient->id) {
            abort(403);
        }

        if ($appointment->isPaid()) {
            return redirect()->route('patient.payments.index')
                ->with('error', 'This appointment has already been paid.');
        }

        $request->validate([
            'method'    => 'required|in:Cash,Card,Bank Transfer',
            'notes'     => 'nullable|string|max:500',
        ]);

        Payment::create([
            'appointment_id' => $appointment->id,
            'patient_id'     => $patient->id,
            'amount'         => $appointment->service->price,
            'method'         => $request->method,
            'status'         => 'Paid',
            'notes'          => $request->notes,
        ]);

        return redirect()->route('patient.payments.index')
            ->with('success', 'Payment of ' . number_format($appointment->service->price, 2) . ' recorded successfully.');
    }

    /** Receipt view */
    public function show(Payment $payment)
    {
        $patient = $this->getPatient();

        if (!$patient || $payment->patient_id !== $patient->id) {
            abort(403);
        }

        $payment->load(['appointment.service', 'appointment.doctor', 'patient']);

        return view('patient.payments.receipt', compact('payment'));
    }
}
