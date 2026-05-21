@extends('layouts.admin')
@section('title', 'Services')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0">Services</h1>
    <a href="{{ route('admin.services.create') }}" class="btn-submit">
         Add Service
    </a>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('admin.services.index') }}" class="mb-3">
    <div class="search-wrap">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" class="search-input"
               placeholder="Search by name, description or duration…"
               value="{{ $search ?? '' }}">
        @if(!empty($search))
            <a href="{{ route('admin.services.index') }}" class="search-clear">
                <i class="bi bi-x-lg"></i>
            </a>
        @endif
    </div>
</form>

<div class="table-responsive">
    <table class="product-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Service Name</th>
                <th>Price</th>
                <th>Duration</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
            <tr>
                <td class="td-id">{{ $service->id }}</td>
                <td class="td-name">{{ $service->service_name }}</td>
                <td class="td-price">{{ number_format($service->price, 2) }}</td>
                <td>{{ $service->duration }}</td>
                <td class="td-description-cell">{{ $service->description ?? '—' }}</td>
                <td>
                    <a href="{{ route('admin.services.edit', $service) }}" class="btn-edit">
                         Edit
                    </a>
                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Delete this service?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-delete">
                             Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted py-4">No services found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
