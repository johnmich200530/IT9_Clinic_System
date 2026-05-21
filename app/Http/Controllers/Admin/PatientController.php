<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $patients = Patient::when($search, function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            })
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.patients.index', compact('patients', 'search'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:patients,email',
            'phone'         => 'required|string|max:20|unique:patients,phone',
            'date_of_birth' => 'required|date',
            'gender'        => 'required|in:Male,Female,Other',
            'address'       => 'nullable|string|max:500',
            'status'        => 'required|in:Active,Inactive',
            'medical_note'  => 'nullable|string',
        ]);

        $data = $request->only([
            'full_name', 'email', 'phone', 'date_of_birth',
            'gender', 'address', 'status', 'medical_note',
        ]);

        // Link to an existing user account with the same email and patient role
        $user = User::where('email', $data['email'])->where('role', 'patient')->first();
        if ($user) {
            $data['user_id'] = $user->id;
        }

        Patient::create($data);

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient added successfully.');
    }

    public function edit(Patient $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'full_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:patients,email,' . $patient->id,
            'phone'         => 'required|string|max:20|unique:patients,phone,' . $patient->id,
            'date_of_birth' => 'required|date',
            'gender'        => 'required|in:Male,Female,Other',
            'address'       => 'nullable|string|max:500',
            'status'        => 'required|in:Active,Inactive',
            'medical_note'  => 'nullable|string',
        ]);

        $oldEmail = $patient->email;

        $patient->update($request->only([
            'full_name', 'email', 'phone', 'date_of_birth',
            'gender', 'address', 'status', 'medical_note',
        ]));

        // Sync name/email changes to the linked user account
        $linkedUser = $patient->user_id
            ? User::find($patient->user_id)
            : User::where('email', $oldEmail)->where('role', 'patient')->first();

        if ($linkedUser) {
            $linkedUser->update([
                'name'  => $request->full_name,
                'email' => $request->email,
            ]);
            // Keep user_id in sync if it wasn't set
            if (!$patient->user_id) {
                $patient->update(['user_id' => $linkedUser->id]);
            }
        }

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient deleted successfully.');
    }
}
