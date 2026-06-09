<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

Route::get('/contact', fn() => view('contact'))->name('contact');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/notifications',fn()=> view('notifications'))->middleware('auth');
Route::get('/about',fn()=> view('about'));

//registration route
Route::get('/register', [RegisteredUserController::class, 'create'])->middleware('guest');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');

//login route
Route::get('/login', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [SessionsController::class, 'store'])->middleware('guest');

//logout route
Route::post('/logout', [SessionsController::class, 'destroy'])->middleware('auth');



// Only Patients can book appointments
Route::get('/appointments/create', [AppointmentController::class, 'create'])
    ->middleware(['auth', 'role:patient']);
// Store Appointments
Route::post('/appointments', [AppointmentController::class, 'store'])->middleware('auth');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Doctor update status
Route::patch('/appointments/{appointment}/status',[AppointmentController::class, 'updateStatus'])
    ->middleware('auth');

Route::middleware(['auth', 'role:patient'])->group(function () {
    // Existing routes...
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit']);
    Route::patch('/appointments/{appointment}', [AppointmentController::class, 'update']);
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy']);
    Route::get('/records', [DashboardController::class, 'records'])->name('records');
});

Route::get('/api/available-slots', [AppointmentController::class, 'getAvailableSlots'])->middleware('auth');
Route::middleware(['auth', 'role:doctor'])->group(function () {
    // Page to write the EHR
    Route::get('/consultation/{appointment}', [AppointmentController::class, 'consultation'])->name('consultation');
    // Save the EHR and mark as completed
    Route::patch('/consultation/{appointment}/complete', [AppointmentController::class, 'completeConsultation']);
});

Route::get('/appointments/{appointment}/record', [AppointmentController::class, 'showRecord'])
    ->middleware('auth')
    ->name('appointments.record');

//Profile Route
Route::get('/profile', fn() => view('profile.profile'))->middleware('auth');
/*
app/Http/Controllers/
├── Auth/
│   ├── RegisteredUserController.php  (Handles sign-ups)
│   └── SessionsController.php        (Handles login/logout)
├── Public/
│   └── HomeController.php            (Landing page, About, Contact)
├── Patient/
│   ├── DashboardController.php       (Patient-specific stats)
│   └── AppointmentController.php     (Patient creating/canceling bookings)
└── Doctor/
    ├── DashboardController.php       (Doctor-specific schedule)
    └── ConsultationController.php    (EHR, completing sessions)

<?php

use Illuminate\Support\Facades\Route;

// Controller Namespaces
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\SessionsController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointment;
use App\Http\Controllers\Patient\DashboardController as PatientDashboard;
use App\Http\Controllers\Doctor\ConsultationController as DoctorConsultation;


|--------------------------------------------------------------------------
| 1. Public Routes (Accessible by Everyone)
|--------------------------------------------------------------------------

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/contact', fn() => view('contact'))->name('contact');


|--------------------------------------------------------------------------
| 2. Guest Routes (Login / Register Only)
|--------------------------------------------------------------------------

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/login', [SessionsController::class, 'store']);
});


|--------------------------------------------------------------------------
| 3. Shared Authenticated Routes (Any Logged-in User)
|--------------------------------------------------------------------------

Route::middleware('auth')->group(function () {
    Route::post('/logout', [SessionsController::class, 'destroy'])->name('logout');
    Route::get('/profile', fn() => view('profile.profile'))->name('profile');
    Route::get('/notifications', fn() => view('notifications'))->name('notifications');

    // Shared Appointment Record Viewing (Secured via Policies later)
    Route::get('/appointments/{appointment}/record', [PatientAppointment::class, 'showRecord'])->name('appointments.record');
    Route::get('/api/available-slots', [PatientAppointment::class, 'getAvailableSlots']);
});


|--------------------------------------------------------------------------
| 4. Patient Specific Routes (Role Protected)
|--------------------------------------------------------------------------

Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientDashboard::class, 'index'])->name('dashboard');

    // RESTful Booking Routes
    Route::get('/appointments/create', [PatientAppointment::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [PatientAppointment::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}/edit', [PatientAppointment::class, 'edit'])->name('appointments.edit');
    Route::patch('/appointments/{appointment}', [PatientAppointment::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{appointment}', [PatientAppointment::class, 'destroy'])->name('appointments.destroy');
});


|--------------------------------------------------------------------------
| 5. Doctor Specific Routes (Role Protected)
|--------------------------------------------------------------------------

Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    // Status management (Accept/Reject)
    Route::patch('/appointments/{appointment}/status', [PatientAppointment::class, 'updateStatus'])->name('appointments.status');

    // Consultation & EHR Domain Logic
    Route::get('/consultation/{appointment}', [DoctorConsultation::class, 'consultation'])->name('consultation');
    Route::patch('/consultation/{appointment}/complete', [DoctorConsultation::class, 'completeConsultation'])->name('consultation.complete');
});
*/
