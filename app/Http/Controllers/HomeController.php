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
        $todayAppointments = collect();


        if (Auth::check() && Auth::user()->role === 'admin') {
            $patientCount = \App\Models\User::where('role', 'patient')->count();
            $doctorCount = \App\Models\User::where('role', 'doctor')->count();
            $adminCount = \App\Models\User::where('role', 'admin')->count();
            $appointmentCount = \App\Models\Appointment::count();

            $systemMetrics = [
                'php_version' => PHP_VERSION,
                'laravel_version' => app()->version(),
                'environment' => ucfirst(app()->environment()),
                'db_driver' => config('database.default'),
                'debug_mode' => config('app.debug') ? 'ENABLED' : 'DISABLED',
                'timezone' => config('app.timezone'),
                'memory_usage' => round(memory_get_usage(true) / 1024 / 1024, 1) . ' MB',
            ];

            $recentUsers = \App\Models\User::latest()->take(5)->get();

            // Default variables to prevent welcome.blade.php undefined variable exceptions
            $upcomingAppointment = null;
            $pastAppointments = collect();
            $todayCount = 0;
            $pendingCount = 0;
            $todayAppointments = collect();

            return view('welcome', compact(
                'patientCount', 
                'doctorCount', 
                'adminCount', 
                'appointmentCount', 
                'systemMetrics', 
                'recentUsers',
                'upcomingAppointment',
                'pastAppointments',
                'todayCount',
                'pendingCount',
                'todayAppointments'
            ));
        }

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

            $todayAppointments = \App\Models\Appointment::where('doctor_id', Auth::id())
                ->whereDate('appointment_time', \Carbon\Carbon::today())
                ->with('patient')
                ->orderBy('appointment_time', 'asc')
                ->get();
        }

        return view('welcome', compact('upcomingAppointment', 'pastAppointments', 'todayCount', 'pendingCount', 'todayAppointments'));
    }
}
