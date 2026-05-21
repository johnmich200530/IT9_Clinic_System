<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — Clinic Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

<div class="login-page">

    {{-- Left decorative panel --}}
    <div class="login-panel-left d-none d-lg-flex">
        <div class="login-panel-left__inner">
            <a href="/" class="login-brand">
                <i class="bi bi-hospital-fill login-brand__icon"></i>
                <span class="login-brand__text">Clinic Appointment Management System</span>
            </a>
            <h2 class="login-panel-left__title">
                Welcome<br>back.
            </h2>
            <p class="login-panel-left__sub">
                <i class="bi bi-shield-check me-2" style="color:#7dd3fc;"></i>Secure access for clinic staff and patients.
            </p>
            <div class="login-roles">
                <div class="login-role">
                    <i class="bi bi-person-badge-fill" style="font-size:18px;color:#7dd3fc;"></i>
                    <span>Doctors — manage schedules &amp; appointments</span>
                </div>
                <div class="login-role">
                    <i class="bi bi-people-fill" style="font-size:18px;color:#93c5fd;"></i>
                    <span>Patients — book &amp; track appointments</span>
                </div>
                <div class="login-role">
                    <i class="bi bi-gear-fill" style="font-size:18px;color:#a5b4fc;"></i>
                    <span>Admins — full system control</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Right form panel --}}
    <div class="login-panel-right">
        <div class="login-form-wrap">


            <h3 class="login-form-title">Sign In</h3>
            <p class="login-form-sub">Enter your credentials to continue.</p>

            {{-- Session status (e.g. password reset success) --}}
            @if(session('status'))
                <div class="alert alert-success py-2 mb-3">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Validation errors --}}
            @if($errors->any())
                <div class="alert alert-danger py-2 mb-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="login-field">
                    <label for="email">Email</label>
                    <div class="login-input-wrap">
                        <i class="bi bi-envelope-fill login-input-icon"></i>
                        <input type="email" id="email" name="email"
                               value="{{ old('email') }}"
                               placeholder="your@email.com"
                               class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                               required autofocus autocomplete="username">
                    </div>
                </div>

                <div class="login-field">
                    <label for="password">Password</label>
                    <div class="login-input-wrap">
                        <i class="bi bi-lock-fill login-input-icon"></i>
                        <input type="password" id="password" name="password"
                               placeholder="Enter your password"
                               class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                               required autocomplete="current-password">
                    </div>
                </div>
                  <div class="login-remember">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
                 <div class="login-field__header">
                        @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}"  class="login-forgot" >Forgot password?</a>
                        @endif
                    </div>
                    
                <button type="submit" class="login-btn-submit">
                    Sign In
                </button>

                <p class="login-register-link">
                    New patient?
                    <a href="{{ route('register') }}">Create an account</a>
                </p>
            </form>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
