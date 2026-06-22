<?php

use App\Livewire\PatientAppointments;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    Carbon::setTestNow(Carbon::create(2026, 6, 18, 14, 30, 0, 'Asia/Kuala_Lumpur'));
});

afterEach(function () {
    Carbon::setTestNow();
});

it('displays the patient appointments with correct smart sorting order', function () {
    $patient = User::factory()->create(['role' => 'patient']);
    $doctor = User::factory()->create(['role' => 'doctor']);

    // Past appointments (should be sorted descending: closest to Now first)
    $past1 = Appointment::factory()->create([
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'appointment_time' => Carbon::create(2026, 6, 10, 10, 0, 0, 'Asia/Kuala_Lumpur'), // Older past
        'status' => 'completed',
        'created_at' => Carbon::create(2026, 6, 1),
    ]);

    $past2 = Appointment::factory()->create([
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'appointment_time' => Carbon::create(2026, 6, 17, 10, 0, 0, 'Asia/Kuala_Lumpur'), // Newer past
        'status' => 'completed',
        'created_at' => Carbon::create(2026, 6, 2),
    ]);

    // Future appointments (should be sorted ascending: closest to Now first)
    $future1 = Appointment::factory()->create([
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'appointment_time' => Carbon::create(2026, 6, 19, 10, 0, 0, 'Asia/Kuala_Lumpur'), // Closer future
        'status' => 'confirmed',
        'created_at' => Carbon::create(2026, 6, 3),
    ]);

    $future2 = Appointment::factory()->create([
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'appointment_time' => Carbon::create(2026, 6, 25, 10, 0, 0, 'Asia/Kuala_Lumpur'), // Farther future
        'status' => 'pending',
        'created_at' => Carbon::create(2026, 6, 4),
    ]);

    $this->actingAs($patient);

    Livewire::test(PatientAppointments::class)
        ->assertViewHas('appointments', function ($appointments) use ($future1, $future2, $past2, $past1) {
            $ids = $appointments->pluck('id')->toArray();
            // Expected order:
            // 1. $future1 (2026-06-19) - top future (closest first)
            // 2. $future2 (2026-06-25) - bottom future (farthest last)
            // 3. $past2 (2026-06-17) - top past (newest first)
            // 4. $past1 (2026-06-10) - bottom past (oldest last)
            return $ids === [$future1->id, $future2->id, $past2->id, $past1->id];
        });
});

it('filters appointments by status filter tabs correctly', function () {
    $patient = User::factory()->create(['role' => 'patient']);
    $doctor = User::factory()->create(['role' => 'doctor']);

    // 1. Upcoming appointment
    $upcoming = Appointment::factory()->create([
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'appointment_time' => Carbon::create(2026, 6, 20, 10, 0, 0, 'Asia/Kuala_Lumpur'),
        'status' => 'confirmed',
    ]);

    // 2. Completed / past appointment
    $completed = Appointment::factory()->create([
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'appointment_time' => Carbon::create(2026, 6, 10, 10, 0, 0, 'Asia/Kuala_Lumpur'),
        'status' => 'completed',
    ]);

    // 3. Cancelled appointment
    $cancelled = Appointment::factory()->create([
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'appointment_time' => Carbon::create(2026, 6, 21, 10, 0, 0, 'Asia/Kuala_Lumpur'),
        'status' => 'cancelled',
    ]);

    $this->actingAs($patient);

    Livewire::test(PatientAppointments::class)
        // Default (all filter)
        ->assertViewHas('appointments', fn($appointments) => $appointments->count() === 3)
        ->assertViewHas('allCount', 3)
        ->assertViewHas('upcomingCount', 1)
        ->assertViewHas('completedCount', 1)
        ->assertViewHas('cancelledCount', 1)

        // Filter: upcoming
        ->call('setFilter', 'upcoming')
        ->assertViewHas('appointments', function ($appointments) use ($upcoming) {
            return $appointments->count() === 1 && $appointments->first()->id === $upcoming->id;
        })

        // Filter: completed
        ->call('setFilter', 'completed')
        ->assertViewHas('appointments', function ($appointments) use ($completed) {
            return $appointments->count() === 1 && $appointments->first()->id === $completed->id;
        })

        // Filter: cancelled
        ->call('setFilter', 'cancelled')
        ->assertViewHas('appointments', function ($appointments) use ($cancelled) {
            return $appointments->count() === 1 && $appointments->first()->id === $cancelled->id;
        });
});

it('resets pagination page when filter is changed', function () {
    $patient = User::factory()->create(['role' => 'patient']);
    $this->actingAs($patient);

    Livewire::test(PatientAppointments::class)
        ->call('gotoPage', 2)
        ->call('setFilter', 'upcoming')
        ->assertSet('paginators.page', 1);
});
