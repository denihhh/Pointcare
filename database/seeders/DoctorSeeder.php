<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Easy-to-remember Demo Accounts:
 * 
 * Doctor:
 * - Email: doctor@pointcare.test
 * - Password: password
 */
class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed the Demo Doctor user account
        $demoUser = User::factory()->doctor()->create([
            'name' => 'Dr. Haris Rahim',
            'email' => 'doctor@pointcare.test',
            'password' => Hash::make('password'),
        ]);

        // Create the corresponding Doctor record
        Doctor::create([
            'user_id' => $demoUser->id,
            'specialization' => 'Cardiologist',
            'bio' => 'Senior Cardiologist with over 15 years of clinical experience. MD from Universiti Malaya. Specializes in adult cardiovascular health, heart failure management, and interventional cardiology. Clinic Schedule: Monday - Thursday, 9:00 AM - 4:00 PM. Contact: +60 12-345 6789. Address: Pantai Hospital Kuala Lumpur, 8 Jalan Pantai Baharu, 59100 Kuala Lumpur, Malaysia.',
            'license_number' => 'MMC-12345',
            'consultation_fee' => 150.00,
        ]);

        // 2. Seed remaining 9 realistic doctor accounts with different specializations
        $doctorsData = [
            [
                'name' => 'Dr. Siti Aminah binti Yusuf',
                'email' => 'dr.sitiaminah@pointcare.test',
                'specialization' => 'Pediatrician',
                'bio' => 'Consultant Pediatrician with a focus on child development, neonatology, and pediatric allergy care. Practicing at Subang Jaya Medical Centre. Schedule: Monday - Friday, 9:00 AM - 1:00 PM, 2:00 PM - 5:00 PM. Contact: +60 13-987 6543. Address: Subang Jaya Medical Centre, 1 Jalan SS 12/1A, 47500 Subang Jaya, Selangor, Malaysia.',
                'license_number' => 'MMC-22894',
                'consultation_fee' => 120.00,
            ],
            [
                'name' => 'Dr. Tan Kah Seng',
                'email' => 'dr.tanks@pointcare.test',
                'specialization' => 'Dermatologist',
                'bio' => 'Experienced Clinical Dermatologist specializing in pediatric eczema, psoriasis, skin cancer screening, and dermatological surgery. Practicing at Sunway Medical Centre. Schedule: Tuesday - Friday, 9:00 AM - 4:00 PM. Contact: +60 12-445 9812. Address: Sunway Medical Centre, 5 Jalan Lagoon Selatan, Bandar Sunway, 47500 Petaling Jaya, Selangor, Malaysia.',
                'license_number' => 'MMC-31562',
                'consultation_fee' => 180.00,
            ],
            [
                'name' => 'Dr. Rajesh Kumar a/l Pillai',
                'email' => 'dr.rajesh@pointcare.test',
                'specialization' => 'General Practitioner',
                'bio' => 'Family Physician dedicated to preventative health, chronic disease screening, and pediatric primary care. Practicing at Poliklinik PointCare Cheras. Schedule: Monday - Saturday, 8:30 AM - 1:00 PM. Contact: +60 17-662 1045. Address: Poliklinik PointCare Cheras, 12 Jalan Cheras Indah, 56100 Kuala Lumpur, Malaysia.',
                'license_number' => 'MMC-44910',
                'consultation_fee' => 60.00,
            ],
            [
                'name' => 'Dr. Lim Wei Lung',
                'email' => 'dr.limwl@pointcare.test',
                'specialization' => 'Neurologist',
                'bio' => 'Consultant Neurologist specialized in stroke management, epilepsy, movement disorders, and migraine care. Practicing at Prince Court Medical Centre. Schedule: Monday - Wednesday, Friday, 9:00 AM - 4:30 PM. Contact: +60 16-302 7748. Address: Prince Court Medical Centre, 39 Jalan Kia Peng, 50450 Kuala Lumpur, Malaysia.',
                'license_number' => 'MMC-55021',
                'consultation_fee' => 200.00,
            ],
            [
                'name' => 'Dr. Nurul Huda binti Salleh',
                'email' => 'dr.nurulhuda@pointcare.test',
                'specialization' => 'Psychiatrist',
                'bio' => 'Consultant Psychiatrist specializing in stress management, cognitive behavioral therapy, anxiety, and depression. Practicing at KPJ Damansara Specialist Hospital. Schedule: Monday - Thursday, 9:00 AM - 4:00 PM. Contact: +60 19-812 3456. Address: KPJ Damansara Specialist Hospital, 119 Jalan SS 21/56, Damansara Utama, 47400 Petaling Jaya, Selangor, Malaysia.',
                'license_number' => 'MMC-60312',
                'consultation_fee' => 150.00,
            ],
            [
                'name' => 'Dr. Kelvin Wong',
                'email' => 'dr.kelvinw@pointcare.test',
                'specialization' => 'Orthopedic Surgeon',
                'bio' => 'Orthopedic Surgeon with extensive expertise in joint arthroplasty, sports surgery, and minimally invasive bone trauma repair. Practicing at Gleneagles Kuala Lumpur. Schedule: Monday - Thursday, 10:00 AM - 4:00 PM. Contact: +60 11-2099 8734. Address: Gleneagles Kuala Lumpur, 282 Jalan Ampang, 50450 Kuala Lumpur, Malaysia.',
                'license_number' => 'MMC-70234',
                'consultation_fee' => 190.00,
            ],
            [
                'name' => 'Dr. Priya Pillai',
                'email' => 'dr.priyap@pointcare.test',
                'specialization' => 'Ophthalmologist',
                'bio' => 'Consultant Ophthalmologist and Cataract Surgeon. Specializes in medical retina, dry eye syndrome, and laser refractive correction. Practicing at Tun Hussein Onn National Eye Hospital. Schedule: Monday - Friday, 9:00 AM - 1:00 PM, 2:00 PM - 5:00 PM. Contact: +60 12-701 5462. Address: Tun Hussein Onn National Eye Hospital, Lorong Utara B, Section 52, 46200 Petaling Jaya, Selangor, Malaysia.',
                'license_number' => 'MMC-81145',
                'consultation_fee' => 130.00,
            ],
            [
                'name' => 'Dr. Zulkifli Ahmad',
                'email' => 'dr.zulkifli@pointcare.test',
                'specialization' => 'ENT Specialist',
                'bio' => 'Ear, Nose & Throat Consultant. Expertise in pediatric ENT, endoscopic sinus surgery, and vertigo treatment. Practicing at Columbia Asia Hospital - Puchong. Schedule: Tuesday - Thursday, 9:00 AM - 4:30 PM. Contact: +60 17-910 8823. Address: Columbia Asia Hospital - Puchong, Jalan Puteri 9/1, Bandar Puteri, 47100 Puchong, Selangor, Malaysia.',
                'license_number' => 'MMC-90412',
                'consultation_fee' => 140.00,
            ],
            [
                'name' => 'Dr. Sarah Ong',
                'email' => 'dr.sarahong@pointcare.test',
                'specialization' => 'Obstetrician & Gynecologist',
                'bio' => 'Consultant Obstetrician & Gynecologist. Dedicated to comprehensive women\'s wellness, pre-conception planning, and maternal care. Practicing at Pantai Hospital Kuala Lumpur. Schedule: Monday - Friday, 9:00 AM - 4:00 PM. Contact: +60 12-321 0987. Address: Pantai Hospital Kuala Lumpur, 8 Jalan Pantai Baharu, 59100 Kuala Lumpur, Malaysia.',
                'license_number' => 'MMC-99153',
                'consultation_fee' => 160.00,
            ]
        ];

        foreach ($doctorsData as $data) {
            $user = User::factory()->doctor()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
            ]);

            Doctor::create([
                'user_id' => $user->id,
                'specialization' => $data['specialization'],
                'bio' => $data['bio'],
                'license_number' => $data['license_number'],
                'consultation_fee' => $data['consultation_fee'],
            ]);
        }
    }
}
