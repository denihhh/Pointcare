<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;



Route::get('/',fn()=> view('welcome'));
Route::get('/notifications',fn()=> view('notifications'))->middleware('auth');


Route::get('/about',fn()=> view('about'));

Route::get('/register', [RegisteredUserController::class, 'create'])->middleware('guest');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');

Route::get('/login', [SessionsController::class, 'create'])->middleware('guest');
Route::post('/login', [SessionsController::class, 'store'])->middleware('guest');

Route::post('/logout', [SessionsController::class, 'destroy'])->middleware('auth');

Route::get('/appointments/create', [AppointmentController::class, 'create'])->middleware('auth');
Route::post('/appointments', [AppointmentController::class, 'store'])->middleware('auth');

Route::get('/dashboard', function(){
    if(!Auth::user()){
        return redirect('/login')->with('success', 'Please login to access the dashboard.');
    }
    
    return app(DashboardController::class)->index();
});

Route::patch('/appointments/{appointment}/status',[AppointmentController::class, 'updateStatus'])
    ->middleware('auth');

