<?php

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows a patient to book an appointment successfully', function () {
    $patient = User::factory()->create(['role' => 'patient']);
    $doctor = User::factory()->create(['role' => 'doctor']);

    $this->actingAs($patient)
        ->post('/appointments', [
            'doctor_id' => $doctor->id,
            'appointment_time' => now()->addDays(2)->format('Y-m-d H:i:s'),
            'reason' => ''
        ])
        ->assertRedirect('/dashboard');

    $this->assertDatabaseHas('appointments', [
        'reason' => 'Monthly health checkup',
        'patient_id' => $patient->id
    ]);
});

it('allows a doctor to approve an appointment', function () {
    $doctor = User::factory()->create(['role' => 'doctor']);
    $appointment = Appointment::factory()->create(['doctor_id' => $doctor->id, 'status' => 'pending']);

    $this->actingAs($doctor)
        ->patch("/appointments/{$appointment->id}/status", ['status' => 'confirmed'])
        ->assertSessionHas('alert', 'Status updated to confirmed');

    expect($appointment->fresh()->status)->toBe('confirmed');
});

it('prevents a patient from editing a confirmed appointment', function () {
    $patient = User::factory()->create(['role' => 'patient']);
    $appointment = Appointment::factory()->create(['patient_id' => $patient->id, 'status' => 'confirmed']);

    $this->actingAs($patient)
        ->patch("/appointments/{$appointment->id}", [
            'doctor_id' => $appointment->doctor_id,
            'appointment_time' => now()->addDays(3)->format('Y-m-d H:i:s'),
            'reason' => 'Trying to edit confirmed'
        ])
        ->assertSessionHas('error');

    expect($appointment->fresh()->reason)->not->toBe('Trying to edit confirmed');
});

it('allows a doctor to complete a consultation with medical notes', function () {
    $doctor = User::factory()->create(['role' => 'doctor']);
    $appointment = Appointment::factory()->create(['doctor_id' => $doctor->id, 'status' => 'confirmed']);

    $this->actingAs($doctor)
        ->patch("/consultation/{$appointment->id}/complete", [
            'symptoms' => 'Fever and chills',
            'diagnosis' => 'Influenza',
            'prescription' => 'Antivirals and Rest'
        ])
        ->assertRedirect('/dashboard');

    $freshAppointment = $appointment->fresh();
    expect($freshAppointment->status)->toBe('completed')
        ->and($freshAppointment->diagnosis)->toBe('Influenza');
});

it('denies unauthorized users from viewing clinical records', function () {
    $stranger = User::factory()->create(['role' => 'patient']);
    $appointment = Appointment::factory()->create(['status' => 'completed']);

    $this->actingAs($stranger)
        ->get("/appointments/{$appointment->id}/record")
        ->assertStatus(403);
});
