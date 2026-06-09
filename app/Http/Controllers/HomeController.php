<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $upcomingAppointment = null;
        $pastAppointments = collect();
        $todayCount = 0;
        $pendingCount = 0;


        if (Auth::check() && Auth::user()->role === 'patient') {
            $upcomingAppointment = Auth::user()->appointments()
                ->where('status', 'confirmed')
                ->where('appointment_time', '>=', now())
                ->orderBy('appointment_time', 'asc')
                ->first();

            $pastAppointments = Auth::user()->appointments()
                ->with('doctor')
                ->where(function ($query) {
                    $query->where('appointment_time', '<', now())
                          ->orWhereIn('status', ['completed', 'cancelled']);
                })
                ->orderBy('appointment_time', 'desc')
                ->take(3)
                ->get();
        } elseif (Auth::check() && Auth::user()->role === 'doctor') {
            $upcomingAppointment = \App\Models\Appointment::where('doctor_id', Auth::id())
                ->where('status', 'confirmed')
                ->where('appointment_time', '>=', now())
                ->orderBy('appointment_time', 'asc')
                ->with('patient') // Eager load patient info
                ->first();

            $todayCount = \App\Models\Appointment::where('doctor_id', Auth::id())
                ->whereDate('appointment_time', \Carbon\Carbon::today())
                ->where('status', 'confirmed')
                ->count();

            $pendingCount = \App\Models\Appointment::where('doctor_id', Auth::id())
                ->where('status', 'pending')
                ->count();
        }

        return view('welcome', compact('upcomingAppointment', 'pastAppointments', 'todayCount', 'pendingCount'));
    }
}
