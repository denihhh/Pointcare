<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Easy-to-remember Demo Accounts:
 * 
 * Admin:
 * - Email: admin@pointcare.test
 * - Password: password
 * 
 * Patient:
 * - Email: patient@pointcare.test
 * - Password: password
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed the Admin account
        User::factory()->admin()->create([
            'name' => 'System Administrator',
            'email' => 'admin@pointcare.test',
            'password' => Hash::make('password'),
        ]);

        // 2. Seed the Demo Patient account
        User::factory()->patient()->create([
            'name' => 'Ahmad Syazwan',
            'email' => 'patient@pointcare.test',
            'password' => Hash::make('password'),
        ]);

        // 3. Seed remaining 49 realistic patient accounts
        $malayNames = [
            'Muhammad Amin bin Yusof', 'Siti Fatima binti Abdullah', 'Lee Chong Wei',
            'Kavitha d/o Murugan', 'Tan Min Er', 'Sarah binti Ibrahim', 'Chong Ah Kow',
            'Vanesh a/l Balasingam', 'Nurul Izzah binti Ahmad', 'Mohd Ridzuan bin Osman',
            'Lim Wei Kiat', 'Kamarul Ariffin bin Mansor', 'Deepak a/l Ramasamy',
            'Cheah Siew May', 'Zurina binti Hashim', 'Muhammad Aqil bin Rosli',
            'Noraini binti Mohd Zain', 'David Tan Hock Seng', 'Subramaniam a/l Krishnan',
            'Aishah binti Rahman', 'Azman bin Idris', 'Wong Mei Ling', 'Rajasegaran a/l Muniandy',
            'Hanisah binti Ghazali', 'Fairuz bin Zakaria', 'Ng Kok Wah', 'Shanmugam a/l Arumugam',
            'Mastura binti Kamaruddin', 'Zulkifli bin Mohamad', 'Chan Yee Wen',
            'Logeswaran a/l Velu', 'Farhana binti Salleh', 'Khairul Anwar bin Basri',
            'Chin Kah Fook', 'Meera d/o Selvaraj', 'Siti Aminah binti Kassim',
            'Mustafa bin Alwi', 'Ting Siew Ping', 'Suresh a/l Ganesan', 'Fadhilah binti Hamzah',
            'Zulhelmi bin Hassan', 'Teoh Bee Leng', 'Ramesh a/l Lingam', 'Diana binti Roslan',
            'Ahmad Kamal bin Jalil', 'Low Siew Hwa', 'Ambiga d/o Nathan', 'Aisha binti Sulaiman',
            'Hazim bin Md Nor'
        ];

        foreach ($malayNames as $name) {
            // Convert name to email friendly format
            $cleanName = strtolower(str_replace([' bin ', ' binti ', ' a/l ', ' d/o ', ' '], ['', '', '', '', '.'], $name));
            // Clean up any special characters
            $cleanName = preg_replace('/[^a-z0-9.]/', '', $cleanName);
            $email = substr($cleanName, 0, 25) . fake()->numberBetween(10, 99) . '@pointcare.test';

            User::factory()->patient()->create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('password'),
            ]);
        }
    }
}
