@extends('layouts.admin')
@section('title', 'Patients')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0">Patients</h1>
    <a href="{{ route('admin.patients.create') }}" class="btn-submit">
         Add Patient
    </a>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('admin.patients.index') }}" class="mb-3">
    <div class="search-wrap">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" class="search-input"
               placeholder="Search by name, email or phone…"
               value="{{ $search ?? '' }}">
        @if(!empty($search))
            <a href="{{ route('admin.patients.index') }}" class="search-clear">
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
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($patients as $patient)
            <tr>
                <td class="td-name">{{ $patient->full_name }}</td>
                <td>{{ $patient->email }}</td>
                <td>{{ $patient->phone }}</td>
                <td>{{ $patient->gender }}</td>
                <td>{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') }}</td>
                <td>
                    @if($patient->status === 'Active')
                        <span class="badge" style="background:#D1FAE5;color:#065F46;">Active</span>
                    @else
                        <span class="badge" style="background:#FEE2E2;color:#991B1B;">Inactive</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.patients.edit', $patient) }}" class="btn-edit">
                         Edit
                    </a>
                    <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Delete this patient?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-delete">
                             Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted py-4">No patients found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
