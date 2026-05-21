<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Admin\PatientController as AdminPatientController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Doctor\AppointmentController as DoctorAppointmentController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;
use App\Http\Controllers\Patient\PaymentController as PatientPaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Root — show welcome page, redirect to dashboard if already authenticated
Route::get('/', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;
        if ($role === 'admin')   return redirect()->route('admin.dashboard');
        if ($role === 'doctor')  return redirect()->route('doctor.dashboard');
        return redirect()->route('patient.dashboard');
    }
    return view('welcome');
})->name('home');

// Admin Routes 
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Patients
    Route::resource('patients', AdminPatientController::class)->except(['show']);

    // Doctors
    Route::resource('doctors', AdminDoctorController::class)->except(['show']);

    // Services
    Route::resource('services', AdminServiceController::class)->except(['show']);

    // Appointments
    Route::resource('appointments', AdminAppointmentController::class)->except(['show']);

    // User Accounts
    Route::resource('users', AdminUserController::class)->except(['show']);

    // Payments (view only for admin)
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [AdminPaymentController::class, 'show'])->name('payments.show');
});

// Doctor Routes
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
    Route::get('/appointments', [DoctorController::class, 'appointments'])->name('appointments');
    Route::get('/appointments/book', [DoctorAppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments/book', [DoctorAppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}/edit', [DoctorAppointmentController::class, 'edit'])->name('appointments.edit');
    Route::patch('/appointments/{appointment}', [DoctorAppointmentController::class, 'update'])->name('appointments.update');
    Route::patch('/appointments/{appointment}/cancel', [DoctorAppointmentController::class, 'cancel'])->name('appointments.cancel');
});

// Patient Routes
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
    Route::get('/appointments', [PatientController::class, 'appointments'])->name('appointments');
    Route::get('/appointments/book', [PatientAppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments/book', [PatientAppointmentController::class, 'store'])->name('appointments.store');
    Route::patch('/appointments/{appointment}/cancel', [PatientAppointmentController::class, 'cancel'])->name('appointments.cancel');

    // Payments
    Route::get('/payments', [PatientPaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}/receipt', [PatientPaymentController::class, 'show'])->name('payments.receipt');
    Route::get('/appointments/{appointment}/pay', [PatientPaymentController::class, 'create'])->name('appointments.pay');
    Route::post('/appointments/{appointment}/pay', [PatientPaymentController::class, 'store'])->name('appointments.pay.store');
});

//  Profile (all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
