@extends('layouts.doctor')
@section('title', 'Edit Appointment')

@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('doctor.appointments') }}" class="btn-cancel">Back</a>
    <h1 class="mb-0">Edit Appointment</h1>
</div>

<form action="{{ route('doctor.appointments.update', $appointment) }}" method="POST" class="product-form">
    @csrf @method('PATCH')

    {{-- Doctor is fixed --}}
    <div class="mb-3 p-3" style="background:#F0FDF4;border:1px solid #BBF7D0;border-radius:10px;font-size:14px;">
        Editing as: <strong>{{ $doctor->full_name }}</strong>
        <span class="ms-2" style="color:#6B7280;">— {{ $doctor->specialization }}</span>
    </div>

    <div class="form-row-grid">
        <div class="form-group">
            <label for="patient_id">Patient <span class="text-danger">*</span></label>
            <select id="patient_id" name="patient_id" class="form-select-styled" required>
                <option value="">— Select Patient —</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}"
                        {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}>
                        {{ $patient->full_name }}
                    </option>
                @endforeach
            </select>
            @error('patient_id')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="service_id">Service <span class="text-danger">*</span></label>
            <select id="service_id" name="service_id" class="form-select-styled" required>
                <option value="">— Select Service —</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}"
                        {{ old('service_id', $appointment->service_id) == $service->id ? 'selected' : '' }}>
                        {{ $service->service_name }} ({{ number_format($service->price, 2) }})
                    </option>
                @endforeach
            </select>
            @error('service_id')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="form-row-grid">
        <div class="form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select id="status" name="status" class="form-select-styled" required>
                @foreach(['Scheduled','Completed','Cancelled'] as $s)
                    <option value="{{ $s }}"
                        {{ old('status', $appointment->status) === $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
            @error('status')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="form-row-grid">
        <div class="form-group">
            <label for="date">Date <span class="text-danger">*</span></label>
            <input type="date" id="date" name="date"
                   value="{{ old('date', $appointment->date) }}" required>
            @error('date')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="time">Time <span class="text-danger">*</span></label>
            <input type="time" id="time" name="time"
                   value="{{ old('time', \Carbon\Carbon::parse($appointment->time)->format('H:i')) }}" required>
            @error('time')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="d-flex gap-2 mt-3">
        <button type="submit" class="btn-submit">Update Appointment</button>
        <a href="{{ route('doctor.appointments') }}" class="btn-cancel">Cancel</a>
    </div>
</form>
@endsection
