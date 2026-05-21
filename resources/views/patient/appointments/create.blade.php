@extends('layouts.patient')
@section('title', 'Book Appointment')

@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('patient.appointments') }}" class="btn-cancel"><i class="bi bi-arrow-left"></i></a>
    <h1 class="mb-0">Book Appointment</h1>
</div>

@if(!$patient)
    <div class="alert alert-warning">
        
        Your account is not linked to a patient profile. Please contact the clinic.
    </div>
@else
    <form action="{{ route('patient.appointments.store') }}" method="POST" class="product-form">
        @csrf

        {{-- Patient is fixed to the logged-in patient --}}
        <div class="mb-3 p-3" style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:10px;font-size:14px;">
            
            Booking for: <strong>{{ $patient->full_name }}</strong>
        </div>

        <div class="form-row-grid">
            <div class="form-group">
                <label for="doctor_id">Doctor <span class="text-danger">*</span></label>
                <select id="doctor_id" name="doctor_id" class="form-select-styled" required>
                    <option value="">Select Doctor</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->full_name }} — {{ $doctor->specialization }}
                        </option>
                    @endforeach
                </select>
                @error('doctor_id')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="service_id">Service <span class="text-danger">*</span></label>
                <select id="service_id" name="service_id" class="form-select-styled" required>
                    <option value="">Select Service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->service_name }} — {{ number_format($service->price, 2) }}
                        </option>
                    @endforeach
                </select>
                @error('service_id')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="form-row-grid">
            <div class="form-group">
                <label for="date">Date <span class="text-danger">*</span></label>
                <input type="date" id="date" name="date"
                       value="{{ old('date') }}"
                       min="{{ date('Y-m-d') }}" required>
                @error('date')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="time">Time <span class="text-danger">*</span></label>
                <input type="time" id="time" name="time"
                       value="{{ old('time') }}" required>
                @error('time')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn-submit">
                Confirm Booking
            </button>
            <a href="{{ route('patient.appointments') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
@endif
@endsection
