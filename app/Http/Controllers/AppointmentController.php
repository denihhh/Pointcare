<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvailableSlotsRequest;
use App\Http\Requests\CompleteConsultationRequest;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Requests\UpdateAppointmentStatusRequest;
use App\Models\Appointment;
use App\Services\AppointmentQueryService;
use App\Services\AppointmentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private AppointmentService $appointmentService,
        private AppointmentQueryService $appointmentQueryService
    ) {}

    public function getAvailableSlots(AvailableSlotsRequest $request)
    {
        $this->authorize('create', Appointment::class);

        $validated = $request->validated();

        $slots = $this->appointmentQueryService->getAvailableSlots(
            (int) $validated['doctor_id'],
            $validated['date']
        );

        return response()->json($slots);
    }

    public function create()
    {
        $this->authorize('create', Appointment::class);

        $doctors = $this->appointmentQueryService->getDoctorsForSelect();

        return view('appointments.create', compact('doctors'));
    }

    public function store(StoreAppointmentRequest $request)
    {
        $this->authorize('create', Appointment::class);

        $this->appointmentService->create(
            $request->validated(),
            Auth::id()
        );

        return redirect('/dashboard')->with('alert', 'Appointment booked successfully.');
    }

    public function updateStatus(UpdateAppointmentStatusRequest $request, Appointment $appointment)
    {
        $this->authorize('manage', $appointment);

        $error = $this->appointmentService->updateStatus(
            $appointment,
            $request->validated('status')
        );

        if ($error !== null) {
            return back()->with('error', $error);
        }

        return back()->with('alert', 'Status updated to ' . $request->validated('status'));
    }

    public function edit(Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $error = $this->appointmentService->editError($appointment);

        if ($error !== null) {
            return redirect('/dashboard')->with('error', $error);
        }

        $doctors = $this->appointmentQueryService->getDoctorsForSelect();

        return view('appointments.edit', compact('appointment', 'doctors'));
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $error = $this->appointmentService->update($appointment, $request->validated());

        if ($error !== null) {
            return redirect('/dashboard')->with('error', $error);
        }

        return redirect('/dashboard')->with('alert', 'Appointment updated!');
    }

    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);

        $error = $this->appointmentService->cancel($appointment);

        if ($error !== null) {
            return redirect('/dashboard')->with('error', $error);
        }

        return back()->with('alert', 'Appointment cancelled.');
    }

    public function consultation(Appointment $appointment)
    {
        $this->authorize('manage', $appointment);

        $error = $this->appointmentService->canAccessConsultation($appointment);

        if ($error !== null) {
            return redirect('/dashboard')->with('error', $error);
        }

        return view('doctor.consultation', compact('appointment'));
    }

    public function completeConsultation(CompleteConsultationRequest $request, Appointment $appointment)
    {
        $this->authorize('manage', $appointment);

        $error = $this->appointmentService->completeConsultation(
            $appointment,
            $request->validated()
        );

        if ($error !== null) {
            return redirect('/dashboard')->with('error', $error);
        }

        return redirect('/dashboard')->with('alert', 'Consultation finalized.');
    }

    public function showRecord(Appointment $appointment)
    {
        $this->authorize('view', $appointment);

        $error = $this->appointmentService->viewRecordError($appointment);

        if ($error !== null) {
            return redirect('/dashboard')->with('error', $error);
        }

        return view('appointments.record', compact('appointment'));
    }

    public function schedule(\Illuminate\Http\Request $request)
    {
        $doctor = Auth::user();
        if ($doctor->role !== 'doctor') {
            abort(403);
        }

        // Get selected month (default to current month: YYYY-MM)
        $monthStr = $request->query('month', \Carbon\Carbon::now('Asia/Kuala_Lumpur')->format('Y-m'));
        try {
            $currentMonth = \Carbon\Carbon::createFromFormat('Y-m', $monthStr, 'Asia/Kuala_Lumpur');
        } catch (\Exception $e) {
            $monthStr = \Carbon\Carbon::now('Asia/Kuala_Lumpur')->format('Y-m');
            $currentMonth = \Carbon\Carbon::createFromFormat('Y-m', $monthStr, 'Asia/Kuala_Lumpur');
        }

        // Selected date (default to today if in current month)
        $selectedDateStr = $request->query('date');
        if ($selectedDateStr) {
            try {
                $selectedDate = \Carbon\Carbon::createFromFormat('Y-m-d', $selectedDateStr, 'Asia/Kuala_Lumpur')->startOfDay();
            } catch (\Exception $e) {
                $selectedDate = null;
            }
        } else {
            $selectedDate = null;
        }

        // Build calendar grid days
        $startOfCalendar = $currentMonth->copy()->startOfMonth()->startOfWeek(\Carbon\Carbon::SUNDAY);
        $endOfCalendar = $currentMonth->copy()->endOfMonth()->endOfWeek(\Carbon\Carbon::SATURDAY);

        // Fetch all appointments for this doctor in this calendar range
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->whereBetween('appointment_time', [
                $startOfCalendar->copy()->startOfDay(),
                $endOfCalendar->copy()->endOfDay()
            ])
            ->with('patient')
            ->orderBy('appointment_time', 'asc')
            ->get();

        // Group appointments by date string
        $appointmentsByDate = $appointments->groupBy(function ($a) {
            return \Carbon\Carbon::parse($a->appointment_time, 'Asia/Kuala_Lumpur')->format('Y-m-d');
        });

        // Filtered appointments for display
        if ($selectedDate) {
            $filteredAppointments = $appointments->filter(function ($a) use ($selectedDate) {
                return \Carbon\Carbon::parse($a->appointment_time, 'Asia/Kuala_Lumpur')->isSameDay($selectedDate);
            });
        } else {
            // Show all appointments for the current month
            $filteredAppointments = $appointments->filter(function ($a) use ($currentMonth) {
                return \Carbon\Carbon::parse($a->appointment_time, 'Asia/Kuala_Lumpur')->format('Y-m') === $currentMonth->format('Y-m');
            });
        }

        // Generate list of days in grid
        $daysGrid = [];
        $currentDay = $startOfCalendar->copy();
        while ($currentDay->lte($endOfCalendar)) {
            $daysGrid[] = [
                'date' => $currentDay->copy(),
                'date_str' => $currentDay->format('Y-m-d'),
                'day_num' => $currentDay->format('j'),
                'is_current_month' => $currentDay->format('Y-m') === $currentMonth->format('Y-m'),
                'is_today' => $currentDay->isToday(),
                'appointments_count' => isset($appointmentsByDate[$currentDay->format('Y-m-d')]) ? count($appointmentsByDate[$currentDay->format('Y-m-d')]) : 0,
                'appointments' => isset($appointmentsByDate[$currentDay->format('Y-m-d')]) ? $appointmentsByDate[$currentDay->format('Y-m-d')] : collect(),
            ];
            $currentDay->addDay();
        }

        return view('doctor.schedule', [
            'daysGrid' => $daysGrid,
            'currentMonth' => $currentMonth,
            'prevMonthStr' => $currentMonth->copy()->subMonth()->format('Y-m'),
            'nextMonthStr' => $currentMonth->copy()->addMonth()->format('Y-m'),
            'selectedDate' => $selectedDate,
            'filteredAppointments' => $filteredAppointments,
        ]);
    }

    public function patients(\Illuminate\Http\Request $request)
    {
        $doctor = Auth::user();
        if ($doctor->role !== 'doctor') {
            abort(403);
        }

        return view('doctor.patients');
    }

    public function patientDetail(\Illuminate\Http\Request $request, \App\Models\User $patient)
    {
        $doctor = Auth::user();
        if ($doctor->role !== 'doctor') {
            abort(403);
        }

        // Ensure this patient actually has appointments with this doctor
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->where('patient_id', $patient->id)
            ->orderByDesc('appointment_time')
            ->paginate(5);

        if ($appointments->total() === 0) {
            abort(404);
        }

        return view('doctor.patient-detail', compact('patient', 'appointments'));
    }

    public function clinicalRecords(\Illuminate\Http\Request $request)
    {
        $doctor = Auth::user();
        if ($doctor->role !== 'doctor') {
            abort(403);
        }

        return view('doctor.clinical-records');
    }
}
