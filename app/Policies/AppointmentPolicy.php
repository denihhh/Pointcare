<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    public function manage(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->doctor_id;
    }

    public function viewRecord(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->doctor_id || $user->id === $appointment->patient_id;
    }

    public function update(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->patient_id;
    }

    public function delete(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->patient_id;
    }
}
