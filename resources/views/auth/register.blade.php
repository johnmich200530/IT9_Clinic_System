<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration — Clinic Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>

<div class="register-page">

    {{-- Left panel --}}
    <div class="register-panel-left d-none d-lg-flex">
        <div class="register-panel-left__inner">
            <a href="/" class="register-brand">
                
                <span class="register-brand__text">Clinic Management</span>
            </a>
            <h2 class="register-panel-left__title">
                Your health,<br>our priority.
            </h2>
            <p class="register-panel-left__sub">
                Create your patient account to view appointments,
                track your visit history, and stay connected with your care team.
            </p>
            <div class="register-features">
                <div class="register-feature">
                    <div class="register-feature__icon">
                        
                    </div>
                    <div>
                        <div class="register-feature__title">Track Appointments</div>
                        <div class="register-feature__sub">View upcoming and past visits</div>
                    </div>
                </div>
                <div class="register-feature">
                    <div class="register-feature__icon">
                        
                    </div>
                    <div>
                        <div class="register-feature__title">Know Your Doctor</div>
                        <div class="register-feature__sub">See who's assigned to your care</div>
                    </div>
                </div>
                <div class="register-feature">
                    <div class="register-feature__icon">
                        
                    </div>
                    <div>
                        <div class="register-feature__title">Secure & Private</div>
                        <div class="register-feature__sub">Your data is always protected</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right panel (form) --}}
    <div class="register-panel-right">
        <div class="register-form-wrap">

            {{-- Mobile brand --}}
            <a href="/" class="register-brand register-brand--mobile d-flex d-lg-none">
                
                <span class="register-brand__text">Clinic Management</span>
            </a>

            <h3 class="register-form-title">Create Patient Account</h3>
            <p class="register-form-sub">Fill in your details to get started.</p>

            {{-- Session errors --}}
            @if($errors->any())
                <div class="alert alert-danger py-2 mb-3">
                    
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Row 1: Name + Email --}}
                <div class="reg-row">
                    <div class="reg-field">
                        <label for="name">Full Name <span class="req">*</span></label>
                        <div class="reg-input-wrap">
                            
                            <input type="text" id="name" name="name"
                                   value="{{ old('name') }}"
                                   placeholder="e.g. John Doe"
                                   class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                                   required autofocus>
                        </div>
                        @error('name')
                            <span class="reg-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="reg-field">
                        <label for="email">Email Address <span class="req">*</span></label>
                        <div class="reg-input-wrap">
                            
                            <input type="email" id="email" name="email"
                                   value="{{ old('email') }}"
                                   placeholder="e.g. john@email.com"
                                   class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                                   required>
                        </div>
                        @error('email')
                            <span class="reg-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Row 2: Phone + Date of Birth --}}
                <div class="reg-row">
                    <div class="reg-field">
                        <label for="phone">Phone Number <span class="req">*</span></label>
                        <div class="reg-input-wrap">
                            
                            <input type="text" id="phone" name="phone"
                                   value="{{ old('phone') }}"
                                   placeholder="e.g. 0911000000"
                                   class="{{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                   required>
                        </div>
                        @error('phone')
                            <span class="reg-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="reg-field">
                        <label for="date_of_birth">Date of Birth <span class="req">*</span></label>
                        <div class="reg-input-wrap">
                            
                            <input type="date" id="date_of_birth" name="date_of_birth"
                                   value="{{ old('date_of_birth') }}"
                                   class="{{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}"
                                   required>
                        </div>
                        @error('date_of_birth')
                            <span class="reg-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Row 3: Gender + Address --}}
                <div class="reg-row">
                    <div class="reg-field">
                        <label for="gender">Gender <span class="req">*</span></label>
                        <div class="reg-input-wrap reg-input-wrap--select">
                            
                            <select id="gender" name="gender"
                                    class="{{ $errors->has('gender') ? 'is-invalid' : '' }}"
                                    required>
                                <option value="">— Select —</option>
                                @foreach(['Male','Female','Other'] as $g)
                                    <option value="{{ $g }}" {{ old('gender') === $g ? 'selected' : '' }}>{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('gender')
                            <span class="reg-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="reg-field">
                        <label for="address">Address</label>
                        <div class="reg-input-wrap">
                            
                            <input type="text" id="address" name="address"
                                   value="{{ old('address') }}"
                                   placeholder="e.g. 123 Main Street">
                        </div>
                        @error('address')
                            <span class="reg-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Row 4: Password + Confirm --}}
                <div class="reg-row">
                    <div class="reg-field">
                        <label for="password">Password <span class="req">*</span></label>
                        <div class="reg-input-wrap">
                            
                            <input type="password" id="password" name="password"
                                   placeholder="Min. 8 characters"
                                   class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                                   required autocomplete="new-password">
                        </div>
                        @error('password')
                            <span class="reg-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="reg-field">
                        <label for="password_confirmation">Confirm Password <span class="req">*</span></label>
                        <div class="reg-input-wrap">
                            
                            <input type="password" id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="Re-enter password"
                                   required autocomplete="new-password">
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="reg-btn-submit">
                    Create My Account
                </button>

                <p class="reg-login-link">
                    Already have an account?
                    <a href="{{ route('login') }}">Sign in here</a>
                </p>
            </form>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
