@extends('layouts.patient')
@section('title', 'My Appointments')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="mb-0">My Appointments</h1>
    <a href="{{ route('patient.appointments.create') }}" class="btn-submit">
         Book Appointment
    </a>
</div>

@if(!$patient)
    <div class="alert alert-warning">
        
        Your account is not linked to a patient profile. Please contact the clinic.
    </div>
@else
    <div class="table-responsive">
        <table class="product-table">
            <thead>
                <tr>
                    <th>Doctor</th>
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
                    
                    <td class="td-name">{{ $appt->doctor->full_name ?? '—' }}</td>
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
                            @if(!$appt->isPaid())
                                <form action="{{ route('patient.appointments.cancel', $appt) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Cancel this appointment?')">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-delete">
                                         Cancel
                                    </button>
                                </form>
                                <a href="{{ route('patient.appointments.pay', $appt) }}" class="btn-submit" style="padding:5px 14px;font-size:13px;height:auto;display:inline-block;text-decoration:none;">
                                     Pay
                                </a>
                            @else
                                <span class="badge ms-1" style="background:#D1FAE5;color:#065F46;">
                                    Paid
                                </span>
                            @endif
                        @elseif($appt->status === 'Completed')
                            @if(!$appt->isPaid())
                                <a href="{{ route('patient.appointments.pay', $appt) }}" class="btn-submit" style="padding:5px 14px;font-size:13px;height:auto;display:inline-block;text-decoration:none;">
                                     Pay
                                </a>
                            @else
                                <span class="badge" style="background:#D1FAE5;color:#065F46;">
                                    Paid
                                </span>
                            @endif
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
