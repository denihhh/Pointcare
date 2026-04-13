<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create 5 Users who are Doctors
        User::factory(5)->create([
            'role' => 'doctor',
        ])->each(function ($user) {
            // 2. For each user, create their Doctor profile
            \App\Models\Doctor::factory()->create([
                'user_id' => $user->id,
            ]);
        });

        // 3. Create a test Patient for yourself
        User::factory()->create([
            'name' => 'Test Patient',
            'email' => 'patient@test.com',
            'role' => 'patient',
        ]);
    }
}
