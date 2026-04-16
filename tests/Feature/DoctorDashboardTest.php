<?php

use App\Models\User;

it('allows a doctor to see the doctor dashboard', function () {
    // 1. Create a user with the doctor role
    $doctor = User::factory()->create(['role' => 'doctor']);

    // 2. Act as that doctor and visit the dashboard
    $this->actingAs($doctor)
        ->get('/dashboard')
        ->assertStatus(200)
        ->assertViewIs('doctor.dashboard') // Specifically checks if it loaded the doctor view
        ->assertSee('Doctor Queue');    // Checks for text only a doctor should see
});

it('prevents a patient from seeing the doctor dashboard view', function () {
    $patient = User::factory()->create(['role' => 'patient']);

    $this->actingAs($patient)
        ->get('/dashboard')
        // In your current controller, patients see the patient.dashboard
        // So we assert they DON'T see doctor-specific text
        ->assertDontSee('Doctor Queue')
        ->assertViewIs('patient.dashboard');
});