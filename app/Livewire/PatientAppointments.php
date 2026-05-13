<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class PatientAppointments extends Component
{
    public function render()
    {
        $appointments = Appointment::where('patient_id', Auth::id())
            ->with('doctor')
            ->orderBy('appointment_time', 'asc')
            ->get();

        return view('livewire.patient-appointments', [
            'appointments' => $appointments
        ]);
    }
}
