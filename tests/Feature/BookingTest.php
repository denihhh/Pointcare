<?php

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows a patient to create an appointment successfully', function () {
    // 1. Setup: Create a patient and a doctor
    $patient = User::factory()->create(['role' => 'patient']);
    $doctor = User::factory()->create(['role' => 'doctor']);

    // 2. Data: The "inputs" from your form
    $appointmentData = [
        'reason' => 'Annual Health Checkup',
        'doctor_id' => $doctor->id,
        'appointment_time' => now()->addDay()->format('Y-m-d H:i:s'),
    ];

    // 3. Action: Submit the form as the logged-in patient
    $response = $this->actingAs($patient)
        ->post('/appointments', $appointmentData);

    // 4. Assertions:
    // Check it redirects back to dashboard with success (standard Laravel behavior)
    $response->assertRedirect('/dashboard');
    
    // Check the database has the record
    $this->assertDatabaseHas('appointments', [
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'reason' => 'Annual Health Checkup',
    ]);
});

it('requires a reason and doctor to book an appointment', function () {
    $patient = User::factory()->create(['role' => 'patient']);

    // Send empty data
    $response = $this->actingAs($patient)
        ->post('/appointments', []);

    // Assert that validation errors occur
    $response->assertSessionHasErrors(['reason', 'doctor_id', 'appointment_time']);
});