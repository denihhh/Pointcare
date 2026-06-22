<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class AppointmentRejected extends Notification
{
    use Queueable;

    public function __construct(
        public Appointment $appointment
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $timeStr = Carbon::parse($this->appointment->appointment_time)->format('d M Y \a\t h:i A');
        $doctorName = 'Dr. ' . preg_replace('/^dr\.?\s+/i', '', $this->appointment->doctor->name);

        return [
            'appointment_id' => $this->appointment->id,
            'title' => 'Appointment Request Declined',
            'message' => "{$doctorName} has declined your appointment request for {$timeStr}.",
            'type' => 'status_mutation',
        ];
    }
}
