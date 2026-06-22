<?php

namespace App\Livewire;

use App\Livewire\Concerns\GuardsInvalidPagination;
use App\Services\AppointmentQueryService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Appointment;
use Carbon\Carbon;

class DoctorQueue extends Component
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
        $doctorId = Auth::id();
        $perPage = 5;
        $today = Carbon::today('Asia/Kuala_Lumpur')->toDateTimeString();

        $appointments = $this->ensureValidPage(
            $this->appointmentQueryService->getDoctorAppointments($doctorId, $perPage, $this->getPage(), $this->statusFilter),
            fn () => $this->appointmentQueryService->getDoctorAppointments($doctorId, $perPage, 1, $this->statusFilter)
        );

        $allCount = Appointment::where('doctor_id', $doctorId)->count();

        $upcomingCount = Appointment::where('doctor_id', $doctorId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('appointment_time', '>=', $today)
            ->count();

        $completedCount = Appointment::where('doctor_id', $doctorId)
            ->where(function ($q) use ($today) {
                $q->where('status', 'completed')
                    ->orWhere(function ($sub) use ($today) {
                        $sub->where('appointment_time', '<', $today)
                            ->where('status', '!=', 'cancelled');
                    });
            })
            ->count();

        $cancelledCount = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'cancelled')
            ->count();

        return view('livewire.doctor-queue', [
            'appointments' => $appointments,
            'allCount' => $allCount,
            'upcomingCount' => $upcomingCount,
            'completedCount' => $completedCount,
            'cancelledCount' => $cancelledCount,
        ]);
    }
}
