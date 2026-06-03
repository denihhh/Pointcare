<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    public function create(User $user): bool
    {
        return $user->role === 'patient';
    }

    public function view(User $user, Appointment $appointment): bool
    {
        return $user->id === $appointment->doctor_id || $user->id === $appointment->patient_id;
    }

    public function update(User $user, Appointment $appointment): bool
    {
        return $user->role === 'patient' && $user->id === $appointment->patient_id;
    }

    public function delete(User $user, Appointment $appointment): bool
    {
        return $user->role === 'patient' && $user->id === $appointment->patient_id;
    }

    public function manage(User $user, Appointment $appointment): bool
    {
        return $user->role === 'doctor' && $user->id === $appointment->doctor_id;
    }
}
