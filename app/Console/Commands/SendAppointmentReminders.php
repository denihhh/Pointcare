<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Notifications\UpcomingAppointmentReminder;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:send-reminders';

    protected $description = 'Send preemptive reminders to patients about upcoming scheduled consultations tomorrow';

    public function handle(): int
    {
        $this->info('Starting to send appointment reminders...');

        $tomorrowStart = Carbon::tomorrow();
        $tomorrowEnd = Carbon::tomorrow()->endOfDay();

        $appointments = Appointment::where('status', 'confirmed')
            ->whereBetween('appointment_time', [$tomorrowStart, $tomorrowEnd])
            ->with(['patient', 'doctor'])
            ->get();

        $count = 0;
        foreach ($appointments as $appointment) {
            $patient = $appointment->patient;
            if ($patient) {
                $patient->notify(new UpcomingAppointmentReminder($appointment));
                $count++;
            }
        }

        $this->info("Successfully sent {$count} reminders.");
        return Command::SUCCESS;
    }
}
