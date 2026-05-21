@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')
<h1><i class="bi bi-speedometer2 me-2"></i>Dashboard</h1>

{{-- Stats Cards --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100" style="background:#4F46E5;border-radius:14px;">
            <div class="card-body text-center py-4">
                <i class="bi bi-people-fill" style="font-size:28px;color:rgba(255,255,255,0.7);"></i>
                <div style="font-size:36px;font-weight:800;color:#fff;margin-top:6px;">{{ $totalPatients }}</div>
                <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-top:2px;font-weight:500;">Total Patients</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100" style="background:#059669;border-radius:14px;">
            <div class="card-body text-center py-4">
                <i class="bi bi-person-badge-fill" style="font-size:28px;color:rgba(255,255,255,0.7);"></i>
                <div style="font-size:36px;font-weight:800;color:#fff;margin-top:6px;">{{ $totalDoctors }}</div>
                <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-top:2px;font-weight:500;">Total Doctors</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100" style="background:#D97706;border-radius:14px;">
            <div class="card-body text-center py-4">
                <i class="bi bi-clipboard2-pulse-fill" style="font-size:28px;color:rgba(255,255,255,0.7);"></i>
                <div style="font-size:36px;font-weight:800;color:#fff;margin-top:6px;">{{ $totalServices }}</div>
                <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-top:2px;font-weight:500;">Total Services</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100" style="background:#DC2626;border-radius:14px;">
            <div class="card-body text-center py-4">
                <i class="bi bi-calendar-check-fill" style="font-size:28px;color:rgba(255,255,255,0.7);"></i>
                <div style="font-size:36px;font-weight:800;color:#fff;margin-top:6px;">{{ $totalAppointments }}</div>
                <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-top:2px;font-weight:500;">Total Appointments</div>
            </div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="mb-3" style="color:#6B7280;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;">Quick Actions</h6>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.patients.create') }}" class="btn btn-sm" style="background:#4F46E5;color:#fff;border-radius:8px;font-weight:500;">
                        <i class="bi bi-person-plus-fill me-1"></i>Add Patient
                    </a>
                    <a href="{{ route('admin.doctors.create') }}" class="btn btn-sm" style="background:#059669;color:#fff;border-radius:8px;font-weight:500;">
                        <i class="bi bi-person-badge me-1"></i>Add Doctor
                    </a>
                    <a href="{{ route('admin.services.create') }}" class="btn btn-sm" style="background:#D97706;color:#fff;border-radius:8px;font-weight:500;">
                        <i class="bi bi-plus-circle-fill me-1"></i>Add Service
                    </a>
                    <a href="{{ route('admin.appointments.create') }}" class="btn btn-sm" style="background:#DC2626;color:#fff;border-radius:8px;font-weight:500;">
                        <i class="bi bi-calendar-plus-fill me-1"></i>New Appointment
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Recent Appointments --}}
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 style="margin:0;font-weight:700;color:#0f172a;">
                <i class="bi bi-clock-history me-2" style="color:#4F46E5;"></i>Recent Appointments
            </h6>
            <a href="{{ route('admin.appointments.index') }}" style="font-size:13px;color:#4F46E5;font-weight:500;">View all</a>
        </div>
        @if($recentAppointments->isEmpty())
            <p class="text-muted mb-0" style="font-size:14px;">No appointments yet.</p>
        @else
            <div class="table-responsive">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Service</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentAppointments as $appt)
                        <tr>
                            <td class="td-id">{{ $appt->id }}</td>
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
