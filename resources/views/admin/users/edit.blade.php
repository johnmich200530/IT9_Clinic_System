@extends('layouts.admin')
@section('title', 'Edit Account')

@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('admin.users.index') }}" class="btn-cancel"><i class="bi bi-arrow-left"></i></a>
    <h1 class="mb-0">Edit Account</h1>
</div>

<form action="{{ route('admin.users.update', $user) }}" method="POST" class="product-form">
    @csrf @method('PATCH')

    <div class="form-row-grid">
        <div class="form-group">
            <label for="name">Full Name <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name"
                   value="{{ old('name', $user->name) }}"
                   required>
            @error('name')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="email">Email Address <span class="text-danger">*</span></label>
            <input type="email" id="email" name="email"
                   value="{{ old('email', $user->email) }}"
                   required>
            @error('email')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="form-row-grid">
        <div class="form-group">
            <label for="role">Role <span class="text-danger">*</span></label>
            <select id="role" name="role" class="form-select-styled" required
                {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                <option value="admin"   {{ old('role', $user->role) === 'admin'   ? 'selected' : '' }}>Admin</option>
                <option value="doctor"  {{ old('role', $user->role) === 'doctor'  ? 'selected' : '' }}>Doctor / Receptionist</option>
                <option value="patient" {{ old('role', $user->role) === 'patient' ? 'selected' : '' }}>Patient</option>
            </select>
            {{-- Re-submit role as hidden if disabled (own account) --}}
            @if($user->id === auth()->id())
                <input type="hidden" name="role" value="{{ $user->role }}">
                <span style="font-size:12px;color:#6B7280;">
                    You cannot change your own role.
                </span>
            @endif
            @error('role')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
    </div>

    <hr>

    <p style="font-size:13px;color:#6B7280;margin-bottom:12px;">
        Leave password fields blank to keep the current password.
    </p>

    <div class="form-row-grid">
        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" id="password" name="password"
                   placeholder="Leave blank to keep current"
                   autocomplete="new-password">
            @error('password')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm New Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   placeholder="Re-enter new password"
                   autocomplete="new-password">
        </div>
    </div>

    <div class="d-flex gap-2 mt-3">
        <button type="submit" class="btn-submit"> Update Account</button>
        <a href="{{ route('admin.users.index') }}" class="btn-cancel">Cancel</a>
    </div>
</form>
@endsection
