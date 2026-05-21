@extends('layouts.admin')
@section('title', 'Add Account')

@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('admin.users.index') }}" class="btn-cancel"><i class="bi bi-arrow-left"></i></a>
    <h1 class="mb-0">Add User Account</h1>
</div>

<form action="{{ route('admin.users.store') }}" method="POST" class="product-form">
    @csrf

    <div class="form-row-grid">
        <div class="form-group">
            <label for="name">Full Name <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name"
                   value="{{ old('name') }}"
                   placeholder="e.g. Dr. Jane Smith"
                   required>
            @error('name')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="email">Email Address <span class="text-danger">*</span></label>
            <input type="email" id="email" name="email"
                   value="{{ old('email') }}"
                   placeholder="e.g. jane@clinic.com"
                   required>
            @error('email')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="form-row-grid">
        <div class="form-group">
            <label for="role">Role <span class="text-danger">*</span></label>
            <select id="role" name="role" class="form-select-styled" required>
                <option value="">— Select Role —</option>
                <option value="admin"   {{ old('role') === 'admin'   ? 'selected' : '' }}>Admin</option>
                <option value="doctor"  {{ old('role') === 'doctor'  ? 'selected' : '' }}>Doctor / Receptionist</option>
                <option value="patient" {{ old('role') === 'patient' ? 'selected' : '' }}>Patient</option>
            </select>
            @error('role')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
    </div>

    <hr>

    <div class="form-row-grid">
        <div class="form-group">
            <label for="password">Password <span class="text-danger">*</span></label>
            <input type="password" id="password" name="password"
                   placeholder="Min. 8 characters"
                   required autocomplete="new-password">
            @error('password')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   placeholder="Re-enter password"
                   required autocomplete="new-password">
        </div>
    </div>

    {{-- Role hint --}}
    <div class="mb-4 p-3" style="background:#F8FAFC;border:1px solid #E2E8F0;border-radius:10px;font-size:13px;color:#64748B;">
        
        <strong>Note:</strong> For <em>Doctor</em> or <em>Patient</em> accounts, make sure a matching
        profile record exists in the Doctors or Patients section with the same email address.
        The portal links accounts by email.
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn-submit"> Create Account</button>
        <a href="{{ route('admin.users.index') }}" class="btn-cancel">Cancel</a>
    </div>
</form>
@endsection
