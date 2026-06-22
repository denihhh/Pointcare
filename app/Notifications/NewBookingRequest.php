<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class NewBookingRequest extends Notification
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
        $patientName = $this->appointment->patient->name;

        return [
            'appointment_id' => $this->appointment->id,
            'title' => 'New Booking Request',
            'message' => "New Booking Request Received from Patient {$patientName} for {$timeStr}.",
            'type' => 'inbound_booking',
        ];
    }
}
