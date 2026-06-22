<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class UpcomingAppointmentReminder extends Notification
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
        $timeStr = Carbon::parse($this->appointment->appointment_time)->format('h:i A');
        $doctorName = 'Dr. ' . preg_replace('/^dr\.?\s+/i', '', $this->appointment->doctor->name);

        return [
            'appointment_id' => $this->appointment->id,
            'title' => 'Upcoming Consultation Reminder',
            'message' => "Reminder: You have a scheduled consultation tomorrow at {$timeStr} with {$doctorName}.",
            'type' => 'reminder',
        ];
    }
}
