<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        $reasons = [
            'Follow-up on type 2 diabetes mellitus and medication adjustment.',
            'Severe migraine attacks with nausea and sensitivity to light.',
            'Chronic lower back pain radiating to right calf.',
            'Childhood immunization assessment and developmental screening.',
            'Routine prenatal checkup (third trimester) and ultrasound.',
            'Suspected tonsillitis, painful swallowing, and high fever.',
            'Persistent dry cough, mild shortness of breath, and fatigue.',
            'Evaluation of itchy skin lesions on limbs and neck.',
            'Blocked right ear with reduced hearing after swimming.',
            'Annual general health wellness screening and blood profile review.'
        ];

        return [
            'patient_id' => User::factory()->patient(),
            'doctor_id' => User::factory()->doctor(),
            'appointment_time' => Carbon::now('Asia/Kuala_Lumpur')
                ->addDays(1)
                ->setHour(10)
                ->setMinute(0)
                ->setSecond(0),
            'reason' => fake()->randomElement($reasons),
            'status' => 'pending',
            'symptoms' => null,
            'diagnosis' => null,
            'prescription' => null,
        ];
    }

    /**
     * Set status to pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Set status to confirmed.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
        ]);
    }

    /**
     * Set status to cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }

    /**
     * Set status to completed and populate realistic clinical details.
     */
    public function completed(): static
    {
        return $this->state(function (array $attributes) {
            $cases = [
                [
                    'reason' => 'Routine cardiac follow-up for chest tightness.',
                    'symptoms' => 'Mild exertion-induced chest tightness. No radiating pain to left arm. Palpitations reported during stress.',
                    'diagnosis' => 'Stable Angina Pectoris, controlled hypertension.',
                    'prescription' => 'Amlodipine 5mg daily, Glyceryl Trinitrate (GTN) 0.5mg sublingual PRN for chest pain, Aspirin 75mg daily.',
                ],
                [
                    'reason' => 'High fever and persistent dry cough for the last 3 days.',
                    'symptoms' => 'Fever peaks at 39°C. Poor appetite, productive cough with yellow phlegm, mild rhinorrhea.',
                    'diagnosis' => 'Acute Bronchitis.',
                    'prescription' => 'Paracetamol Syrup 120mg/5ml (5ml every 6 hours PRN), Salbutamol Syrup 2mg/5ml (2.5ml three times daily).',
                ],
                [
                    'reason' => 'Severe itchy red rashes spreading on both arms.',
                    'symptoms' => 'Erythematous, dry, scaly patches on flexural surfaces of arms. Intense pruritus, especially at night.',
                    'diagnosis' => 'Atopic Dermatitis (Eczema).',
                    'prescription' => 'Clobetasol Propionate 0.05% cream (apply twice daily), Cetirizine 10mg daily for itching.',
                ],
                [
                    'reason' => 'Fever, sore throat, and body aches.',
                    'symptoms' => 'High fever, painful swallowing, swollen tonsils with exudate, mild headache, and general malaise.',
                    'diagnosis' => 'Acute Tonsillitis.',
                    'prescription' => 'Amoxicillin 500mg three times daily for 7 days, Paracetamol 500mg every 6 hours PRN.',
                ],
                [
                    'reason' => 'Frequent migraine attacks with nausea.',
                    'symptoms' => 'Unilateral, throbbing headache localized to the left temple. Occurs 3-4 times a week. Aggravated by light and sound.',
                    'diagnosis' => 'Chronic Migraine without Aura.',
                    'prescription' => 'Sumatriptan 50mg PRN at onset of headache, Propranolol 40mg twice daily for prophylaxis.',
                ],
                [
                    'reason' => 'Chronic lower back pain radiating down to the right leg.',
                    'symptoms' => 'Sharp lower back pain, exacerbated by bending forward. Numbness in the right L5 dermatome distribution.',
                    'diagnosis' => 'Lumbar Disc Prolapse (L4/L5) with right sciatica.',
                    'prescription' => 'Etoricoxib 90mg daily for 7 days, Mecobalamin 500mcg three times daily.',
                ]
            ];
            $case = fake()->randomElement($cases);
            return [
                'status' => 'completed',
                'reason' => $case['reason'],
                'symptoms' => $case['symptoms'],
                'diagnosis' => $case['diagnosis'],
                'prescription' => $case['prescription'],
            ];
        });
    }

    /**
     * Set appointment_time in the past.
     */
    public function past(): static
    {
        return $this->state(fn (array $attributes) => [
            'appointment_time' => Carbon::now('Asia/Kuala_Lumpur')
                ->subDays(fake()->numberBetween(1, 90))
                ->setHour(fake()->randomElement([9, 10, 11, 14, 15, 16]))
                ->setMinute(0)
                ->setSecond(0),
        ]);
    }

    /**
     * Set appointment_time to today.
     */
    public function today(): static
    {
        return $this->state(fn (array $attributes) => [
            'appointment_time' => Carbon::now('Asia/Kuala_Lumpur')
                ->setHour(fake()->randomElement([9, 10, 11, 14, 15, 16]))
                ->setMinute(0)
                ->setSecond(0),
        ]);
    }

    /**
     * Set appointment_time in the future.
     */
    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'appointment_time' => Carbon::now('Asia/Kuala_Lumpur')
                ->addDays(fake()->numberBetween(1, 60))
                ->setHour(fake()->randomElement([9, 10, 11, 14, 15, 16]))
                ->setMinute(0)
                ->setSecond(0),
        ]);
    }
}
