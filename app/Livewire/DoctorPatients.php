<?php

namespace App\Livewire;

use App\Livewire\Concerns\GuardsInvalidPagination;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DoctorPatients extends Component
{
    use GuardsInvalidPagination;
    use WithPagination;

    public function render()
    {
        $doctor = Auth::user();
        $perPage = 5;

        $patients = $this->ensureValidPage(
            User::where('role', 'patient')
                ->whereHas('appointments', function ($query) use ($doctor) {
                    $query->where('doctor_id', $doctor->id);
                })
                ->withCount(['appointments' => function ($query) use ($doctor) {
                    $query->where('doctor_id', $doctor->id);
                }])
                ->paginate($perPage, ['*'], 'page', $this->getPage()),
            fn () => User::where('role', 'patient')
                ->whereHas('appointments', function ($query) use ($doctor) {
                    $query->where('doctor_id', $doctor->id);
                })
                ->withCount(['appointments' => function ($query) use ($doctor) {
                    $query->where('doctor_id', $doctor->id);
                }])
                ->paginate($perPage, ['*'], 'page', 1)
        );

        return view('livewire.doctor-patients', [
            'patients' => $patients,
        ]);
    }
}
