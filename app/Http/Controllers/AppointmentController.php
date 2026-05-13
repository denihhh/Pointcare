<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    use AuthorizesRequests;

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'date' => 'required|date'
        ]);

        $now = Carbon::now('Asia/Kuala_Lumpur');
        $selectedDate = Carbon::parse($request->date, 'Asia/Kuala_Lumpur');
        $potentialSlots = ['09:00', '10:00', '11:00', '14:00', '15:00', '16:00'];

        $bookedSlots = Appointment::where('doctor_id', $request->doctor_id)
            ->whereDate('appointment_time', $request->date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('appointment_time')
            ->map(fn($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        $availableSlots = array_filter($potentialSlots, function ($slot) use ($selectedDate, $now, $bookedSlots) {
            if (in_array($slot, $bookedSlots)) return false;

            if ($selectedDate->isToday()) {
                $slotDateTime = Carbon::createFromFormat('Y-m-d H:i', $selectedDate->format('Y-m-d') . ' ' . $slot, 'Asia/Kuala_Lumpur');
                if ($slotDateTime->lessThan($now)) return false;
            }
            return true;
        });

        return response()->json(array_values($availableSlots));
    }

    public function create()
    {
        $doctors = User::where('role', 'doctor')->select('id', 'name')->get();
        return view('appointments.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'doctor_id' => ['required', 'exists:users,id,role,doctor'],
            'appointment_time' => ['required', 'date', 'after:now'],
            'reason' => ['required', 'string', 'max:1000']
        ]);

        $attributes['patient_id'] = Auth::id();
        $attributes['status'] = 'pending';

        Appointment::create($attributes);
        return redirect('/dashboard')->with('alert', 'Appointment booked successfully.');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $this->authorize('manage', $appointment);

        $request->validate(['status' => 'required|in:confirmed,cancelled']);

        if ($appointment->status === 'cancelled') {
            return back()->with('error', 'This appointment was already cancelled.');
        }

        $appointment->update(['status' => $request->status]);
        return back()->with('alert', 'Status updated to ' . $request->status);
    }

    public function edit(Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        if ($appointment->status !== 'pending') {
            return redirect('/dashboard')->with('error', 'Cannot edit a ' . $appointment->status . ' appointment.');
        }

        $doctors = User::where('role', 'doctor')->select('id', 'name')->get();
        return view('appointments.edit', compact('appointment', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        if ($appointment->status !== 'pending') {
            return redirect('/dashboard')->with('error', 'Doctor has already processed this appointment.');
        }

        $attributes = $request->validate([
            'doctor_id' => ['required', 'exists:users,id,role,doctor'],
            'appointment_time' => ['required', 'date', 'after:now'],
            'reason' => ['required', 'string', 'min:5', 'max:1000'],
        ]);

        $appointment->update($attributes);
        return redirect('/dashboard')->with('alert', 'Appointment updated!');
    }

    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);

        if ($appointment->status !== 'pending') {
            return redirect('/dashboard')->with('error', 'Too late! Status is already ' . $appointment->status);
        }

        $appointment->update(['status' => 'cancelled']);
        return back()->with('alert', 'Appointment cancelled.');
    }

    public function consultation(Appointment $appointment)
    {
        $this->authorize('manage', $appointment);

        if ($appointment->status !== 'confirmed') {
            return redirect('/dashboard')->with('error', 'Consultation cannot be accessed at this state.');
        }

        return view('doctor.consultation', compact('appointment'));
    }

    public function completeConsultation(Request $request, Appointment $appointment)
    {
        $this->authorize('manage', $appointment);

        if ($appointment->status !== 'confirmed') {
            return redirect('/dashboard')->with('error', 'Only confirmed appointments can be completed.');
        }

        $attributes = $request->validate([
            'symptoms' => 'required|string|min:5',
            'diagnosis' => 'required|string|min:5',
            'prescription' => 'required|string|min:3',
        ]);

        $appointment->update(array_merge($attributes, ['status' => 'completed']));
        return redirect('/dashboard')->with('alert', 'Consultation finalized.');
    }

    public function showRecord(Appointment $appointment)
    {
        $this->authorize('viewRecord', $appointment);

        if ($appointment->status !== 'completed') {
            return redirect('/dashboard')->with('error', 'Record not yet finalized.');
        }

        return view('appointments.record', compact('appointment'));
    }
}
