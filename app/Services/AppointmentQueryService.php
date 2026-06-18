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

    public function getPatientAppointments(int $patientId, int $perPage = 5, int $page = 1, string $statusFilter = 'all'): LengthAwarePaginator
    {
        $now = Carbon::now('Asia/Kuala_Lumpur');
        $today = Carbon::today('Asia/Kuala_Lumpur');

        $query = Appointment::query()
            ->where('patient_id', $patientId)
            ->with('doctor');

        if ($statusFilter === 'upcoming') {
            $query->whereIn('status', ['pending', 'confirmed'])
                ->where('appointment_time', '>=', $today->toDateTimeString());
        } elseif ($statusFilter === 'completed') {
            $query->where(function ($q) use ($today) {
                $q->where('status', 'completed')
                    ->orWhere(function ($sub) use ($today) {
                        $sub->where('appointment_time', '<', $today->toDateTimeString())
                            ->where('status', '!=', 'cancelled');
                    });
            });
        } elseif ($statusFilter === 'cancelled') {
            $query->where('status', 'cancelled');
        }

        $nowStr = $now->toDateTimeString();

        $query->orderByRaw('CASE WHEN appointment_time >= ? THEN 0 ELSE 1 END ASC', [$nowStr])
            ->orderByRaw('CASE WHEN appointment_time >= ? THEN appointment_time END ASC', [$nowStr])
            ->orderByRaw('CASE WHEN appointment_time < ? THEN appointment_time END DESC', [$nowStr]);

        return $this->paginateWithGuard($query, $perPage, $page);
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
