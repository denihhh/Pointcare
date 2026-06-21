<?php

namespace App\Livewire;

use App\Livewire\Concerns\GuardsInvalidPagination;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DoctorClinicalRecords extends Component
{
    use GuardsInvalidPagination;
    use WithPagination;

    public string $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $doctor = Auth::user();
        $perPage = 10;

        $query = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'completed')
            ->with('patient')
            ->orderByDesc('appointment_time');

        // Patient name search
        if ($this->search) {
            $query->whereHas('patient', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        $records = $this->ensureValidPage(
            $query->paginate($perPage, ['*'], 'page', $this->getPage()),
            fn () => $query->paginate($perPage, ['*'], 'page', 1)
        );

        return view('livewire.doctor-clinical-records', [
            'records' => $records,
        ]);
    }
}
