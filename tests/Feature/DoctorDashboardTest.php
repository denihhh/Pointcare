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
        ->assertSee('Clinical Queue');    // Checks for text only a doctor should see
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

it('allows a doctor to see the doctor schedule page', function () {
    $doctor = User::factory()->create(['role' => 'doctor']);

    $this->actingAs($doctor)
        ->get('/schedule')
        ->assertStatus(200)
        ->assertViewIs('doctor.schedule')
        ->assertSee('Calendar');
});

it('allows a doctor to see the doctor patients page', function () {
    $doctor = User::factory()->create(['role' => 'doctor']);

    $this->actingAs($doctor)
        ->get('/patients')
        ->assertStatus(200)
        ->assertViewIs('doctor.patients')
        ->assertSee('My Patients');
});

it('allows a doctor to view a patient consultation detail page', function () {
    $doctor = User::factory()->create(['role' => 'doctor']);
    $patient = User::factory()->create(['role' => 'patient']);

    \App\Models\Appointment::factory()->create([
        'doctor_id' => $doctor->id,
        'patient_id' => $patient->id,
        'status' => 'completed',
    ]);

    $this->actingAs($doctor)
        ->get('/patients/' . $patient->id)
        ->assertStatus(200)
        ->assertViewIs('doctor.patient-detail')
        ->assertSee($patient->name);
});

it('returns 404 when doctor views a patient with no shared appointments', function () {
    $doctor = User::factory()->create(['role' => 'doctor']);
    $patient = User::factory()->create(['role' => 'patient']);

    $this->actingAs($doctor)
        ->get('/patients/' . $patient->id)
        ->assertStatus(404);
});

it('allows a doctor to see the clinical records page', function () {
    $doctor = User::factory()->create(['role' => 'doctor']);

    $this->actingAs($doctor)
        ->get('/clinical-records')
        ->assertStatus(200)
        ->assertViewIs('doctor.clinical-records')
        ->assertSee('Clinical Records');
});

it('redirects old clinical URLs to unified clinical records page', function () {
    $doctor = User::factory()->create(['role' => 'doctor']);

    $this->actingAs($doctor)
        ->get('/medical-records')
        ->assertRedirect('/clinical-records');

    $this->actingAs($doctor)
        ->get('/prescriptions')
        ->assertRedirect('/clinical-records');

    $this->actingAs($doctor)
        ->get('/consultation-notes')
        ->assertRedirect('/clinical-records');
});

it('prevents patients from accessing doctor clinical records', function () {
    $patient = User::factory()->create(['role' => 'patient']);

    $this->actingAs($patient)
        ->get('/clinical-records')
        ->assertStatus(403);
});
