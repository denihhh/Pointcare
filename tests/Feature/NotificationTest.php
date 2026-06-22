<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\User;
use App\Notifications\AppointmentConfirmed;
use App\Notifications\AppointmentRejected;
use App\Notifications\BookingCancelled;
use App\Notifications\NewBookingRequest;
use App\Notifications\UpcomingAppointmentReminder;
use App\Services\AppointmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_booking_an_appointment_sends_notification_to_doctor()
    {
        Notification::fake();

        $patient = User::factory()->create(['role' => 'patient']);
        $doctor = User::factory()->create(['role' => 'doctor']);

        $service = app(AppointmentService::class);
        $service->create([
            'doctor_id' => $doctor->id,
            'appointment_time' => now()->addDays(2)->format('Y-m-d H:i:s'),
            'reason' => 'Checkup',
        ], $patient->id);

        Notification::assertSentTo($doctor, NewBookingRequest::class);
    }

    public function test_doctor_confirming_an_appointment_sends_notification_to_patient()
    {
        Notification::fake();

        $patient = User::factory()->create(['role' => 'patient']);
        $doctor = User::factory()->create(['role' => 'doctor']);

        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'appointment_time' => now()->addDays(2),
            'reason' => 'Checkup',
            'status' => 'pending',
        ]);

        $service = app(AppointmentService::class);
        $service->updateStatus($appointment, 'confirmed');

        Notification::assertSentTo($patient, AppointmentConfirmed::class);
    }

    public function test_doctor_rejecting_an_appointment_sends_notification_to_patient()
    {
        Notification::fake();

        $patient = User::factory()->create(['role' => 'patient']);
        $doctor = User::factory()->create(['role' => 'doctor']);

        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'appointment_time' => now()->addDays(2),
            'reason' => 'Checkup',
            'status' => 'pending',
        ]);

        $service = app(AppointmentService::class);
        $service->updateStatus($appointment, 'cancelled');

        Notification::assertSentTo($patient, AppointmentRejected::class);
    }

    public function test_patient_cancelling_an_appointment_sends_notification_to_doctor()
    {
        Notification::fake();

        $patient = User::factory()->create(['role' => 'patient']);
        $doctor = User::factory()->create(['role' => 'doctor']);

        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'appointment_time' => now()->addDays(2),
            'reason' => 'Checkup',
            'status' => 'pending',
        ]);

        $service = app(AppointmentService::class);
        $service->cancel($appointment);

        Notification::assertSentTo($doctor, BookingCancelled::class);
    }

    public function test_reminder_command_sends_notification_to_patient_with_appointment_tomorrow()
    {
        Notification::fake();

        $patient = User::factory()->create(['role' => 'patient']);
        $doctor = User::factory()->create(['role' => 'doctor']);

        // Appointment tomorrow
        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'appointment_time' => now()->addDay()->setHour(10)->setMinute(0)->setSecond(0),
            'reason' => 'Checkup',
            'status' => 'confirmed',
        ]);

        $this->artisan('appointments:send-reminders')
            ->expectsOutput('Starting to send appointment reminders...')
            ->expectsOutput('Successfully sent 1 reminders.')
            ->assertExitCode(0);

        Notification::assertSentTo($patient, UpcomingAppointmentReminder::class);
    }
}
