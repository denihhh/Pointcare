<?php

namespace App\Observers;

use App\Models\Appointment;
use App\Services\AppointmentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppointmentObserver
{
    public function __construct(
        private AppointmentService $appointmentService
    ) {}

    public function updated(Appointment $appointment): void
    {
        if ($appointment->wasChanged('status') && $this->appointmentService->isCompleted($appointment)) {
            Log::info('Clinical Record Finalized', [
                'appointment_id' => $appointment->id,
                'doctor_id' => Auth::id(),
                'timestamp' => now(),
            ]);
        }
    }
}
