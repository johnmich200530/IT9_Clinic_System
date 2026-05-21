<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
            })
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.users.index', compact('users', 'search'));
    }

    public function create()
    {
        $doctors  = Doctor::orderBy('full_name')->get();
        $patients = Patient::orderBy('full_name')->get();
        return view('admin.users.create', compact('doctors', 'patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'role'     => ['required', 'in:admin,doctor,patient'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // Link to existing patient/doctor record that shares the same email
        if ($request->role === 'patient') {
            Patient::where('email', $user->email)->whereNull('user_id')->update(['user_id' => $user->id]);
        } elseif ($request->role === 'doctor') {
            Doctor::where('email', $user->email)->whereNull('user_id')->update(['user_id' => $user->id]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Account created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'role'  => ['required', 'in:admin,doctor,patient'],
        ]);

        $oldRole  = $user->role;
        $newRole  = $request->role;
        $oldEmail = $user->email;

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $newRole,
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // ── Find existing linked profiles ──────────────────────────────────
        $linkedPatient = Patient::where('user_id', $user->id)
            ->orWhere(fn($q) => $q->whereNull('user_id')->where('email', $oldEmail))
            ->first();

        $linkedDoctor = Doctor::where('user_id', $user->id)
            ->orWhere(fn($q) => $q->whereNull('user_id')->where('email', $oldEmail))
            ->first();

        // ── Role unchanged: just sync name/email ──────────────────────────
        if ($oldRole === $newRole) {
            if ($newRole === 'patient' && $linkedPatient) {
                $linkedPatient->update(['full_name' => $request->name, 'email' => $request->email, 'user_id' => $user->id]);
            } elseif ($newRole === 'doctor' && $linkedDoctor) {
                $linkedDoctor->update(['full_name' => $request->name, 'email' => $request->email, 'user_id' => $user->id]);
            }
            return redirect()->route('admin.users.index')->with('success', 'Account updated successfully.');
        }

        // ── Role changed ──────────────────────────────────────────────────

        // Detach old profile (nullify user_id — keep the record for history)
        if ($linkedPatient) {
            $linkedPatient->update(['user_id' => null]);
        }
        if ($linkedDoctor) {
            $linkedDoctor->update(['user_id' => null]);
        }

        // patient → doctor: create a doctor profile from the patient data
        if ($oldRole === 'patient' && $newRole === 'doctor') {
            $existing = Doctor::where('email', $request->email)->first();
            if ($existing) {
                $existing->update(['user_id' => $user->id, 'full_name' => $request->name, 'email' => $request->email]);
            } else {
                Doctor::create([
                    'user_id'        => $user->id,
                    'full_name'      => $request->name,
                    'email'          => $request->email,
                    'phone'          => $linkedPatient->phone ?? 'N/A',
                    'specialization' => 'General',
                    'status'         => 'Active',
                ]);
            }
        }

        // doctor → patient: create a patient profile from the doctor data
        elseif ($oldRole === 'doctor' && $newRole === 'patient') {
            $existing = Patient::where('email', $request->email)->first();
            if ($existing) {
                $existing->update(['user_id' => $user->id, 'full_name' => $request->name, 'email' => $request->email]);
            } else {
                Patient::create([
                    'user_id'       => $user->id,
                    'full_name'     => $request->name,
                    'email'         => $request->email,
                    'phone'         => $linkedDoctor->phone ?? 'N/A',
                    'date_of_birth' => '2000-01-01',
                    'gender'        => 'Other',
                    'status'        => 'Active',
                ]);
            }
        }

        // anything → patient (e.g. admin → patient)
        elseif ($newRole === 'patient') {
            $existing = Patient::where('email', $request->email)->first();
            if ($existing) {
                $existing->update(['user_id' => $user->id, 'full_name' => $request->name, 'email' => $request->email]);
            } else {
                Patient::create([
                    'user_id'       => $user->id,
                    'full_name'     => $request->name,
                    'email'         => $request->email,
                    'phone'         => 'N/A',
                    'date_of_birth' => '2000-01-01',
                    'gender'        => 'Other',
                    'status'        => 'Active',
                ]);
            }
        }

        // anything → doctor (e.g. admin → doctor)
        elseif ($newRole === 'doctor') {
            $existing = Doctor::where('email', $request->email)->first();
            if ($existing) {
                $existing->update(['user_id' => $user->id, 'full_name' => $request->name, 'email' => $request->email]);
            } else {
                Doctor::create([
                    'user_id'        => $user->id,
                    'full_name'      => $request->name,
                    'email'          => $request->email,
                    'phone'          => 'N/A',
                    'specialization' => 'General',
                    'status'         => 'Active',
                ]);
            }
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Account updated successfully.');
    }

    public function destroy(User $user)
    {
        // Prevent admin from deleting their own account
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Account deleted successfully.');
    }
}
