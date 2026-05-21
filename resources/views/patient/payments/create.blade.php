@extends('layouts.patient')
@section('title', 'Pay for Appointment')

@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('patient.appointments') }}" class="btn-cancel"><i class="bi bi-arrow-left"></i></a>
    <h1 class="mb-0">Pay for Appointment</h1>
</div>

{{-- Appointment Summary --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h6 style="font-weight:700;color:#1E3A5F;margin-bottom:16px;">
            Appointment Summary
        </h6>
        <div class="row g-3">
            <div class="col-sm-6 col-md-3">
                <div style="font-size:12px;color:#6B7280;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Service</div>
                <div style="font-size:15px;font-weight:600;color:#0f172a;margin-top:4px;">
                    {{ $appointment->service->service_name }}
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div style="font-size:12px;color:#6B7280;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Doctor</div>
                <div style="font-size:15px;font-weight:600;color:#0f172a;margin-top:4px;">
                    {{ $appointment->doctor->full_name ?? '—' }}
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div style="font-size:12px;color:#6B7280;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Date & Time</div>
                <div style="font-size:15px;font-weight:600;color:#0f172a;margin-top:4px;">
                    {{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}
                    at {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div style="font-size:12px;color:#6B7280;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Amount Due</div>
                <div style="font-size:22px;font-weight:800;color:#4F46E5;margin-top:4px;">
                    {{ number_format($appointment->service->price, 2) }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Payment Form --}}
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h6 style="font-weight:700;color:#1E3A5F;margin-bottom:20px;">
            Payment Details
        </h6>

        <form action="{{ route('patient.appointments.pay.store', $appointment) }}" method="POST" class="product-form">
            @csrf

            <div class="form-row-grid">
                <div class="form-group">
                    <label for="method">Payment Method <span class="text-danger">*</span></label>
                    <select id="method" name="method" class="form-select-styled" required>
                        <option value=""> Select Method </option>
                        <option value="Cash">         {{ old('method') === 'Cash'          ? 'selected' : '' }}
                            Cash
                        </option>
                        <option value="Card">          {{ old('method') === 'Card'          ? 'selected' : '' }}
                            Card
                        </option>
                        <option value="Bank Transfer"> {{ old('method') === 'Bank Transfer' ? 'selected' : '' }}
                            Bank Transfer
                        </option>
                    </select>
                    @error('method')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
                </div>
    
            </div>

            <div class="form-group mb-4">
                <label for="notes">Notes (optional)</label>
                <textarea id="notes" name="notes" class="form-group"
                          placeholder="Any additional notes...">{{ old('notes') }}</textarea>
                @error('notes')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
            </div>

            {{-- Total --}}
            <div class="d-flex align-items-center justify-content-between p-3 mb-4"
                 style="background:#F0FDF4;border:1px solid #BBF7D0;border-radius:10px;">
                <span style="font-size:15px;font-weight:600;color:#065F46;">
                    Total to Pay
                </span>
                <span style="font-size:22px;font-weight:800;color:#059669;">
                    {{ number_format($appointment->service->price, 2) }}
                </span>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn-submit">
                    Confirm Payment
                </button>
                <a href="{{ route('patient.appointments') }}" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
