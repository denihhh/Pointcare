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
    public string $tab = 'all';
    public string $statusFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTab()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $doctor = Auth::user();
        $perPage = 10;

        $query = Appointment::where('doctor_id', $doctor->id)
            ->with('patient')
            ->orderByDesc('appointment_time');

        // Apply tab-specific filters
        match ($this->tab) {
            'diagnoses' => $query->where('status', 'completed')->whereNotNull('diagnosis'),
            'prescriptions' => $query->where('status', 'completed')
                ->whereNotNull('prescription')
                ->where('prescription', '!=', ''),
            default => $query->where(function ($q) {
                $q->where(function ($q2) {
                    $q2->whereNotNull('reason')->where('reason', '!=', '');
                })->orWhere(function ($q2) {
                    $q2->whereNotNull('symptoms')->where('symptoms', '!=', '');
                })->orWhere(function ($q2) {
                    $q2->whereNotNull('diagnosis')->where('diagnosis', '!=', '');
                });
            }),
        };

        // Status filter (only applicable on "all" tab)
        if ($this->tab === 'all' && $this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

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
