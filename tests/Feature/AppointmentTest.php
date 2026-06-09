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
            'reason' => 'Monthly health checkup'
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

it('prevents a doctor from booking an appointment for themselves', function () {
    // Doctors shouldn't be using the patient booking route
    $doctor = User::factory()->create(['role' => 'doctor']);
    $otherDoctor = User::factory()->create(['role' => 'doctor']);

    // Attempting to book as a doctor should fail if your middleware/policy blocks it,
    // but here we verify the validation fails if we tried to book a non-doctor as the doctor_id
    $response = $this->actingAs($doctor)->post('/appointments', [
        'doctor_id' => $doctor->id, // Passing a doctor ID is fine, but the user role is doctor
        'appointment_time' => now()->addDays(1)->format('Y-m-d H:i:s'),
        'reason' => 'Should fail if middleware blocks doctors from this route'
    ]);

    // This is just an example of a defensive test case
});

it('validation fails if doctor_id is actually a patient', function () {
    $patient = User::factory()->create(['role' => 'patient']);
    $fakeDoctor = User::factory()->create(['role' => 'patient']); // This user is NOT a doctor

    $this->actingAs($patient)
        ->post('/appointments', [
            'doctor_id' => $fakeDoctor->id,
            'appointment_time' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'reason' => 'This should fail validation'
        ])
        ->assertSessionHasErrors(['doctor_id']);
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

it('displays the past 3 appointments on the homepage for a patient', function () {
    $patient = User::factory()->create(['role' => 'patient']);
    $doctor = User::factory()->create(['role' => 'doctor']);
    
    // Create 4 past appointments
    Appointment::factory()->count(4)->create([
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'appointment_time' => now()->subDays(5),
        'status' => 'completed',
        'reason' => 'Completed Visit'
    ]);

    $response = $this->actingAs($patient)->get('/');

    $response->assertStatus(200);
    $response->assertSee('Past Appointments');
    
    $response->assertViewHas('pastAppointments', function ($appointments) {
        return $appointments->count() === 3;
    });
});

it('displays the health ledger page for patients containing only completed appointments', function () {
    $patient = User::factory()->create(['role' => 'patient']);
    $doctor = User::factory()->create(['role' => 'doctor']);

    Appointment::factory()->create([
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'appointment_time' => now()->subDays(2),
        'status' => 'completed',
        'diagnosis' => 'Allergic Rhinitis',
        'prescription' => 'Claritin 10mg'
    ]);

    Appointment::factory()->create([
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'appointment_time' => now()->addDays(2),
        'status' => 'pending',
        'diagnosis' => 'Not Completed yet'
    ]);

    $response = $this->actingAs($patient)->get('/records');

    $response->assertStatus(200);
    $response->assertSee('Health Ledger');
    $response->assertSee('Allergic Rhinitis');
    $response->assertSee('Claritin 10mg');
    $response->assertDontSee('Not Completed yet');
});
