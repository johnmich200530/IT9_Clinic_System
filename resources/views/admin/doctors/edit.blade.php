@extends('layouts.admin')
@section('title', 'Edit Doctor')

@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('admin.doctors.index') }}" class="btn-cancel"><i class="bi bi-arrow-left"></i></a>
    <h1 class="mb-0">Edit Doctor</h1>
</div>

<form action="{{ route('admin.doctors.update', $doctor) }}" method="POST" class="product-form">
    @csrf @method('PATCH')

    <div class="form-row-grid">
        <div class="form-group">
            <label for="full_name">Full Name <span class="text-danger">*</span></label>
            <input type="text" id="full_name" name="full_name"
                   value="{{ old('full_name', $doctor->full_name) }}" required>
            @error('full_name')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="specialization">Specialization <span class="text-danger">*</span></label>
            <input type="text" id="specialization" name="specialization"
                   value="{{ old('specialization', $doctor->specialization) }}" required>
            @error('specialization')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="form-row-grid">
        <div class="form-group">
            <label for="email">Email Address <span class="text-danger">*</span></label>
            <input type="email" id="email" name="email"
                   value="{{ old('email', $doctor->email) }}" required>
            @error('email')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="phone">Phone Number <span class="text-danger">*</span></label>
            <input type="text" id="phone" name="phone"
                   value="{{ old('phone', $doctor->phone) }}" required>
            @error('phone')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="form-row-grid">
        <div class="form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select id="status" name="status" class="form-select-styled" required>
                <option value="Active"   {{ old('status', $doctor->status) === 'Active'   ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ old('status', $doctor->status) === 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="d-flex gap-2 mt-3">
        <button type="submit" class="btn-submit"> Update Doctor</button>
        <a href="{{ route('admin.doctors.index') }}" class="btn-cancel">Cancel</a>
    </div>
</form>
@endsection
