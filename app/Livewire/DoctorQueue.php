<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class DoctorQueue extends Component
{
    // The render method runs every time the component "polls"
    public function render()
    {
        $appointments = Appointment::where('doctor_id', Auth::id())
            ->with('patient')
            ->orderBy('appointment_time', 'asc')
            ->get();

        return view('livewire.doctor-queue', [
            'appointments' => $appointments
        ]);
    }
}
