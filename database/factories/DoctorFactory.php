<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'specialization' => fake()->randomElement(['General Practitioner', 'Cardiologist', 'Pediatrician', 'Dermatologist']),
            'bio' => fake()->paragraph(),
            'license_number' => 'MMC-' . fake()->unique()->numberBetween(10000, 99999),
            'consultation_fee' => fake()->randomFloat(2, 50, 200),
        ];
    }
}
