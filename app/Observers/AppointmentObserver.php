<?php

namespace App\Observers;

use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppointmentObserver
{
    public function updated(Appointment $appointment): void
    {
        if ($appointment->wasChanged('status') && $appointment->status === 'completed') {
            Log::info("Clinical Record Finalized", [
                'appointment_id' => $appointment->id,
                'doctor_id' => Auth::id(),
                'timestamp' => now()
            ]);
        }
    }
}
