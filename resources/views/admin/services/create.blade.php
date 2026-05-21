@extends('layouts.admin')
@section('title', 'Add Service')

@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('admin.services.index') }}" class="btn-cancel"><i class="bi bi-arrow-left"></i></a>
    <h1 class="mb-0">Add Service</h1>
</div>

<form action="{{ route('admin.services.store') }}" method="POST" class="product-form">
    @csrf

    <div class="form-row-grid">
        <div class="form-group">
            <label for="service_name">Service Name <span class="text-danger">*</span></label>
            <input type="text" id="service_name" name="service_name"
                   value="{{ old('service_name') }}" placeholder="e.g. General Consultation" required>
            @error('service_name')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="price">Price <span class="text-danger">*</span></label>
            <input type="number" id="price" name="price" step="0.01" min="0"
                   value="{{ old('price') }}" placeholder="e.g. 500.00" required>
            @error('price')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="form-row-grid">
        <div class="form-group">
            <label for="duration">Duration <span class="text-danger">*</span></label>
            <input type="text" id="duration" name="duration"
                   value="{{ old('duration') }}" placeholder="e.g. 30 mins" required>
            @error('duration')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="form-group mb-4">
        <label for="description">Description</label>
        <textarea id="description" name="description" class="form-group"
                  placeholder="Brief description of the service...">{{ old('description') }}</textarea>
        @error('description')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn-submit"> Save Service</button>
        <a href="{{ route('admin.services.index') }}" class="btn-cancel">Cancel</a>
    </div>
</form>
@endsection
