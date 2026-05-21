<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     * Creates a User (role=patient) + a linked Patient record.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone'                 => ['required', 'string', 'max:20', 'unique:patients,phone'],
            'date_of_birth'         => ['required', 'date'],
            'gender'                => ['required', 'in:Male,Female,Other'],
            'address'               => ['nullable', 'string', 'max:500'],
            'password'              => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 1. Create the auth user with patient role
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => 'patient',
            'password' => Hash::make($request->password),
        ]);

        // 2. Create the linked patient profile
        Patient::create([
            'full_name'     => $request->name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender'        => $request->gender,
            'address'       => $request->address,
            'status'        => 'Active',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('patient.dashboard');
    }
}
