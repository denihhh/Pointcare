<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Uri\Rfc3986\Uri;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login')->with('success', 'Please login to access the dashboard.');
        }

        if ($user->role === 'doctor') {
            $appointments = Appointment::where('doctor_id', $user->id)
                ->with('patient')
                ->orderBy('appointment_time', 'asc')
                ->get();
            return view('doctor.dashboard', compact('appointments'));
        }

        $appointments = Appointment::where('patient_id', $user->id)
            ->with('doctor')
            ->orderBy('appointment_time', 'asc')
            ->get();
        return view('patient.dashboard', compact('appointments'));
    }
}
