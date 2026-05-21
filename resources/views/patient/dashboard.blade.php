@extends('layouts.patient')
@section('title', 'Patient Dashboard')

@section('content')
<h1><i class="bi bi-speedometer2 me-2"></i>Patient Dashboard</h1>

@if(!$patient)
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        Your account is not linked to a patient profile. Please contact the clinic.
    </div>
@else
    <p style="color:#6B7280;font-size:14px;margin-bottom:1.5rem;">
        Welcome, <strong>{{ $patient->full_name }}</strong>
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
                    <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-top:2px;font-weight:500;">Upcoming</div>
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

    {{-- Upcoming Appointments --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 style="margin:0;font-weight:700;color:#0f172a;">
                    <i class="bi bi-calendar-event-fill me-2" style="color:#4F46E5;"></i>Upcoming Appointments
                </h6>
                <a href="{{ route('patient.appointments') }}" style="font-size:13px;color:#4F46E5;font-weight:500;">View all</a>
            </div>
            @if($upcomingAppointments->isEmpty())
                <p class="text-muted mb-0" style="font-size:14px;">No upcoming appointments.</p>
            @else
                <div class="table-responsive">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Doctor</th>
                                <th>Service</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($upcomingAppointments as $appt)
                            <tr>
                                <td><strong>{{ \Carbon\Carbon::parse($appt->date)->format('M d, Y') }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($appt->time)->format('h:i A') }}</td>
                                <td class="td-name">{{ $appt->doctor->full_name ?? '—' }}</td>
                                <td>{{ $appt->service->service_name ?? '—' }}</td>
                                <td>
                                    <span class="badge" style="background:#DBEAFE;color:#1D4ED8;">Scheduled</span>
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
