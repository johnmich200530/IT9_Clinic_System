@extends('layouts.doctor')
@section('title', 'My Appointments')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0">My Appointments</h1>
    <a href="{{ route('doctor.appointments.create') }}" class="btn-submit">
         Book Appointment
    </a>
</div>

@if(!$doctor)
    <div class="alert alert-warning">
        
        Your account is not linked to a doctor profile. Please contact the administrator.
    </div>
@else
    <div class="table-responsive">
        <table class="product-table">
            <thead>
                <tr>

                    <th>Patient</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appt)
                <tr>

                    <td class="td-name">{{ $appt->patient->full_name ?? '—' }}</td>
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
                        @if($appt->status === 'Scheduled')
                            <a href="{{ route('doctor.appointments.edit', $appt) }}" class="btn-edit">
                                Edit
                            </a>
                            <form action="{{ route('doctor.appointments.cancel', $appt) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Cancel this appointment?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-delete">
                                     Cancel
                                </button>
                            </form>
                        @else
                            <span style="color:#9CA3AF;font-size:13px;">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No appointments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endif
@endsection
