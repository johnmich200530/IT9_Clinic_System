<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Clinic Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="has-app-nav">

{{-- Top Bar --}}
<div class="app-topbar">
    <span class="app-topbar__title">
        <i class="bi bi-hospital me-2"></i>Clinic Appointment Management
    </span>
    <div class="d-flex align-items-center gap-3">
        <span class="app-topbar__user">
            <i class="bi bi-person-circle me-2"></i>{{ auth()->user()->name }}
        </span>
        <form method="POST" action="{{ route('logout') }}" class="app-topbar__logout">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-light">
                <i class="bi bi-box-arrow-right me-1"></i>Logout
            </button>
        </form>
    </div>
</div>

{{-- Sidebar --}}
<div class="app-sidebar">
    <a class="app-sidebar__brand" href="{{ route('admin.dashboard') }}">
        <i class="bi bi-heart-pulse-fill" style="font-size:20px;color:#818cf8;"></i>
        <span class="app-sidebar__brand-text">Clinic Admin</span>
    </a>
    <div class="app-sidebar__nav">
        <a href="{{ route('admin.dashboard') }}"
           class="app-sidebar__link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('admin.patients.index') }}"
           class="app-sidebar__link {{ request()->routeIs('admin.patients.*') ? 'is-active' : '' }}">
            <i class="bi bi-people-fill"></i> Patients
        </a>
        <a href="{{ route('admin.doctors.index') }}"
           class="app-sidebar__link {{ request()->routeIs('admin.doctors.*') ? 'is-active' : '' }}">
            <i class="bi bi-person-badge-fill"></i> Doctors
        </a>
        <a href="{{ route('admin.services.index') }}"
           class="app-sidebar__link {{ request()->routeIs('admin.services.*') ? 'is-active' : '' }}">
            <i class="bi bi-clipboard2-pulse-fill"></i> Services
        </a>
        <a href="{{ route('admin.appointments.index') }}"
           class="app-sidebar__link {{ request()->routeIs('admin.appointments.*') ? 'is-active' : '' }}">
            <i class="bi bi-calendar-check-fill"></i> Appointments
        </a>
        <a href="{{ route('admin.users.index') }}"
           class="app-sidebar__link {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}">
            <i class="bi bi-person-lock"></i> User Accounts
        </a>
        <a href="{{ route('admin.payments.index') }}"
           class="app-sidebar__link {{ request()->routeIs('admin.payments.*') ? 'is-active' : '' }}">
            <i class="bi bi-cash-stack"></i> Payments
        </a>
    </div>
</div>

{{-- Main Content --}}
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
