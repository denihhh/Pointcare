<?php

namespace App\Livewire;

use App\Livewire\Concerns\GuardsInvalidPagination;
use App\Services\AppointmentQueryService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DoctorQueue extends Component
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
        $doctorId = Auth::id();
        $perPage = 5;

        $appointments = $this->ensureValidPage(
            $this->appointmentQueryService->getDoctorAppointments($doctorId, $perPage, $this->getPage()),
            fn () => $this->appointmentQueryService->getDoctorAppointments($doctorId, $perPage, 1)
        );

        return view('livewire.doctor-queue', [
            'appointments' => $appointments,
        ]);
    }
}
