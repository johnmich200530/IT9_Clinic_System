@extends('layouts.doctor')
@section('title', 'Book Appointment')

@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <h1 class="mb-0">Book Appointment</h1>
</div>

@if(!$doctor)
    <div class="alert alert-warning">
        
        Your account is not linked to a doctor profile. Please contact the administrator.
    </div>
@else
    <form action="{{ route('doctor.appointments.store') }}" method="POST" class="product-form">
        @csrf

        {{-- Doctor is fixed to the logged-in doctor --}}
        <div class="mb-3 p-3" style="background:#F0FDF4;border:1px solid #BBF7D0;border-radius:10px;font-size:14px;">
            
            Booking as: <strong>{{ $doctor->full_name }}</strong>
            <span class="ms-2" style="color:#6B7280;">— {{ $doctor->specialization }}</span>
        </div>

        <div class="form-row-grid">
            <div class="form-group">
                <label for="patient_id">Patient <span class="text-danger">*</span></label>
                <select id="patient_id" name="patient_id" class="form-select-styled" required>
                    <option value="">Select Patient</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                            {{ $patient->full_name }}
                        </option>
                    @endforeach
                </select>
                @error('patient_id')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
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
            <a href="{{ route('doctor.appointments') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
@endif
@endsection
