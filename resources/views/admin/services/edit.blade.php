@extends('layouts.admin')
@section('title', 'Edit Service')

@section('content')
<div class="d-flex align-items-center gap-2 mb-3">
    <a href="{{ route('admin.services.index') }}" class="btn-cancel"><i class="bi bi-arrow-left"></i></a>
    <h1 class="mb-0">Edit Service</h1>
</div>

<form action="{{ route('admin.services.update', $service) }}" method="POST" class="product-form">
    @csrf @method('PATCH')

    <div class="form-row-grid">
        <div class="form-group">
            <label for="service_name">Service Name <span class="text-danger">*</span></label>
            <input type="text" id="service_name" name="service_name"
                   value="{{ old('service_name', $service->service_name) }}" required>
            @error('service_name')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="price">Price <span class="text-danger">*</span></label>
            <input type="number" id="price" name="price" step="0.01" min="0"
                   value="{{ old('price', $service->price) }}" required>
            @error('price')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="form-row-grid">
        <div class="form-group">
            <label for="duration">Duration <span class="text-danger">*</span></label>
            <input type="text" id="duration" name="duration"
                   value="{{ old('duration', $service->duration) }}" required>
            @error('duration')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="form-group mb-4">
        <label for="description">Description</label>
        <textarea id="description" name="description" class="form-group">{{ old('description', $service->description) }}</textarea>
        @error('description')<span style="color:#DC2626;font-size:12px;">{{ $message }}</span>@enderror
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn-submit"> Update Service</button>
        <a href="{{ route('admin.services.index') }}" class="btn-cancel">Cancel</a>
    </div>
</form>
@endsection
