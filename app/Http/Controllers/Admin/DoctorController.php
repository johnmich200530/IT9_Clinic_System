<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $doctors = Doctor::when($search, function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            })
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.doctors.index', compact('doctors', 'search'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name'      => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'email'          => 'required|email|unique:doctors,email',
            'phone'          => 'required|string|max:20|unique:doctors,phone',
            'status'         => 'required|in:Active,Inactive',
        ]);

        $data = $request->only([
            'full_name', 'specialization', 'email', 'phone', 'status',
        ]);

        // Link to an existing user account with the same email and doctor role
        $user = User::where('email', $data['email'])->where('role', 'doctor')->first();
        if ($user) {
            $data['user_id'] = $user->id;
        }

        Doctor::create($data);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Doctor added successfully.');
    }

    public function edit(Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'full_name'      => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'email'          => 'required|email|unique:doctors,email,' . $doctor->id,
            'phone'          => 'required|string|max:20|unique:doctors,phone,' . $doctor->id,
            'status'         => 'required|in:Active,Inactive',
        ]);

        $oldEmail = $doctor->email;

        $doctor->update($request->only([
            'full_name', 'specialization', 'email', 'phone', 'status',
        ]));

        // Sync name/email changes to the linked user account
        $linkedUser = $doctor->user_id
            ? User::find($doctor->user_id)
            : User::where('email', $oldEmail)->where('role', 'doctor')->first();

        if ($linkedUser) {
            $linkedUser->update([
                'name'  => $request->full_name,
                'email' => $request->email,
            ]);
            // Keep user_id in sync if it wasn't set
            if (!$doctor->user_id) {
                $doctor->update(['user_id' => $linkedUser->id]);
            }
        }

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Doctor updated successfully.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('admin.doctors.index')
            ->with('success', 'Doctor deleted successfully.');
    }
}
