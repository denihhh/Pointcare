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
}
