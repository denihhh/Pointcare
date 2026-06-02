<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appointment;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class PatientAppointments extends Component
{
    use WithPagination;
    public function render()
    {
        // untuk pagination
        $appointments = Appointment::where ('patient_id', Auth::id())
            ->with('doctor')
            ->orderBy('appointment_time', 'asc')
            ->paginate(5);
        return view('livewire.patient-appointments', [
            'appointments' => $appointments
        ]);
        // $appointments = Appointment::where('patient_id', Auth::id())
        //     ->with('doctor')
        //     ->orderBy('appointment_time', 'asc')
        //     ->get();

        // return view('livewire.patient-appointments', [
        //     'appointments' => $appointments
        // ]);
    }
}
