<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function create(){
        $doctors = User::where('role', 'doctor')->get();
        return view('appointments.create', compact('doctors'));
    }

    public function store(Request $request){
        $attributes = $request->validate([
            'doctor_id' => ['required', 'exists:users,id'],
            'appointment_time' => ['required', 'date', 'after:now'],
            'reason' => ['required', 'string', 'max:1000']
        ]);

        $attributes['patient_id'] = Auth::id();
        $attributes['status'] = 'pending';

        Appointment::create($attributes);

        return redirect('/dashboard')->with('success', 'Appointment booked successfully and is pending confirmation.');

    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        if(Auth::user()->id !== $appointment->doctor_id){
            abort(403);
        }

        $appointment->update([
            'status'=> $request->status
        ]);
        return back()->with('success', 'Appointment status updated successfully.');
    }
}
