@extends('layouts.admin')
@section('title', 'Appointments')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0">Appointments</h1>
    <a href="{{ route('admin.appointments.create') }}" class="btn-submit">
         New Appointment
    </a>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('admin.appointments.index') }}" class="mb-3">
    <div class="search-wrap">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" class="search-input"
               placeholder="Search by patient, doctor, service or status…"
               value="{{ $search ?? '' }}">
        @if(!empty($search))
            <a href="{{ route('admin.appointments.index') }}" class="search-clear">
                <i class="bi bi-x-lg"></i>
            </a>
        @endif
    </div>
</form>

<div class="table-responsive">
    <table class="product-table">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Service</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $appt)
            <tr>
                <td class="td-name">{{ $appt->patient->full_name ?? '—' }}</td>
                <td>{{ $appt->doctor->full_name ?? '—' }}</td>
                <td>{{ $appt->service->service_name ?? '—' }}</td>
                <td>{{ \Carbon\Carbon::parse($appt->date)->format('M d, Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($appt->time)->format('h:i A') }}</td>
                <td>
                    @if($appt->status === 'Scheduled')
                        <span class="badge" style="background:#DBEAFE;color:#1D4ED8;">Scheduled</span>
                    @elseif($appt->status === 'Completed')
                        <span class="badge" style="background:#D1FAE5;color:#065F46;">Completed</span>
                    @else
                        <span class="badge" style="background:#FEE2E2;color:#991B1B;">Cancelled</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.appointments.edit', $appt) }}" class="btn-edit">
                         Edit
                    </a>
                    <form action="{{ route('admin.appointments.destroy', $appt) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Delete this appointment?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-delete">
                             Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted py-4">No appointments found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
