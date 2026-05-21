@extends('layouts.admin')
@section('title', 'Add Patient')

@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('admin.patients.index') }}" class="btn-cancel"><i class="bi bi-arrow-left"></i></a>
    <h1 class="mb-0">Add Patient</h1>
</div>

<form action="{{ route('admin.patients.store') }}" method="POST" class="product-form">
    @csrf

    <div class="form-row-grid">
        <div class="form-group">
            <label for="full_name">Full Name <span class="text-danger">*</span></label>
            <input type="text" id="full_name" name="full_name"
                   value="{{ old('full_name') }}" placeholder="e.g. John Doe" required>
            @error('full_name')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="email">Email Address <span class="text-danger">*</span></label>
            <input type="email" id="email" name="email"
                   value="{{ old('email') }}" placeholder="e.g. john@email.com" required>
            @error('email')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="form-row-grid">
        <div class="form-group">
            <label for="phone">Phone Number <span class="text-danger">*</span></label>
            <input type="text" id="phone" name="phone"
                   value="{{ old('phone') }}" placeholder="e.g. 0911000000" required>
            @error('phone')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
            <input type="date" id="date_of_birth" name="date_of_birth"
                   value="{{ old('date_of_birth') }}" required>
            @error('date_of_birth')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="form-row-grid">
        <div class="form-group">
            <label for="gender">Gender <span class="text-danger">*</span></label>
            <select id="gender" name="gender" class="form-select-styled" required>
                <option value="">— Select Gender —</option>
                @foreach(['Male','Female','Other'] as $g)
                    <option value="{{ $g }}" {{ old('gender') === $g ? 'selected' : '' }}>{{ $g }}</option>
                @endforeach
            </select>
            @error('gender')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select id="status" name="status" class="form-select-styled" required>
                <option value="Active"  {{ old('status','Active') === 'Active'   ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ old('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="form-group mb-3">
        <label for="address">Address</label>
        <input type="text" id="address" name="address"
               value="{{ old('address') }}" placeholder="e.g. 123 Main Street">
        @error('address')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
    </div>

    <div class="form-group mb-4">
        <label for="medical_note">Medical Notes</label>
        <textarea id="medical_note" name="medical_note" class="form-group"
                  placeholder="Any known allergies, conditions, etc.">{{ old('medical_note') }}</textarea>
        @error('medical_note')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn-submit"> Save Patient</button>
        <a href="{{ route('admin.patients.index') }}" class="btn-cancel">Cancel</a>
    </div>
</form>
@endsection
