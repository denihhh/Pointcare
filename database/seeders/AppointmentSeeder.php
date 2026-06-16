<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = User::where('role', 'doctor')->with('doctor')->get();
        $patients = User::where('role', 'patient')->get();

        if ($doctors->isEmpty() || $patients->isEmpty()) {
            return;
        }

        $now = Carbon::now('Asia/Kuala_Lumpur');
        $today = Carbon::today('Asia/Kuala_Lumpur');

        // Slot hours allowed in PointCare system
        $allowedSlots = [9, 10, 11, 14, 15, 16];

        // Dictionary of clinical cases by specialization
        $casesBySpecialty = [
            'Cardiologist' => [
                [
                    'reason' => 'Follow-up on coronary artery disease and hypertension.',
                    'symptoms' => 'Occasional mild chest tightness on exertion. No dyspnea at rest. Compliance with medication is good.',
                    'diagnosis' => 'Stable Coronary Artery Disease, Hypertension Stage 1.',
                    'prescription' => 'Bisoprolol 5mg daily, Perindopril 4mg daily, Aspirin 100mg daily.',
                ],
                [
                    'reason' => 'Review of palpitations and fatigue.',
                    'symptoms' => 'Intermittent racing heartbeat at rest, lasting 5-10 minutes. Associated with mild dizziness.',
                    'diagnosis' => 'Paroxysmal Atrial Fibrillation.',
                    'prescription' => 'Diltiazem 90mg twice daily, Warfarin 3mg daily (titrated to INR 2.0-3.0).',
                ]
            ],
            'Pediatrician' => [
                [
                    'reason' => 'High fever and painful throat for 2 days.',
                    'symptoms' => 'Fever up to 39.5°C, poor oral intake, irritability, and painful swallowing.',
                    'diagnosis' => 'Acute Herpangina (Coxsackievirus infection).',
                    'prescription' => 'Paracetamol suspension 250mg/5ml (6ml every 6 hours PRN), Thymol throat spray twice daily.',
                ],
                [
                    'reason' => 'Persistent dry cough and wheezing at night.',
                    'symptoms' => 'Dry hacking cough for 5 days, chest tightness, audible expiratory wheeze. Worse in air-conditioned room.',
                    'diagnosis' => 'Acute Asthma Exacerbation.',
                    'prescription' => 'Salbutamol MDI 100mcg (2 puffs every 4-6 hours PRN), Prednisolone 5mg tablets (3 tablets daily for 3 days).',
                ]
            ],
            'Dermatologist' => [
                [
                    'reason' => 'Flaking, red, and itchy lesions on scalp and elbows.',
                    'symptoms' => 'Pruritic erythematous plaques covered with silvery scales on scalp and extensor surfaces of elbows.',
                    'diagnosis' => 'Plaque Psoriasis.',
                    'prescription' => 'Betamethasone Valerate 0.1% ointment (apply twice daily), Coal tar shampoo twice weekly.',
                ],
                [
                    'reason' => 'Severe cystic acne flare-up on face and shoulders.',
                    'symptoms' => 'Multiple painful inflammatory papules, pustules, and deep nodules on face and upper back.',
                    'diagnosis' => 'Severe Acne Vulgaris.',
                    'prescription' => 'Doxycycline 100mg daily, Benzoyl Peroxide 5% gel (apply at night), Clindamycin 1.2% topical gel (apply in the morning).',
                ]
            ],
            'General Practitioner' => [
                [
                    'reason' => 'Acute diarrhea, abdominal cramps, and vomiting.',
                    'symptoms' => 'Watery stools (5-6 times/day), nausea, abdominal cramps, and mild fever. Started after eating street food.',
                    'diagnosis' => 'Acute Gastroenteritis.',
                    'prescription' => 'Oral Rehydration Salts (ORS) 1 sachet per loose stool, Metoclopramide 10mg three times daily PRN, Smecta powder.',
                ],
                [
                    'reason' => 'Fever, runny nose, and body aches.',
                    'symptoms' => 'Low-grade fever (38.2°C), watery rhinorrhea, scratchy throat, and mild headache for 3 days.',
                    'diagnosis' => 'Acute Nasopharyngitis (Common Cold).',
                    'prescription' => 'Paracetamol 500mg every 6 hours PRN, Chlorpheniramine 4mg at night, Lozenges for throat relief.',
                ]
            ],
            'Neurologist' => [
                [
                    'reason' => 'Numbness and tingling in both hands.',
                    'symptoms' => 'Progressive paresthesia in both thumbs, index, and middle fingers. Worse at night. Positive Phalen\'s test.',
                    'diagnosis' => 'Bilateral Carpal Tunnel Syndrome.',
                    'prescription' => 'Mecobalamin 500mcg three times daily, wrist splinting at night, Ibuprofen 400mg twice daily PRN.',
                ],
                [
                    'reason' => 'Frequent tension-type headaches.',
                    'symptoms' => 'Dull, band-like pressing pain around the forehead and temples. Non-pulsating. No nausea or vomiting.',
                    'diagnosis' => 'Chronic Tension-Type Headache.',
                    'prescription' => 'Paracetamol 500mg + Caffeine 65mg (2 tablets PRN), Amitriptyline 10mg daily at night.',
                ]
            ],
            'Psychiatrist' => [
                [
                    'reason' => 'Severe insomnia and lack of motivation.',
                    'symptoms' => 'Difficulty falling and maintaining sleep. Early morning awakening, depressed mood, anhedonia for 1 month.',
                    'diagnosis' => 'Major Depressive Disorder (Moderate Episode).',
                    'prescription' => 'Sertraline 50mg daily in the morning, Zolpidem 10mg daily at night (for 1 week max).',
                ],
                [
                    'reason' => 'Panic attacks and palpitations.',
                    'symptoms' => 'Sudden episodes of intense fear, choking sensation, tachycardia, and sweating, triggered by public spaces.',
                    'diagnosis' => 'Panic Disorder with Agoraphobia.',
                    'prescription' => 'Escitalopram 10mg daily, Alprazolam 0.25mg PRN for acute panic episodes.',
                ]
            ],
            'Orthopedic Surgeon' => [
                [
                    'reason' => 'Severe knee pain and stiffness.',
                    'symptoms' => 'Pain in the right knee joint, worse after prolonged walking or standing. Joint crepitus and mild effusion noted.',
                    'diagnosis' => 'Osteoarthritis of the Right Knee (Grade II).',
                    'prescription' => 'Glucosamine Sulfate 1500mg daily, Celecoxib 200mg daily, topical NSAID gel twice daily.',
                ],
                [
                    'reason' => 'Ankle sprain during sports.',
                    'symptoms' => 'Pain, swelling, and ecchymosis over the lateral aspect of the left ankle. Inability to bear weight immediately after injury.',
                    'diagnosis' => 'Acute Lateral Ankle Sprain (Grade II).',
                    'prescription' => 'RICE protocol (Rest, Ice, Compression, Elevation), Ankle brace support, Meloxicam 15mg daily for 5 days.',
                ]
            ],
            'Ophthalmologist' => [
                [
                    'reason' => 'Redness and purulent discharge in right eye.',
                    'symptoms' => 'Conjunctival hyperemia, foreign body sensation, and crusty yellow discharge on waking up in the morning.',
                    'diagnosis' => 'Acute Bacterial Conjunctivitis (Right Eye).',
                    'prescription' => 'Levofloxacin 0.5% eye drops (1 drop every 4 hours for 7 days), Lubricating eye drops PRN.',
                ],
                [
                    'reason' => 'Dry eye syndrome follow-up.',
                    'symptoms' => 'Gritty, burning sensation in both eyes. Worse in air-conditioned environments and after long computer usage.',
                    'diagnosis' => 'Bilateral Keratoconjunctivitis Sicca (Dry Eye Syndrome).',
                    'prescription' => 'Systane Ultra eye drops (1 drop four times daily), Hylan G-F 20 eye gel at night.',
                ]
            ],
            'ENT Specialist' => [
                [
                    'reason' => 'Vertigo, nausea, and ringing in left ear.',
                    'symptoms' => 'Sudden episodic rotational vertigo lasting hours, accompanied by nausea, sweating, and tinnitus in the left ear.',
                    'diagnosis' => 'Meniere\'s Disease (Left Ear).',
                    'prescription' => 'Betahistine 24mg twice daily, Promethazine 25mg PRN for severe nausea.',
                ],
                [
                    'reason' => 'Chronic nasal blockage and sneezing.',
                    'symptoms' => 'Bilateral nasal congestion, watery rhinorrhea, itchy nose and eyes. Exacerbated by dust and cat dander.',
                    'diagnosis' => 'Allergic Rhinitis.',
                    'prescription' => 'Fluticasone Propionate nasal spray (2 sprays per nostril daily), Loratadine 10mg daily.',
                ]
            ],
            'Obstetrician & Gynecologist' => [
                [
                    'reason' => 'Antenatal checkup at 24 weeks gestation.',
                    'symptoms' => 'Good fetal movement, no contractions, no bleeding or leaking liquor. Blood pressure normal at 110/70 mmHg.',
                    'diagnosis' => 'Gravida 1 Para 0 at 24 weeks - Normal single intrauterine pregnancy.',
                    'prescription' => 'Iberet Folic daily, Calcium Carbonate 500mg daily, fish oil DHA daily.',
                ],
                [
                    'reason' => 'Irregular periods and weight gain.',
                    'symptoms' => 'Oligomenorrhea (cycles 45-60 days), mild hirsutism, acne, and weight gain for the last 6 months.',
                    'diagnosis' => 'Polycystic Ovary Syndrome (PCOS).',
                    'prescription' => 'Metformin 500mg twice daily with meals, Oral Contraceptive Pill (Yasmin) daily for cycle regulation.',
                ]
            ]
        ];

        // 1. Identify specific doctors and patients for loads distribution
        // Doctors:
        // - Busy Doctors: Demo doctor (index 0) and doctor at index 1 and 2
        // - Moderate Doctors: indices 3 to 8
        // - Quiet Doctor: index 9
        $busyDoctors = $doctors->slice(0, 3);
        $quietDoctor = $doctors->last();
        $moderateDoctors = $doctors->slice(3, 6);

        // Patients:
        // - Chronic Patients (with 6-8 appointments): Demo patient (index 0) and indices 1 to 4
        // - Moderate Patients (with 1-3 appointments): indices 5 to 41
        // - Empty Patients (no appointments): indices 42 to 49 (8 patients)
        $chronicPatients = $patients->slice(0, 5);
        $moderatePatients = $patients->slice(5, 37);

        // A list of general medical reasons for pending/confirmed/cancelled appointments
        $generalReasons = [
            'Follow-up review of blood reports.',
            'Consultation for persistent cough and throat tickling.',
            'Follow-up visit for hypertension prescription renewal.',
            'Scheduled childhood vaccination and developmental check.',
            'Consultation for skin rash and itching.',
            'Severe headache and migraine assessment.',
            'Consultation for abdominal discomfort and indigestion.',
            'Right ear blockage consultation.',
            'Prenatal routing checkup.',
            'Knee stiffness and joint pain review.'
        ];

        // Helper to generate a completed clinical case based on doctor's specialty
        $generateCompletedCase = function ($doctor) use ($casesBySpecialty) {
            $specialty = $doctor->doctor->specialization ?? 'General Practitioner';
            $cases = $casesBySpecialty[$specialty] ?? $casesBySpecialty['General Practitioner'];
            return fake()->randomElement($cases);
        };

        // Track booked slots to avoid conflict for the same doctor on the same day
        $bookedSlots = []; // Format: doctor_id => [ 'YYYY-MM-DD HH:MM' => true ]

        $getUniqueSlotTime = function ($doctorId, $date, $allowedSlots) use (&$bookedSlots) {
            $dateString = $date->format('Y-m-d');
            if (!isset($bookedSlots[$doctorId])) {
                $bookedSlots[$doctorId] = [];
            }

            // Shuffle slots to randomize
            shuffle($allowedSlots);
            foreach ($allowedSlots as $hour) {
                $key = "{$dateString} {$hour}:00";
                if (!isset($bookedSlots[$doctorId][$key])) {
                    $bookedSlots[$doctorId][$key] = true;
                    return (clone $date)->setHour($hour)->setMinute(0)->setSecond(0);
                }
            }

            // Fallback if all slots are booked (rare due to random selection and sizing)
            $randomHour = fake()->randomElement($allowedSlots);
            return (clone $date)->setHour($randomHour)->setMinute(0)->setSecond(0);
        };

        // --- SEED CHRONIC PATIENTS (many appointments) ---
        foreach ($chronicPatients as $patient) {
            // Seed 4 past completed appointments (chronic history)
            for ($i = 0; $i < 4; $i++) {
                $doctor = fake()->randomElement($busyDoctors);
                $case = $generateCompletedCase($doctor);

                $pastDays = 10 + ($i * 15) + fake()->numberBetween(1, 7);
                $date = (clone $today)->subDays($pastDays);
                $time = $getUniqueSlotTime($doctor->id, $date, $allowedSlots);

                Appointment::create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'appointment_time' => $time,
                    'reason' => $case['reason'],
                    'status' => 'completed',
                    'symptoms' => $case['symptoms'],
                    'diagnosis' => $case['diagnosis'],
                    'prescription' => $case['prescription'],
                ]);
            }

            // Seed 1 past cancelled appointment
            {
                $doctor = fake()->randomElement($moderateDoctors);
                $date = (clone $today)->subDays(fake()->numberBetween(2, 5));
                $time = $getUniqueSlotTime($doctor->id, $date, $allowedSlots);

                Appointment::create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'appointment_time' => $time,
                    'reason' => fake()->randomElement($generalReasons),
                    'status' => 'cancelled',
                ]);
            }

            // Seed 1 today's appointment (confirmed or pending)
            {
                $doctor = fake()->randomElement($busyDoctors);
                // We pick today's date
                $time = $getUniqueSlotTime($doctor->id, $today, $allowedSlots);

                Appointment::create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'appointment_time' => $time,
                    'reason' => fake()->randomElement($generalReasons),
                    'status' => fake()->randomElement(['confirmed', 'pending']),
                ]);
            }

            // Seed 2 upcoming appointments
            for ($i = 0; $i < 2; $i++) {
                $doctor = fake()->randomElement($busyDoctors);
                $futureDays = 3 + ($i * 10) + fake()->numberBetween(1, 5);
                $date = (clone $today)->addDays($futureDays);
                $time = $getUniqueSlotTime($doctor->id, $date, $allowedSlots);

                Appointment::create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'appointment_time' => $time,
                    'reason' => fake()->randomElement($generalReasons),
                    'status' => fake()->randomElement(['confirmed', 'pending']),
                ]);
            }
        }

        // --- SEED MODERATE PATIENTS ---
        foreach ($moderatePatients as $patient) {
            $numAppointments = fake()->numberBetween(1, 3);

            for ($i = 0; $i < $numAppointments; $i++) {
                // Determine status and timeframe
                $type = fake()->randomElement(['past_completed', 'past_cancelled', 'today', 'upcoming']);
                
                // Balance doctor load: quiet doctor gets selected occasionally, busy doctors often, moderate doctors standard
                $rand = fake()->numberBetween(1, 100);
                if ($rand <= 5) {
                    $doctor = $quietDoctor;
                } elseif ($rand <= 45) {
                    $doctor = fake()->randomElement($busyDoctors);
                } else {
                    $doctor = fake()->randomElement($moderateDoctors);
                }

                if ($type === 'past_completed') {
                    $case = $generateCompletedCase($doctor);
                    $date = (clone $today)->subDays(fake()->numberBetween(1, 60));
                    $time = $getUniqueSlotTime($doctor->id, $date, $allowedSlots);

                    Appointment::create([
                        'patient_id' => $patient->id,
                        'doctor_id' => $doctor->id,
                        'appointment_time' => $time,
                        'reason' => $case['reason'],
                        'status' => 'completed',
                        'symptoms' => $case['symptoms'],
                        'diagnosis' => $case['diagnosis'],
                        'prescription' => $case['prescription'],
                    ]);
                } elseif ($type === 'past_cancelled') {
                    $date = (clone $today)->subDays(fake()->numberBetween(1, 60));
                    $time = $getUniqueSlotTime($doctor->id, $date, $allowedSlots);

                    Appointment::create([
                        'patient_id' => $patient->id,
                        'doctor_id' => $doctor->id,
                        'appointment_time' => $time,
                        'reason' => fake()->randomElement($generalReasons),
                        'status' => 'cancelled',
                    ]);
                } elseif ($type === 'today') {
                    $time = $getUniqueSlotTime($doctor->id, $today, $allowedSlots);

                    Appointment::create([
                        'patient_id' => $patient->id,
                        'doctor_id' => $doctor->id,
                        'appointment_time' => $time,
                        'reason' => fake()->randomElement($generalReasons),
                        'status' => fake()->randomElement(['confirmed', 'pending']),
                    ]);
                } else {
                    // upcoming
                    $date = (clone $today)->addDays(fake()->numberBetween(1, 30));
                    $time = $getUniqueSlotTime($doctor->id, $date, $allowedSlots);

                    Appointment::create([
                        'patient_id' => $patient->id,
                        'doctor_id' => $doctor->id,
                        'appointment_time' => $time,
                        'reason' => fake()->randomElement($generalReasons),
                        'status' => fake()->randomElement(['confirmed', 'pending']),
                    ]);
                }
            }
        }
    }
}
