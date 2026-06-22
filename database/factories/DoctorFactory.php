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
        $specializations = [
            'Cardiologist' => [
                'hospitals' => ['Pantai Hospital Kuala Lumpur', 'Gleneagles Kuala Lumpur', 'Prince Court Medical Centre'],
                'bio_details' => 'Specializes in adult cardiovascular health, ischemic heart disease, and heart failure management.',
            ],
            'Pediatrician' => [
                'hospitals' => ['Subang Jaya Medical Centre', 'KPJ Damansara Specialist Hospital', 'Columbia Asia Hospital - Puchong'],
                'bio_details' => 'Focuses on child development, pediatric infectious diseases, and immunization management.',
            ],
            'Dermatologist' => [
                'hospitals' => ['Sunway Medical Centre', 'Gleneagles Kuala Lumpur', 'Pantai Hospital Kuala Lumpur'],
                'bio_details' => 'Specializes in skin oncology, eczema, psoriasis, and clinical aesthetics.',
            ],
            'General Practitioner' => [
                'hospitals' => ['Poliklinik PointCare Cheras', 'Klinik Mediviron Bangsar', 'Poliklinik Kota Damansara'],
                'bio_details' => 'Provides comprehensive primary healthcare, chronic disease screening, and family medicine.',
            ],
            'Neurologist' => [
                'hospitals' => ['Prince Court Medical Centre', 'Subang Jaya Medical Centre', 'Pantai Hospital Kuala Lumpur'],
                'bio_details' => 'Expert in neurological disorders, migraine prophylaxis, and stroke rehabilitation.',
            ],
            'Psychiatrist' => [
                'hospitals' => ['KPJ Damansara Specialist Hospital', 'Sunway Medical Centre', 'Pantai Hospital Kuala Lumpur'],
                'bio_details' => 'Specializes in mood disorders, anxiety management, stress counseling, and adult psychiatry.',
            ],
            'Orthopedic Surgeon' => [
                'hospitals' => ['Gleneagles Kuala Lumpur', 'Prince Court Medical Centre', 'Subang Jaya Medical Centre'],
                'bio_details' => 'Specializes in spine surgery, joint replacements, and sports injury treatments.',
            ],
            'Ophthalmologist' => [
                'hospitals' => ['Tun Hussein Onn National Eye Hospital', 'KPJ Damansara Specialist Hospital', 'Sunway Medical Centre'],
                'bio_details' => 'Expert in cataract surgery, refractive errors, and diabetic retinopathy management.',
            ],
            'ENT Specialist' => [
                'hospitals' => ['Subang Jaya Medical Centre', 'Gleneagles Kuala Lumpur', 'Columbia Asia Hospital - Puchong'],
                'bio_details' => 'Focuses on nasal allergies, sinus disorders, hearing loss, and micro-ear surgeries.',
            ],
            'Obstetrician & Gynecologist' => [
                'hospitals' => ['Pantai Hospital Kuala Lumpur', 'KPJ Damansara Specialist Hospital', 'Prince Court Medical Centre'],
                'bio_details' => 'Provides antenatal checkups, high-risk pregnancy management, and gynecological healthcare.',
            ]
        ];

        $specialization = fake()->randomElement(array_keys($specializations));
        $details = $specializations[$specialization];
        $hospital = fake()->randomElement($details['hospitals']);
        
        $days = fake()->randomElement([
            'Monday - Thursday',
            'Monday - Wednesday, Friday',
            'Tuesday - Friday',
            'Monday - Friday',
        ]);
        $hours = fake()->randomElement([
            '9:00 AM - 4:00 PM',
            '8:30 AM - 1:00 PM, 2:00 PM - 5:00 PM',
            '9:00 AM - 1:00 PM, 2:00 PM - 4:30 PM',
        ]);
        $phone = '+60 ' . fake()->randomElement(['12', '13', '16', '17', '19']) . '-' . fake()->numberBetween(3000000, 9999999);

        $bio = "{$details['bio_details']} Practicing at {$hospital}. " .
               "Schedule: {$days}, {$hours}. Contact: {$phone}. Address: {$hospital}, Selangor/Kuala Lumpur, Malaysia.";

        return [
            'user_id' => User::factory()->doctor(),
            'specialization' => $specialization,
            'bio' => $bio,
            'license_number' => 'MMC-' . fake()->unique()->numberBetween(10000, 99999),
            'consultation_fee' => fake()->randomFloat(2, 60, 200),
        ];
    }
}
