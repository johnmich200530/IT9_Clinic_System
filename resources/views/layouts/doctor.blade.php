<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Doctor') — Clinic Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="has-app-nav">

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

<div class="app-sidebar">
    <a class="app-sidebar__brand" href="{{ route('doctor.dashboard') }}">
        <i class="bi bi-heart-pulse-fill" style="font-size:20px;color:#34d399;"></i>
        <span class="app-sidebar__brand-text">Doctor Portal</span>
    </a>
    <div class="app-sidebar__nav">
        <a href="{{ route('doctor.dashboard') }}"
           class="app-sidebar__link {{ request()->routeIs('doctor.dashboard') ? 'is-active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('doctor.appointments') }}"
           class="app-sidebar__link {{ request()->routeIs('doctor.appointments') ? 'is-active' : '' }}">
            <i class="bi bi-calendar-check-fill"></i> My Appointments
        </a>
        <a href="{{ route('doctor.appointments.create') }}"
           class="app-sidebar__link {{ request()->routeIs('doctor.appointments.create') ? 'is-active' : '' }}">
            <i class="bi bi-calendar-plus-fill"></i> Book Appointment
        </a>
    </div>
</div>

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
