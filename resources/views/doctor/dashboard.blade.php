@extends('layouts.doctor')
@section('title', 'Doctor Dashboard')

@section('content')
<h1><i class="bi bi-speedometer2 me-2"></i>Doctor Dashboard</h1>

@if(!$doctor)
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        Your account is not linked to a doctor profile. Please contact the administrator.
    </div>
@else
    <p style="color:#6B7280;font-size:14px;margin-bottom:1.5rem;">
        Welcome back, <strong>{{ $doctor->full_name }}</strong> — {{ $doctor->specialization }}
    </p>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-4">
            <div class="card border-0 shadow-sm h-100" style="background:#4F46E5;border-radius:14px;">
                <div class="card-body text-center py-4">
                    <i class="bi bi-calendar-check-fill" style="font-size:28px;color:rgba(255,255,255,0.7);"></i>
                    <div style="font-size:36px;font-weight:800;color:#fff;margin-top:6px;">{{ $totalAppointments }}</div>
                    <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-top:2px;font-weight:500;">Total Appointments</div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card border-0 shadow-sm h-100" style="background:#D97706;border-radius:14px;">
                <div class="card-body text-center py-4">
                    <i class="bi bi-clock-fill" style="font-size:28px;color:rgba(255,255,255,0.7);"></i>
                    <div style="font-size:36px;font-weight:800;color:#fff;margin-top:6px;">{{ $scheduledCount }}</div>
                    <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-top:2px;font-weight:500;">Scheduled</div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card border-0 shadow-sm h-100" style="background:#059669;border-radius:14px;">
                <div class="card-body text-center py-4">
                    <i class="bi bi-check-circle-fill" style="font-size:28px;color:rgba(255,255,255,0.7);"></i>
                    <div style="font-size:36px;font-weight:800;color:#fff;margin-top:6px;">{{ $completedCount }}</div>
                    <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-top:2px;font-weight:500;">Completed</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Today's Appointments --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 style="margin:0;font-weight:700;color:#0f172a;">
                    <i class="bi bi-calendar-day-fill me-2" style="color:#4F46E5;"></i>Today's Appointments
                    <span style="font-size:12px;color:#6B7280;font-weight:400;margin-left:6px;">{{ now()->format('M d, Y') }}</span>
                </h6>
                <a href="{{ route('doctor.appointments') }}" style="font-size:13px;color:#4F46E5;font-weight:500;">View all</a>
            </div>
            @if($todayAppointments->isEmpty())
                <p class="text-muted mb-0" style="font-size:14px;">No appointments scheduled for today.</p>
            @else
                <div class="table-responsive">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Patient</th>
                                <th>Service</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($todayAppointments as $appt)
                            <tr>
                                <td><strong>{{ \Carbon\Carbon::parse($appt->time)->format('h:i A') }}</strong></td>
                                <td class="td-name">{{ $appt->patient->full_name ?? '—' }}</td>
                                <td>{{ $appt->service->service_name ?? '—' }}</td>
                                <td>
                                    @if($appt->status === 'Scheduled')
                                        <span class="badge" style="background:#DBEAFE;color:#1D4ED8;">Scheduled</span>
                                    @elseif($appt->status === 'Completed')
                                        <span class="badge" style="background:#D1FAE5;color:#065F46;">Completed</span>
                                    @else
                                        <span class="badge" style="background:#FEE2E2;color:#991B1B;">Cancelled</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endif
@endsection
