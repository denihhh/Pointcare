<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        return [
            'patient_id' => User::factory(),
            'doctor_id' => User::factory()->state(['role' => 'doctor']),
            'appointment_time' => now()->addDays(1)->setHour(10)->setMinute(0),
            'reason' => fake()->sentence(),
            'status' => 'pending',
        ];
    }
}
