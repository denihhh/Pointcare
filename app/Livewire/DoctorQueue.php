<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class DoctorQueue extends Component
{
    use WithPagination;
    // The render method runs every time the component "polls"
    public function render()
    {
        // untuk pagination
        $appointments = Appointment::where ('doctor_id', Auth::id())
            ->with('patient')
            ->orderBy('appointment_time', 'asc')
            ->paginate(5);
        return view('livewire.doctor-queue', [
            'appointments' => $appointments
        ]);
        // $appointments = Appointment::where('doctor_id', Auth::id())
        //     ->with('patient')
        //     ->orderBy('appointment_time', 'asc')
        //     ->get();

        // return view('livewire.doctor-queue', [
        //     'appointments' => $appointments
        // ]);
    }
}
