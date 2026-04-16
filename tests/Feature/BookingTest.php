<?php


use App\Models\User;
use App\Models\Appointment;

// tests/Feature/BookingTest.php
it('allows a patient to access the dashboard', function () {
    $patient = User::factory()->create(['role' => 'patient']);

    $this->actingAs($patient)
        ->get('/dashboard')
        ->assertStatus(200)
        ->assertSee('Appointment Lists');
         // Better to check if the specific UI text is visible
});


