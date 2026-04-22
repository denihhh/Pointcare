<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Guard Clause
        if (!$user) {
            return redirect('/login')->with('success', 'Please login to access the dashboard.');
        }

        // 2. Logic for Doctor
        if ($user->role === 'doctor') {
            $appointments = Appointment::where('doctor_id', $user->id)
                ->with('patient')
                ->orderBy('appointment_time', 'asc')
                ->get();

            // Dynamic Stats for the homepage/dashboard
            $todayCount = Appointment::where('doctor_id', $user->id)
                ->whereDate('appointment_time', Carbon::today())
                ->where('status', 'confirmed')
                ->count();

            $pendingCount = Appointment::where('doctor_id', $user->id)
                ->where('status', 'pending')
                ->count();

            $upcomingAppointment = $appointments->where('status', 'confirmed')
                ->where('appointment_time', '>=', now())
                ->first();

            return view('doctor.dashboard', compact('appointments', 'todayCount', 'pendingCount', 'upcomingAppointment'));
        }

        // 3. Logic for Patient
        $appointments = Appointment::where('patient_id', $user->id)
            ->with('doctor')
            ->orderBy('appointment_time', 'asc')
            ->get();

        $upcomingAppointment = $appointments->where('status', 'confirmed')
            ->where('appointment_time', '>=', now())
            ->first();

        return view('patient.dashboard', compact('appointments', 'upcomingAppointment'));
    }
}

