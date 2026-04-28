<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'date' => 'required|date'
        ]);

        // Use the timezone explicitly to be 100% safe
        $now = \Carbon\Carbon::now('Asia/Kuala_Lumpur');
        $selectedDate = \Carbon\Carbon::parse($request->date, 'Asia/Kuala_Lumpur');

        $potentialSlots = ['09:00', '10:00', '11:00', '14:00', '15:00', '16:00'];

        $bookedSlots = \App\Models\Appointment::where('doctor_id', $request->doctor_id)
            ->whereDate('appointment_time', $request->date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('appointment_time')
            ->map(fn($time) => \Carbon\Carbon::parse($time)->format('H:i'))
            ->toArray();

        $availableSlots = array_filter($potentialSlots, function ($slot) use ($selectedDate, $now, $bookedSlots) {
            // 1. Check if booked
            if (in_array($slot, $bookedSlots)) {
                return false;
            }

            // 2. Check if date is today
            if ($selectedDate->isToday()) {
                // Create a Carbon instance for the slot on the selected date
                $slotDateTime = \Carbon\Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $selectedDate->format('Y-m-d') . ' ' . $slot,
                    'Asia/Kuala_Lumpur'
                );

                // If the slot time is before "now", hide it
                if ($slotDateTime->lessThan($now)) {
                    return false;
                }
            }

            return true;
        });

        return response()->json(array_values($availableSlots));
    }
    public function create()
    {
        $doctors = User::where('role', 'doctor')->get();
        return view('appointments.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'doctor_id' => ['required', 'exists:users,id'],
            'appointment_time' => ['required', 'date', 'after:now'],
            'reason' => ['required', 'string', 'max:1000']
        ]);

        $attributes['patient_id'] = Auth::id();
        $attributes['status'] = 'pending';

        Appointment::create($attributes);

        return redirect('/dashboard')->with('alert', 'Appointment booked successfully and is pending confirmation.');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        if (Auth::id() !== $appointment->doctor_id) {
            abort(403);
        }

        // Check if the patient cancelled it a second before the doctor clicked confirm
        if ($appointment->status === 'cancelled') {
            return back()->with('error', 'This appointment was just cancelled by the patient.');
        }

        $appointment->update(['status' => $request->status]);
        return back()->with('alert', 'Appointment has been approved!');
    }

    public function edit(Appointment $appointment)
    {
        $doctors = User::where('role', 'doctor')->get();

        if ($appointment->patient_id !== Auth::id()) {
            abort(403);
        }
        if ($appointment->status !== 'pending') {
            return redirect('/dashboard')->with('error', 'You cannot edit an appointment that has already been ' . $appointment->status . '.');
        }
        return view('appointments.edit', compact('appointment', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        // Security check: Ownership
        if ($appointment->patient_id !== Auth::id()) {
            abort(403);
        }

        // CONCURRENCY CHECK: If doctor already confirmed/cancelled, block the patient
        if ($appointment->status !== 'pending') {
            return redirect('/dashboard')->with('error', 'Action failed: The doctor has already processed this appointment.');
        }

        $attributes = $request->validate([
            'doctor_id' => ['required', 'exists:users,id'],
            'appointment_time' => ['required', 'date', 'after:now'],
            'reason' => ['required', 'string', 'min:5'],
        ]);

        $appointment->update($attributes);
        return redirect('/dashboard')->with('alert', 'Appointment updated!');
    }

    public function destroy(Appointment $appointment)
    {
        if ($appointment->patient_id !== Auth::id()) {
            abort(403);
        }

        // CONCURRENCY CHECK
        if ($appointment->status !== 'pending') {
            return redirect('/dashboard')->with('error', 'Too late! The appointment is already ' . $appointment->status);
        }

        $appointment->update(['status' => 'cancelled']);
        return back()->with('alert', 'Appointment cancelled.');
    }

    public function consultation(Appointment $appointment)
    {
        // Authorization: Is this YOUR patient?
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized medical access.');
        }
        if ($appointment->status === 'completed') {
            return redirect('/dashboard')->with('error', 'This consultation has already been finalized and cannot be edited.');
        }

        return view('doctor.consultation', compact('appointment'));
    }

    public function completeConsultation(Request $request, Appointment $appointment)
    {

        if ($appointment->doctor_id !== Auth::id()) {
            abort(403);
        }

        $attributes = $request->validate([
            'symptoms' => 'required|string|min:5',
            'diagnosis' => 'required|string|min:5',
            'prescription' => 'required|string|min:3', // Made required as per your request
        ]);

        $appointment->update([
            'symptoms' => $attributes['symptoms'],
            'diagnosis' => $attributes['diagnosis'],
            'prescription' => $attributes['prescription'],
            'status' => 'completed', // CRITICAL: This closes the appointment
        ]);

        return redirect('/dashboard')->with('alert', 'Consultation recorded and appointment closed.');
    }

    public function showRecord(Appointment $appointment)
    {
        // 1. Authorization: Only the assigned doctor or the patient can view this
        if (Auth::id() !== $appointment->doctor_id && Auth::id() !== $appointment->patient_id) {
            abort(403, 'Unauthorized access to medical records.');
        }

        // 2. State Check: Only show if the consultation is actually finished
        if ($appointment->status !== 'completed') {
            return redirect('/dashboard')->with('error', 'The medical record is not yet finalized.');
        }

        return view('appointments.record', compact('appointment'));
    }

}
