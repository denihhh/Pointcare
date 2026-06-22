<?php

namespace App\Livewire;

use App\Livewire\Concerns\GuardsInvalidPagination;
use App\Services\AppointmentQueryService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Appointment;
use Carbon\Carbon;

class PatientAppointments extends Component
{
    use GuardsInvalidPagination;
    use WithPagination;

    public string $statusFilter = 'all';

    protected AppointmentQueryService $appointmentQueryService;

    public function boot(AppointmentQueryService $appointmentQueryService): void
    {
        $this->appointmentQueryService = $appointmentQueryService;
    }

    public function setFilter(string $status): void
    {
        $this->statusFilter = $status;
        $this->resetPage();
    }

    public function render()
    {
        $patientId = Auth::id();
        $perPage = 5;
        $today = Carbon::today('Asia/Kuala_Lumpur')->toDateTimeString();

        $appointments = $this->ensureValidPage(
            $this->appointmentQueryService->getPatientAppointments($patientId, $perPage, $this->getPage(), $this->statusFilter),
            fn() => $this->appointmentQueryService->getPatientAppointments($patientId, $perPage, 1, $this->statusFilter)
        );

        $allCount = Appointment::where('patient_id', $patientId)->count();

        $upcomingCount = Appointment::where('patient_id', $patientId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('appointment_time', '>=', $today)
            ->count();

        $completedCount = Appointment::where('patient_id', $patientId)
            ->where(function ($q) use ($today) {
                $q->where('status', 'completed')
                    ->orWhere(function ($sub) use ($today) {
                        $sub->where('appointment_time', '<', $today)
                            ->where('status', '!=', 'cancelled');
                    });
            })
            ->count();

        $cancelledCount = Appointment::where('patient_id', $patientId)
            ->where('status', 'cancelled')
            ->count();

        return view('livewire.patient-appointments', [
            'appointments' => $appointments,
            'allCount' => $allCount,
            'upcomingCount' => $upcomingCount,
            'completedCount' => $completedCount,
            'cancelledCount' => $cancelledCount,
        ]);
    }
}