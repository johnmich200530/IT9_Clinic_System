<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Appointment Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>

{{-- ── Navbar ── --}}
<section class="hero">
    <nav class="top-nav">
        <a href="/" class="brand">
            <i class="bi bi-heart-pulse-fill" style="color:#818cf8;font-size:22px;"></i>
            Clinic Management
        </a>
        <div class="nav-links">
            @auth
                <a href="
                    @if(auth()->user()->role === 'admin') {{ route('admin.dashboard') }}
                    @elseif(auth()->user()->role === 'doctor') {{ route('doctor.dashboard') }}
                    @else {{ route('patient.dashboard') }}
                    @endif
                " class="btn-dashboard">
                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-login">Log In</a>
            @endauth
        </div>
    </nav>

    {{-- ── Hero Body ── --}}
    <div class="hero-body">
        <div class="hero-badge">
            <i class="bi bi-shield-check-fill" style="color:#86efac;"></i>
            Trusted Clinic Management System
        </div>
        <h1 class="hero-title">
            Modern Healthcare,<br>
            <span>Simplified Appointments</span>
        </h1>
        <p class="hero-subtitle">
            A complete clinic management platform for admins, doctors, and patients.
            Book appointments, manage records, and track payments — all in one place.
        </p>
        <div class="hero-cta">
            @auth
                <a href="
                    @if(auth()->user()->role === 'admin') {{ route('admin.dashboard') }}
                    @elseif(auth()->user()->role === 'doctor') {{ route('doctor.dashboard') }}
                    @else {{ route('patient.dashboard') }}
                    @endif
                " class="btn-primary-hero">
                    <i class="bi bi-speedometer2 me-1"></i> Go to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-primary-hero">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Get Started
                </a>
                <a href="#features" class="btn-outline-hero">
                    <i class="bi bi-info-circle me-1"></i> Learn More
                </a>
            @endauth
        </div>

        {{-- Stats row --}}
        <div class="d-flex gap-4 mt-5 flex-wrap justify-content-center">
            <div style="text-align:center;">
                <div style="font-size:28px;font-weight:800;color:#fff;">3</div>
                <div style="font-size:12px;color:rgba(255,255,255,.6);font-weight:500;">User Roles</div>
            </div>
            <div style="width:1px;background:rgba(255,255,255,.15);"></div>
            <div style="text-align:center;">
                <div style="font-size:28px;font-weight:800;color:#fff;">100%</div>
                <div style="font-size:12px;color:rgba(255,255,255,.6);font-weight:500;">Web Based</div>
            </div>
            <div style="width:1px;background:rgba(255,255,255,.15);"></div>
            <div style="text-align:center;">
                <div style="font-size:28px;font-weight:800;color:#fff;">24/7</div>
                <div style="font-size:12px;color:rgba(255,255,255,.6);font-weight:500;">Access</div>
            </div>
        </div>
    </div>
</section>

{{-- ── Features Section ── --}}
<section class="features-section" id="features">
    <div class="features-container">
        <div class="section-label">What We Offer</div>
        <h2 class="section-title">Everything you need to run a clinic</h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon feature-icon--indigo">
                        <i class="bi bi-calendar-check-fill" style="color:#4F46E5;"></i>
                    </div>
                    <h5>Appointment Booking</h5>
                    <p>Patients can book appointments online. Admins and doctors can manage, reschedule, or cancel with ease.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon feature-icon--green">
                        <i class="bi bi-people-fill" style="color:#059669;"></i>
                    </div>
                    <h5>Patient Management</h5>
                    <p>Maintain complete patient profiles including medical notes, contact info, and appointment history.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon feature-icon--amber">
                        <i class="bi bi-person-badge-fill" style="color:#D97706;"></i>
                    </div>
                    <h5>Doctor Profiles</h5>
                    <p>Manage doctor specializations, availability, and link them to user accounts for portal access.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon feature-icon--red">
                        <i class="bi bi-cash-coin" style="color:#DC2626;"></i>
                    </div>
                    <h5>Payment Tracking</h5>
                    <p>Record and track payments per appointment. Generate printable receipts for patients instantly.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon feature-icon--emerald">
                        <i class="bi bi-clipboard2-pulse-fill" style="color:#059669;"></i>
                    </div>
                    <h5>Service Catalog</h5>
                    <p>Define clinic services with pricing and duration. Patients see available services when booking.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon feature-icon--blue">
                        <i class="bi bi-person-lock" style="color:#2563EB;"></i>
                    </div>
                    <h5>Role-Based Access</h5>
                    <p>Separate portals for admins, doctors, and patients — each with the right tools and permissions.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Roles Section ── --}}
<section class="roles-section">
    <div class="roles-container">
        <div class="section-label">Who Uses It</div>
        <h2 class="section-title">Built for every role in the clinic</h2>

        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="role-card">
                    <div class="role-icon role-icon--indigo">
                        <i class="bi bi-shield-fill-check" style="color:#4F46E5;font-size:26px;"></i>
                    </div>
                    <h5>Admin</h5>
                    <p>Full control over patients, doctors, services, appointments, user accounts, and payment records.</p>
                    <span class="role-badge role-badge--indigo">Full Access</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="role-card">
                    <div class="role-icon role-icon--green">
                        <i class="bi bi-person-badge-fill" style="color:#059669;font-size:26px;"></i>
                    </div>
                    <h5>Doctor</h5>
                    <p>View and manage assigned appointments, update statuses, and book new appointments for patients.</p>
                    <span class="role-badge role-badge--green">Appointments</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="role-card">
                    <div class="role-icon role-icon--amber">
                        <i class="bi bi-person-heart" style="color:#D97706;font-size:26px;"></i>
                    </div>
                    <h5>Patient</h5>
                    <p>Book appointments, view upcoming schedules, make payments, and download receipts anytime.</p>
                    <span class="role-badge role-badge--amber">Self-Service</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── CTA Banner ── --}}
<section style="background:linear-gradient(135deg,#070830 0%,#1a1f6e 60%,#2d3494 100%);padding:70px 24px;text-align:center;">
    <h2 style="font-size:clamp(24px,3vw,36px);font-weight:800;color:#fff;margin-bottom:14px;">
        Ready to get started?
    </h2>
    <p style="color:rgba(255,255,255,.7);font-size:16px;margin-bottom:32px;max-width:480px;margin-left:auto;margin-right:auto;">
        Log in to access your portal and manage your clinic appointments today.
    </p>
    @guest
        <a href="{{ route('login') }}" class="btn-primary-hero" style="font-size:16px;padding:14px 40px;">
            <i class="bi bi-box-arrow-in-right me-2"></i>Log In Now
        </a>
    @else
        <a href="
            @if(auth()->user()->role === 'admin') {{ route('admin.dashboard') }}
            @elseif(auth()->user()->role === 'doctor') {{ route('doctor.dashboard') }}
            @else {{ route('patient.dashboard') }}
            @endif
        " class="btn-primary-hero" style="font-size:16px;padding:14px 40px;">
            <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
        </a>
    @endguest
</section>

{{-- ── Footer ── --}}
<footer class="site-footer">
    <p style="margin:0;">
        &copy; {{ date('Y') }} Clinic Appointment Management System.
        Built with <i class="bi bi-heart-fill" style="color:#f87171;font-size:11px;"></i> for better healthcare.
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
