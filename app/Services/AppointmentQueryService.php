<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class AppointmentQueryService
{
    public function getAvailableSlots(int $doctorId, string $date): array
    {
        $now = Carbon::now('Asia/Kuala_Lumpur');
        $selectedDate = Carbon::parse($date, 'Asia/Kuala_Lumpur');
        $potentialSlots = ['09:00', '10:00', '11:00', '14:00', '15:00', '16:00'];

        $bookedSlots = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_time', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('appointment_time')
            ->map(fn ($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        $availableSlots = array_filter($potentialSlots, function ($slot) use ($selectedDate, $now, $bookedSlots) {
            if (in_array($slot, $bookedSlots)) {
                return false;
            }

            if ($selectedDate->isToday()) {
                $slotDateTime = Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $selectedDate->format('Y-m-d') . ' ' . $slot,
                    'Asia/Kuala_Lumpur'
                );
                if ($slotDateTime->lessThan($now)) {
                    return false;
                }
            }

            return true;
        });

        return array_values($availableSlots);
    }

    public function getPatientAppointments(int $patientId, int $perPage = 5, int $page = 1): LengthAwarePaginator
    {
        return $this->paginateWithGuard(
            Appointment::query()
                ->where('patient_id', $patientId)
                ->with('doctor')
                ->orderBy('appointment_time', 'asc'),
            $perPage,
            $page
        );
    }

    public function getDoctorAppointments(int $doctorId, int $perPage = 5, int $page = 1): LengthAwarePaginator
    {
        return $this->paginateWithGuard(
            Appointment::query()
                ->where('doctor_id', $doctorId)
                ->with('patient')
                ->orderBy('appointment_time', 'asc'),
            $perPage,
            $page
        );
    }

    private function paginateWithGuard(Builder $query, int $perPage, int $page): LengthAwarePaginator
    {
        $page = max(1, $page);

        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        if ($paginator->currentPage() > $paginator->lastPage()) {
            return $query->paginate($perPage, ['*'], 'page', 1);
        }

        return $paginator;
    }

    public function getDoctorsForSelect()
    {
        return User::doctors()->select('id', 'name')->get();
    }
}
