<?php

namespace App\Livewire;

use App\Livewire\Concerns\GuardsInvalidPagination;
use App\Services\AppointmentQueryService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PatientAppointments extends Component
{
    use GuardsInvalidPagination;
    use WithPagination;

    protected AppointmentQueryService $appointmentQueryService;

    public function boot(AppointmentQueryService $appointmentQueryService): void
    {
        $this->appointmentQueryService = $appointmentQueryService;
    }

    public function render()
    {
        $patientId = Auth::id();
        $perPage = 5;

        $appointments = $this->ensureValidPage(
            $this->appointmentQueryService->getPatientAppointments($patientId, $perPage, $this->getPage()),
            fn() => $this->appointmentQueryService->getPatientAppointments($patientId, $perPage, 1)
        );

        return view('livewire.patient-appointments', [
            'appointments' => $appointments,
        ]);
    }
}