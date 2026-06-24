<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

Route::get('/contact', fn() => view('contact'))->name('contact')->middleware('guest');
Route::post('/contact', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|min:10',
    ]);

    \App\Models\ContactMessage::create($validated);

    return back()->with('alert', 'Thank you! Your message has been received. Our support team will get back to you shortly.');
})->middleware('guest');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/notifications',fn()=> view('notifications'))->middleware('auth');
Route::get('/about',fn()=> view('about'))->name('about')->middleware('guest');

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

    // Calendar / Schedule page
    Route::get('/schedule', [AppointmentController::class, 'schedule'])->name('doctor.schedule');

    // Patients page
    Route::get('/patients', [AppointmentController::class, 'patients'])->name('doctor.patients');

    // Patient detail / consultation history
    Route::get('/patients/{patient}', [AppointmentController::class, 'patientDetail'])->name('doctor.patient.detail');

    // Unified Clinical Records (replaces medical-records, prescriptions, consultation-notes)
    Route::get('/clinical-records', [AppointmentController::class, 'clinicalRecords'])->name('doctor.clinical-records');

    // Backward-compatible redirects for old URLs
    Route::get('/medical-records', fn () => redirect()->route('doctor.clinical-records'));
    Route::get('/prescriptions', fn () => redirect()->route('doctor.clinical-records'));
    Route::get('/consultation-notes', fn () => redirect()->route('doctor.clinical-records'));
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', \App\Livewire\AdminDashboard::class)->name('dashboard');
});

Route::get('/appointments/{appointment}/record', [AppointmentController::class, 'showRecord'])
    ->middleware('auth')
    ->name('appointments.record');

//Profile Routes
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->middleware('auth')->name('profile');
Route::post('/profile/account', [App\Http\Controllers\ProfileController::class, 'updateAccount'])->middleware('auth')->name('profile.account');
Route::post('/profile/patient-info', [App\Http\Controllers\ProfileController::class, 'updatePatientProfile'])->middleware('auth')->name('profile.patient-info');
Route::post('/profile/patient-medical', [App\Http\Controllers\ProfileController::class, 'updatePatientMedical'])->middleware('auth')->name('profile.patient-medical');
Route::post('/profile/doctor-credentials', [App\Http\Controllers\ProfileController::class, 'updateDoctorCredentials'])->middleware('auth')->name('profile.doctor-credentials');
Route::post('/profile/doctor-consultation', [App\Http\Controllers\ProfileController::class, 'updateDoctorConsultation'])->middleware('auth')->name('profile.doctor-consultation');

// Account Settings Routes
Route::get('/profile/account-settings', [App\Http\Controllers\ProfileController::class, 'showAccountSettings'])->middleware('auth')->name('profile.account-settings');
Route::post('/profile/account-settings/identity', [App\Http\Controllers\ProfileController::class, 'updateIdentity'])->middleware('auth')->name('profile.account-settings.identity');
Route::post('/profile/account-settings/security', [App\Http\Controllers\ProfileController::class, 'updateSecurity'])->middleware('auth')->name('profile.account-settings.security');
Route::post('/profile/account-settings/revoke', [App\Http\Controllers\ProfileController::class, 'revokeSessions'])->middleware('auth')->name('profile.account-settings.revoke');
Route::post('/profile/account-settings/deactivate', [App\Http\Controllers\ProfileController::class, 'deactivateAccount'])->middleware('auth')->name('profile.account-settings.deactivate');
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
