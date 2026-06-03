<?php

namespace App\Services;

use App\Events\AppointmentCancelled;
use App\Events\AppointmentCompleted;
use App\Events\AppointmentCreated;
use App\Events\AppointmentUpdated;
use App\Models\Appointment;

class AppointmentService
{
    public function create(array $attributes, int $patientId): void
    {
        $appointment = Appointment::create([
            ...$attributes,
            'patient_id' => $patientId,
            'status' => 'pending',
        ]);

        AppointmentCreated::dispatch($appointment);
    }

    public function update(Appointment $appointment, array $attributes): ?string
    {
        if (! $this->isPending($appointment)) {
            return 'Doctor has already processed this appointment.';
        }

        $appointment->update($attributes);

        AppointmentUpdated::dispatch($appointment->fresh());

        return null;
    }

    public function cancel(Appointment $appointment): ?string
    {
        if (! $this->isPending($appointment)) {
            return 'Too late! Status is already ' . $appointment->status;
        }

        $appointment->update(['status' => 'cancelled']);

        AppointmentCancelled::dispatch($appointment->fresh());

        return null;
    }

    public function updateStatus(Appointment $appointment, string $status): ?string
    {
        if ($this->isCancelled($appointment)) {
            return 'This appointment was already cancelled.';
        }

        $appointment->update(['status' => $status]);

        $appointment = $appointment->fresh();

        if ($this->isCancelled($appointment)) {
            AppointmentCancelled::dispatch($appointment);
        } else {
            AppointmentUpdated::dispatch($appointment);
        }

        return null;
    }

    public function editError(Appointment $appointment): ?string
    {
        if (! $this->isPending($appointment)) {
            return 'Cannot edit a ' . $appointment->status . ' appointment.';
        }

        return null;
    }

    public function canAccessConsultation(Appointment $appointment): ?string
    {
        if (! $this->isConfirmed($appointment)) {
            return 'Consultation cannot be accessed at this state.';
        }

        return null;
    }

    public function viewRecordError(Appointment $appointment): ?string
    {
        if (! $this->isCompleted($appointment)) {
            return 'Record not yet finalized.';
        }

        return null;
    }

    public function completeConsultation(Appointment $appointment, array $attributes): ?string
    {
        if (! $this->isConfirmed($appointment)) {
            return 'Only confirmed appointments can be completed.';
        }

        $appointment->update(array_merge($attributes, ['status' => 'completed']));

        AppointmentCompleted::dispatch($appointment->fresh());

        return null;
    }

    public function isPending(Appointment $appointment): bool
    {
        return $appointment->status === 'pending';
    }

    public function isConfirmed(Appointment $appointment): bool
    {
        return $appointment->status === 'confirmed';
    }

    public function isCompleted(Appointment $appointment): bool
    {
        return $appointment->status === 'completed';
    }

    public function isCancelled(Appointment $appointment): bool
    {
        return $appointment->status === 'cancelled';
    }
}
