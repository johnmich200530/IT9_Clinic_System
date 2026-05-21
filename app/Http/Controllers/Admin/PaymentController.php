<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $payments = Payment::with(['patient', 'appointment.service', 'appointment.doctor'])
            ->when($search, function ($q) use ($search) {
                $q->whereHas('patient', fn($p) => $p->where('full_name', 'like', "%{$search}%"))
                  ->orWhereHas('appointment.service', fn($s) => $s->where('service_name', 'like', "%{$search}%"))
                  ->orWhereHas('appointment.doctor', fn($d) => $d->where('full_name', 'like', "%{$search}%"))
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('method', 'like', "%{$search}%");
            })
            ->orderBy('id', 'asc')
            ->get();

        $totalRevenue  = Payment::where('status', 'Paid')->sum('amount');
        $totalPayments = Payment::count();
        $pendingCount  = Payment::where('status', 'Pending')->count();

        return view('admin.payments.index', compact(
            'payments', 'totalRevenue', 'totalPayments', 'pendingCount', 'search'
        ));
    }

    public function show(Payment $payment)
    {
        $payment->load(['appointment.service', 'appointment.doctor', 'patient']);
        return view('admin.payments.receipt', compact('payment'));
    }
}
