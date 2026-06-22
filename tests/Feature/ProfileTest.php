<?php

use App\Models\User;
use App\Models\Doctor;

// ═══════════════════════════════════════════════════════════════════
//  PROFILE PAGE ACCESS TESTS
// ═══════════════════════════════════════════════════════════════════

it('redirects guests to login when accessing profile', function () {
    $this->get('/profile')
        ->assertRedirect('/login');
});

it('allows an authenticated patient to view the profile page', function () {
    $patient = User::factory()->create(['role' => 'patient']);

    $this->actingAs($patient)
        ->get('/profile')
        ->assertStatus(200)
        ->assertViewIs('profile.profile')
        ->assertSee('Patient Portal')
        ->assertSee('Personal Vital Ledger')
        ->assertSee('Medical Footprint');
});

it('allows an authenticated doctor to view the profile page', function () {
    $doctor = User::factory()->create(['role' => 'doctor']);
    Doctor::factory()->create(['user_id' => $doctor->id]);

    $this->actingAs($doctor)
        ->get('/profile')
        ->assertStatus(200)
        ->assertViewIs('profile.profile')
        ->assertSee('Clinical Specialist')
        ->assertSee('Clinical Credentials')
        ->assertSee('Consultation Settings');
});

it('shows the user name and member since date on profile', function () {
    $patient = User::factory()->create([
        'role' => 'patient',
        'name' => 'John Doe',
    ]);

    $this->actingAs($patient)
        ->get('/profile')
        ->assertSee('John Doe')
        ->assertSee('Member since');
});

// ═══════════════════════════════════════════════════════════════════
//  PATIENT PROFILE UPDATE TESTS
// ═══════════════════════════════════════════════════════════════════

it('allows a patient to update their vital information', function () {
    $patient = User::factory()->create(['role' => 'patient']);

    $this->actingAs($patient)
        ->post('/profile/patient-info', [
            'date_of_birth' => '1995-06-15',
            'gender' => 'male',
            'emergency_contact_name' => 'Jane Doe',
            'emergency_contact_phone' => '+60123456789',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    $patient->refresh();
    expect($patient->gender)->toBe('male');
    expect($patient->emergency_contact_name)->toBe('Jane Doe');
    expect($patient->emergency_contact_phone)->toBe('+60123456789');
    expect($patient->date_of_birth->format('Y-m-d'))->toBe('1995-06-15');
});

it('validates patient vital fields correctly', function () {
    $patient = User::factory()->create(['role' => 'patient']);

    $this->actingAs($patient)
        ->post('/profile/patient-info', [
            'date_of_birth' => 'not-a-date',
            'gender' => 'invalid-gender',
        ])
        ->assertSessionHasErrors(['date_of_birth', 'gender']);
});

it('allows a patient to update their medical footprint', function () {
    $patient = User::factory()->create(['role' => 'patient']);

    $this->actingAs($patient)
        ->post('/profile/patient-medical', [
            'known_allergies' => 'Penicillin, Latex',
            'chronic_conditions' => 'Type 2 Diabetes',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    $patient->refresh();
    expect($patient->known_allergies)->toBe('Penicillin, Latex');
    expect($patient->chronic_conditions)->toBe('Type 2 Diabetes');
});

// ═══════════════════════════════════════════════════════════════════
//  DOCTOR PROFILE UPDATE TESTS
// ═══════════════════════════════════════════════════════════════════

it('allows a doctor to update their clinical credentials', function () {
    $doctor = User::factory()->create(['role' => 'doctor']);
    Doctor::factory()->create([
        'user_id' => $doctor->id,
        'license_number' => 'OLD-001',
        'specialization' => 'General Medicine',
    ]);

    $this->actingAs($doctor)
        ->post('/profile/doctor-credentials', [
            'license_number' => 'MMC-99999',
            'specialization' => 'Cardiology',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    $doctor->refresh();
    expect($doctor->doctor->license_number)->toBe('MMC-99999');
    expect($doctor->doctor->specialization)->toBe('Cardiology');
});

it('validates doctor credential fields as required', function () {
    $doctor = User::factory()->create(['role' => 'doctor']);

    $this->actingAs($doctor)
        ->post('/profile/doctor-credentials', [
            'license_number' => '',
            'specialization' => '',
        ])
        ->assertSessionHasErrors(['license_number', 'specialization']);
});

it('allows a doctor to update their consultation settings', function () {
    $doctor = User::factory()->create(['role' => 'doctor']);
    Doctor::factory()->create(['user_id' => $doctor->id]);

    $this->actingAs($doctor)
        ->post('/profile/doctor-consultation', [
            'bio' => 'I am a board-certified cardiologist with 15 years of experience.',
            'consultation_location' => 'Block A, Room 302',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    $doctor->refresh();
    expect($doctor->doctor->bio)->toBe('I am a board-certified cardiologist with 15 years of experience.');
});

// ═══════════════════════════════════════════════════════════════════
//  ACCOUNT SETTINGS UPDATE TESTS (SHARED)
// ═══════════════════════════════════════════════════════════════════

it('allows a user to update their email address', function () {
    $user = User::factory()->create([
        'role' => 'patient',
        'email' => 'old@example.com',
    ]);

    $this->actingAs($user)
        ->post('/profile/account', [
            'email' => 'new@example.com',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    $user->refresh();
    expect($user->email)->toBe('new@example.com');
});

it('validates email uniqueness on account update', function () {
    $existing = User::factory()->create(['email' => 'taken@example.com']);
    $user = User::factory()->create(['role' => 'patient']);

    $this->actingAs($user)
        ->post('/profile/account', [
            'email' => 'taken@example.com',
        ])
        ->assertSessionHasErrors(['email']);
});

it('allows a user to update their password', function () {
    $user = User::factory()->create(['role' => 'patient']);

    $this->actingAs($user)
        ->post('/profile/account', [
            'email' => $user->email,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');
});

it('rejects password update when confirmation does not match', function () {
    $user = User::factory()->create(['role' => 'patient']);

    $this->actingAs($user)
        ->post('/profile/account', [
            'email' => $user->email,
            'password' => 'newpassword123',
            'password_confirmation' => 'wrongconfirm',
        ])
        ->assertSessionHasErrors(['password']);
});
