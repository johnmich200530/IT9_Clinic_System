@extends('layouts.admin')
@section('title', 'Doctors')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0">Doctors</h1>
    <a href="{{ route('admin.doctors.create') }}" class="btn-submit">
         Add Doctor
    </a>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('admin.doctors.index') }}" class="mb-3">
    <div class="search-wrap">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" class="search-input"
               placeholder="Search by name, email or specialization…"
               value="{{ $search ?? '' }}">
        @if(!empty($search))
            <a href="{{ route('admin.doctors.index') }}" class="search-clear">
                <i class="bi bi-x-lg"></i>
            </a>
        @endif
    </div>
</form>

<div class="table-responsive">
    <table class="product-table">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Specialization</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($doctors as $doctor)
            <tr>
                <td class="td-name">{{ $doctor->full_name }}</td>
                <td><span class="category-badge">{{ $doctor->specialization }}</span></td>
                <td>{{ $doctor->email }}</td>
                <td>{{ $doctor->phone }}</td>
                <td>
                    @if($doctor->status === 'Active')
                        <span class="badge" style="background:#D1FAE5;color:#065F46;">Active</span>
                    @else
                        <span class="badge" style="background:#FEE2E2;color:#991B1B;">Inactive</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn-edit">
                         Edit
                    </a>
                    <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Delete this doctor?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-delete">
                             Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted py-4">No doctors found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
