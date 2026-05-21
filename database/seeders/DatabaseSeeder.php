<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ──────────────────────────────────────────────────────────
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@clinic.com',
            'role'     => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name'     => 'Dr. Sarah Johnson',
            'email'    => 'sarah@clinic.com',
            'role'     => 'doctor',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name'     => 'John Patient',
            'email'    => 'john@clinic.com',
            'role'     => 'patient',
            'password' => Hash::make('password'),
        ]);

        // ── Doctors ────────────────────────────────────────────────────────
        $doctor = Doctor::create([
            'full_name'      => 'Dr. Sarah Johnson',
            'specialization' => 'General Medicine',
            'email'          => 'sarah@clinic.com',
            'phone'          => '0911000001',
            'status'         => 'Active',
        ]);

        Doctor::create([
            'full_name'      => 'Dr. Michael Lee',
            'specialization' => 'Dentistry',
            'email'          => 'michael@clinic.com',
            'phone'          => '0911000002',
            'status'         => 'Active',
        ]);

        // ── Patients ───────────────────────────────────────────────────────
        $patient = Patient::create([
            'full_name'     => 'John Patient',
            'email'         => 'john@clinic.com',
            'phone'         => '0922000001',
            'date_of_birth' => '1990-05-15',
            'gender'        => 'Male',
            'address'       => '123 Main Street',
            'status'        => 'Active',
            'medical_note'  => 'No known allergies.',
        ]);

        Patient::create([
            'full_name'     => 'Jane Doe',
            'email'         => 'jane@clinic.com',
            'phone'         => '0922000002',
            'date_of_birth' => '1985-08-22',
            'gender'        => 'Female',
            'address'       => '456 Oak Avenue',
            'status'        => 'Active',
            'medical_note'  => null,
        ]);

        // ── Services ───────────────────────────────────────────────────────
        $service1 = Service::create([
            'service_name' => 'General Consultation',
            'price'        => 500.00,
            'duration'     => '30 mins',
            'description'  => 'General health check-up and consultation.',
        ]);

        $service2 = Service::create([
            'service_name' => 'Dental Cleaning',
            'price'        => 800.00,
            'duration'     => '45 mins',
            'description'  => 'Professional teeth cleaning and polishing.',
        ]);

        Service::create([
            'service_name' => 'Blood Test',
            'price'        => 350.00,
            'duration'     => '15 mins',
            'description'  => 'Complete blood count and basic metabolic panel.',
        ]);

        // ── Appointments ───────────────────────────────────────────────────
        Appointment::create([
            'service_id' => $service1->id,
            'patient_id' => $patient->id,
            'doctor_id'  => $doctor->id,
            'status'     => 'Scheduled',
            'date'       => now()->addDays(1)->format('Y-m-d'),
            'time'       => '09:00:00',
        ]);

        Appointment::create([
            'service_id' => $service2->id,
            'patient_id' => $patient->id,
            'doctor_id'  => $doctor->id,
            'status'     => 'Completed',
            'date'       => now()->subDays(3)->format('Y-m-d'),
            'time'       => '14:00:00',
        ]);
    }
}
