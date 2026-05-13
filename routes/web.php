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

