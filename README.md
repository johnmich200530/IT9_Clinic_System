# Clinic Appointment Management System

A comprehensive Laravel-based clinic appointment management system with role-based access control for Admin, Doctor, and Patient users.

## Features

### Admin Features
- **Dashboard**: Overview with statistics (total patients, doctors, services, appointments)
- **Patient Management**: Full CRUD operations for patient records
- **Doctor Management**: Full CRUD operations for doctor profiles
- **Service Management**: Manage clinic services with pricing and duration
- **Appointment Management**: Create, update, and manage all appointments

### Doctor Features
- **Dashboard**: View today's appointments and statistics
- **Appointments**: View all appointments assigned to the doctor

### Patient Features
- **Dashboard**: View upcoming appointments and statistics
- **Appointments**: View appointment history

## Technology Stack

- **Framework**: Laravel 11.x
- **Database**: SQLite (can be changed to MySQL/PostgreSQL)
- **Frontend**: Bootstrap 5.3.3 + Bootstrap Icons
- **Authentication**: Laravel Breeze

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM (for asset compilation)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd clinic_appointment
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install NPM dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Compile assets**
   ```bash
   npm run build
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

8. **Access the application**
   - Open your browser and navigate to: `http://localhost:8000`

## Test Credentials

### Admin Account
- **Email**: admin@clinic.com
- **Password**: password
- **Access**: Full system access with CRUD operations

### Doctor Account
- **Email**: sarah@clinic.com
- **Password**: password
- **Access**: View appointments and patient information

### Patient Account
- **Email**: john@clinic.com
- **Password**: password
- **Access**: View personal appointments

## Project Structure

```
clinic_appointment/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin controllers
│   │   │   │   ├── AdminController.php
│   │   │   │   ├── AppointmentController.php
│   │   │   │   ├── DoctorController.php
│   │   │   │   ├── PatientController.php
│   │   │   │   └── ServiceController.php
│   │   │   ├── Doctor/         # Doctor controllers
│   │   │   │   └── DoctorController.php
│   │   │   ├── Patient/        # Patient controllers
│   │   │   │   └── PatientController.php
│   │   │   └── Auth/           # Authentication controllers
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Patient.php
│       ├── Doctor.php
│       ├── Service.php
│       └── Appointment.php
├── database/
│   ├── migrations/
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   └── views/
│       ├── admin/              # Admin views
│       │   ├── dashboard.blade.php
│       │   ├── patients/
│       │   ├── doctors/
│       │   ├── services/
│       │   └── appointments/
│       ├── doctor/             # Doctor views
│       │   ├── dashboard.blade.php
│       │   └── appointments.blade.php
│       ├── patient/            # Patient views
│       │   ├── dashboard.blade.php
│       │   └── appointments.blade.php
│       └── layouts/
│           ├── admin.blade.php
│           ├── doctor.blade.php
│           └── patient.blade.php
└── routes/
    └── web.php
```

## Database Schema

### Users Table
- id, name, email, role (admin/doctor/patient), password

### Patients Table
- id, full_name, email, phone, date_of_birth, gender, address, status, medical_note

### Doctors Table
- id, full_name, specialization, email, phone, status

### Services Table
- id, service_name, price, duration, description

### Appointments Table
- id, service_id, patient_id, doctor_id, status, date, time

## Key Features Implementation

### Role-Based Access Control
- Custom `RoleMiddleware` restricts access based on user roles
- Automatic redirect after login based on role
- Three separate dashboard layouts for each role

### MVC Separation
- Controllers organized in role-specific folders (Admin/, Doctor/, Patient/)
- Views organized by role
- Clean route organization with prefixes and middleware groups

### CRUD Operations
- Full Create, Read, Update, Delete for:
  - Patients
  - Doctors
  - Services
  - Appointments
- Form validation on all inputs
- Success/error flash messages

### Dashboard Statistics
- Admin: Total counts for all entities + recent appointments
- Doctor: Appointment counts + today's schedule
- Patient: Appointment counts + upcoming appointments

## Routes Overview

### Admin Routes (Prefix: `/admin`)
- `GET /admin/dashboard` - Admin dashboard
- Resource routes for: patients, doctors, services, appointments

### Doctor Routes (Prefix: `/doctor`)
- `GET /doctor/dashboard` - Doctor dashboard
- `GET /doctor/appointments` - View all appointments

### Patient Routes (Prefix: `/patient`)
- `GET /patient/dashboard` - Patient dashboard
- `GET /patient/appointments` - View all appointments

## Development Notes

### Adding New Features
1. Create controller in appropriate folder (Admin/, Doctor/, Patient/)
2. Add routes in `routes/web.php` with proper middleware
3. Create views in corresponding folder
4. Update navigation in layout files

### Database Changes
```bash
# Create new migration
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Fresh migration with seed
php artisan migrate:fresh --seed
```

### Clearing Caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

## Security Features

- Password hashing using Laravel's Hash facade
- CSRF protection on all forms
- Role-based middleware authorization
- SQL injection protection via Eloquent ORM
- XSS protection via Blade templating

## Future Enhancements

- [ ] Email notifications for appointments
- [ ] SMS reminders
- [ ] Online appointment booking for patients
- [ ] Doctor availability calendar
- [ ] Payment integration
- [ ] Medical records management
- [ ] Prescription management
- [ ] Reports and analytics
- [ ] Multi-language support
- [ ] API for mobile app integration

## License

This project is open-sourced software licensed under the MIT license.

## Support

For issues, questions, or contributions, please contact the development team.
