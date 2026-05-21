@extends('layouts.patient')
@section('title', 'Payment Receipt')

@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('patient.payments.index') }}" class="btn-cancel"><i class="bi bi-arrow-left"></i></a>
    <h1 class="mb-0">Payment Receipt</h1>
</div>

<div class="card border-0 shadow-sm" style="max-width:600px;margin:0 auto;">
    <div class="card-body p-4">

        {{-- Header --}}
        <div class="text-center mb-4 pb-3" style="border-bottom:2px dashed #E5E7EB;">
            <div style="font-size:40px;"></div>
            <h4 style="font-weight:800;color:#070830;margin:8px 0 4px;">Clinic Management</h4>
            <p style="color:#6B7280;font-size:13px;margin:0;">Official Payment Receipt</p>
        </div>

        {{-- Receipt Meta --}}
        <div class="d-flex justify-content-between mb-3">
            <div>
                <div style="font-size:12px;color:#6B7280;font-weight:600;text-transform:uppercase;">Receipt No.</div>
                <div style="font-size:15px;font-weight:700;color:#0f172a;">#{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="text-end">
                <div style="font-size:12px;color:#6B7280;font-weight:600;text-transform:uppercase;">Date</div>
                <div style="font-size:15px;font-weight:700;color:#0f172a;">{{ $payment->created_at->format('M d, Y') }}</div>
            </div>
        </div>

        {{-- Patient --}}
        <div class="mb-3 p-3" style="background:#F8FAFC;border-radius:10px;">
            <div style="font-size:12px;color:#6B7280;font-weight:600;text-transform:uppercase;margin-bottom:6px;">Patient</div>
            <div style="font-size:15px;font-weight:600;color:#0f172a;">{{ $payment->patient->full_name }}</div>
            <div style="font-size:13px;color:#6B7280;">{{ $payment->patient->email }}</div>
        </div>

        {{-- Appointment Details --}}
        <div class="mb-3 p-3" style="background:#F8FAFC;border-radius:10px;">
            <div style="font-size:12px;color:#6B7280;font-weight:600;text-transform:uppercase;margin-bottom:10px;">Appointment Details</div>
            <div class="d-flex justify-content-between mb-2">
                <span style="font-size:14px;color:#374151;">Service</span>
                <span style="font-size:14px;font-weight:600;color:#0f172a;">{{ $payment->appointment->service->service_name }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span style="font-size:14px;color:#374151;">Doctor</span>
                <span style="font-size:14px;font-weight:600;color:#0f172a;">{{ $payment->appointment->doctor->full_name ?? '—' }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span style="font-size:14px;color:#374151;">Date & Time</span>
                <span style="font-size:14px;font-weight:600;color:#0f172a;">
                    {{ \Carbon\Carbon::parse($payment->appointment->date)->format('M d, Y') }}
                    at {{ \Carbon\Carbon::parse($payment->appointment->time)->format('h:i A') }}
                </span>
            </div>
        </div>

        {{-- Payment Details --}}
        <div class="mb-4 p-3" style="background:#F8FAFC;border-radius:10px;">
            <div style="font-size:12px;color:#6B7280;font-weight:600;text-transform:uppercase;margin-bottom:10px;">Payment Details</div>
            <div class="d-flex justify-content-between mb-2">
                <span style="font-size:14px;color:#374151;">Method</span>
                <span style="font-size:14px;font-weight:600;color:#0f172a;">{{ $payment->method }}</span>
            </div>
            @if($payment->notes)
            <div class="d-flex justify-content-between">
                <span style="font-size:14px;color:#374151;">Notes</span>
                <span style="font-size:14px;color:#6B7280;">{{ $payment->notes }}</span>
            </div>
            @endif
        </div>

        {{-- Total --}}
        <div class="d-flex justify-content-between align-items-center p-3"
             style="background:#F0FDF4;border:2px solid #BBF7D0;border-radius:10px;">
            <span style="font-size:16px;font-weight:700;color:#065F46;">Total Paid</span>
            <span style="font-size:26px;font-weight:800;color:#059669;">
                {{ number_format($payment->amount, 2) }}
            </span>
        </div>

        {{-- Status stamp --}}
        <div class="text-center mt-4">
            <span class="badge" style="background:#D1FAE5;color:#065F46;font-size:14px;padding:8px 20px;border-radius:20px;">
                PAID
            </span>
        </div>

        {{-- Print button --}}
        <div class="text-center mt-4">
            <button onclick="window.print()" class="btn-submit" style="display:inline-flex;align-items:center;gap:6px;">
                 Print Receipt
            </button>
        </div>

    </div>
</div>
@endsection
