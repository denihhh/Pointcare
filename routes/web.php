<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;



//Route::get('/',fn()=> view('welcome'));
Route::get('/', function () {
    $upcomingAppointment = null;

    if (Auth::check() && Auth::user()->role === 'patient') {
        $upcomingAppointment = Auth::user()->appointments()
            ->where('status', 'confirmed')
            ->where('appointment_time', '>=', now())
            ->orderBy('appointment_time', 'asc')
            ->first();
    }
    elseif(Auth::check() && Auth::user()->role === 'doctor'){
        $upcomingAppointment = \App\Models\Appointment::where('doctor_id', Auth::id())
                ->where('status', 'confirmed')
                ->where('appointment_time', '>=', now())
                ->orderBy('appointment_time', 'asc')
                ->with('patient') // Eager load patient info
                ->first();
    }

    return view('welcome', compact('upcomingAppointment'));
});

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
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

// Doctor update status
Route::patch('/appointments/{appointment}/status',[AppointmentController::class, 'updateStatus'])
    ->middleware('auth');

Route::middleware(['auth', 'role:patient'])->group(function () {
    // Existing routes...
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit']);
    Route::patch('/appointments/{appointment}', [AppointmentController::class, 'update']);
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy']);
});
