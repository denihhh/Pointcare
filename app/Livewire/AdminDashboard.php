<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class AdminDashboard extends Component
{
    use WithPagination;

    // Navigation and tabs
    public string $activeTab = 'overview'; // overview, users, appointments

    // User management state
    public string $search = '';
    public string $roleFilter = 'all';

    // Edit user form properties
    public ?User $selectedUser = null;
    public bool $isEditingUser = false;
    public string $editRole = '';
    public string $specialization = '';
    public string $license_number = '';
    public float $consultation_fee = 0.0;
    public string $bio = '';

    // Create user form properties
    public bool $isCreatingUser = false;
    public string $newName = '';
    public string $newEmail = '';
    public string $newPhone = '';
    public string $newPassword = '';
    public string $newRole = 'patient';
    public string $newSpecialization = '';
    public string $newLicense = '';
    public float $newFee = 0.0;
    public string $newBio = '';

    // Deletion state
    public ?int $confirmingDeleteUserId = null;

    // Appointment management state
    public string $appointmentFilter = 'all';
    public string $appointmentSearch = '';

    // Reset pagination when searching or filtering
    public function updatingSearch(): void
    {
        $this->resetPage('usersPage');
    }

    public function updatingRoleFilter(): void
    {
        $this->resetPage('usersPage');
    }

    public function updatingAppointmentFilter(): void
    {
        $this->resetPage('appointmentsPage');
    }

    public function updatingAppointmentSearch(): void
    {
        $this->resetPage('appointmentsPage');
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->cancelEdit();
        $this->cancelCreateUser();
        $this->cancelDelete();
    }

    // --- Edit User Role & Doctor profile ---
    public function editUser(int $userId): void
    {
        $this->cancelCreateUser();
        $this->selectedUser = User::with('doctor')->findOrFail($userId);
        $this->editRole = $this->selectedUser->role;
        $this->isEditingUser = true;

        if ($this->selectedUser->doctor) {
            $this->specialization = $this->selectedUser->doctor->specialization;
            $this->license_number = $this->selectedUser->doctor->license_number;
            $this->consultation_fee = (float) $this->selectedUser->doctor->consultation_fee;
            $this->bio = $this->selectedUser->doctor->bio ?? '';
        } else {
            $this->specialization = '';
            $this->license_number = '';
            $this->consultation_fee = 0.0;
            $this->bio = '';
        }
    }

    public function saveUserRole(): void
    {
        if (!$this->selectedUser) {
            return;
        }

        $rules = [
            'editRole' => ['required', 'in:patient,doctor,admin'],
        ];

        if ($this->editRole === 'doctor') {
            $rules['specialization'] = ['required', 'string', 'max:255'];
            $rules['license_number'] = [
                'required',
                'string',
                'max:100',
                Rule::unique('doctors', 'license_number')->ignore($this->selectedUser->doctor?->id),
            ];
            $rules['consultation_fee'] = ['required', 'numeric', 'min:0'];
            $rules['bio'] = ['nullable', 'string', 'max:3000'];
        }

        $this->validate($rules);

        // Update role
        $this->selectedUser->role = $this->editRole;
        $this->selectedUser->save();

        if ($this->editRole === 'doctor') {
            // Update or create Doctor credentials
            $this->selectedUser->doctor()->updateOrCreate(
                ['user_id' => $this->selectedUser->id],
                [
                    'specialization' => $this->specialization,
                    'license_number' => $this->license_number,
                    'consultation_fee' => $this->consultation_fee,
                    'bio' => $this->bio ?: null,
                ]
            );
        } else {
            // If they are no longer a doctor, purge their doctor record to clean up constraints
            if ($this->selectedUser->doctor) {
                $this->selectedUser->doctor->delete();
            }
        }

        session()->flash('success', "User '{$this->selectedUser->name}' updated successfully.");
        $this->cancelEdit();
    }

    public function cancelEdit(): void
    {
        $this->selectedUser = null;
        $this->isEditingUser = false;
        $this->editRole = '';
        $this->specialization = '';
        $this->license_number = '';
        $this->consultation_fee = 0.0;
        $this->bio = '';
    }

    // --- Create User ---
    public function startCreateUser(): void
    {
        $this->cancelEdit();
        $this->isCreatingUser = true;
    }

    public function createUser(): void
    {
        $rules = [
            'newName' => ['required', 'string', 'max:255'],
            'newEmail' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'newPhone' => ['nullable', 'string', 'max:20'],
            'newPassword' => ['required', 'string', 'min:8'],
            'newRole' => ['required', 'in:patient,doctor,admin'],
        ];

        if ($this->newRole === 'doctor') {
            $rules['newSpecialization'] = ['required', 'string', 'max:255'];
            $rules['newLicense'] = ['required', 'string', 'max:100', Rule::unique('doctors', 'license_number')];
            $rules['newFee'] = ['required', 'numeric', 'min:0'];
            $rules['newBio'] = ['nullable', 'string', 'max:3000'];
        }

        $this->validate($rules);

        // Create User
        $user = User::create([
            'name' => $this->newName,
            'email' => $this->newEmail,
            'phone' => $this->newPhone ?: null,
            'password' => Hash::make($this->newPassword),
            'role' => $this->newRole,
        ]);

        if ($this->newRole === 'doctor') {
            // Create Doctor profile
            Doctor::create([
                'user_id' => $user->id,
                'specialization' => $this->newSpecialization,
                'license_number' => $this->newLicense,
                'consultation_fee' => $this->newFee,
                'bio' => $this->newBio ?: null,
            ]);
        }

        session()->flash('success', "User '{$user->name}' created successfully.");
        $this->cancelCreateUser();
    }

    public function cancelCreateUser(): void
    {
        $this->isCreatingUser = false;
        $this->newName = '';
        $this->newEmail = '';
        $this->newPhone = '';
        $this->newPassword = '';
        $this->newRole = 'patient';
        $this->newSpecialization = '';
        $this->newLicense = '';
        $this->newFee = 0.0;
        $this->newBio = '';
    }

    // --- Delete User ---
    public function confirmDelete(int $userId): void
    {
        // Don't delete oneself
        if ($userId === auth()->id()) {
            session()->flash('error', "You cannot delete your own administrative account.");
            return;
        }

        $this->confirmingDeleteUserId = $userId;
    }

    public function deleteUser(): void
    {
        if (!$this->confirmingDeleteUserId || $this->confirmingDeleteUserId === auth()->id()) {
            return;
        }

        $user = User::findOrFail($this->confirmingDeleteUserId);
        $name = $user->name;
        $user->delete(); // Cascades deletes to appointments & doctor table via migration triggers

        session()->flash('success', "User '{$name}' deleted successfully.");
        $this->cancelDelete();
    }

    public function cancelDelete(): void
    {
        $this->confirmingDeleteUserId = null;
    }

    // --- Appointment Management ---
    public function confirmAppointment(int $appointmentId): void
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->status = 'confirmed';
        $appointment->save();

        session()->flash('success', 'Appointment confirmed successfully.');
    }

    public function cancelAppointment(int $appointmentId): void
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->status = 'cancelled';
        $appointment->save();

        session()->flash('success', 'Appointment cancelled successfully.');
    }

    public function completeAppointment(int $appointmentId): void
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->status = 'completed';
        $appointment->save();

        session()->flash('success', 'Appointment marked as completed.');
    }

    public function deleteAppointment(int $appointmentId): void
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->delete();

        session()->flash('success', 'Appointment record deleted successfully.');
    }

    public function render()
    {
        // System wide metrics
        $totalUsers = User::count();
        $totalPatients = User::where('role', 'patient')->count();
        $totalDoctors = User::where('role', 'doctor')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        $totalAppointments = Appointment::count();
        $pendingAppointmentsCount = Appointment::where('status', 'pending')->count();
        $confirmedAppointmentsCount = Appointment::where('status', 'confirmed')->count();
        $completedAppointmentsCount = Appointment::where('status', 'completed')->count();
        $cancelledAppointmentsCount = Appointment::where('status', 'cancelled')->count();
        $todayAppointmentsCount = Appointment::whereDate('appointment_time', today())->count();

        // User list with query filters
        $usersQuery = User::with('doctor')
            ->when($this->roleFilter !== 'all', function ($query) {
                return $query->where('role', $this->roleFilter);
            })
            ->when($this->search !== '', function ($query) {
                return $query->where(function ($sub) {
                    $sub->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            });

        $users = $usersQuery->orderBy('name', 'asc')->paginate(10, ['*'], 'usersPage');

        // Appointment list with query filters
        $appointmentsQuery = Appointment::with(['patient', 'doctor'])
            ->when($this->appointmentFilter !== 'all', function ($query) {
                return $query->where('status', $this->appointmentFilter);
            })
            ->when($this->appointmentSearch !== '', function ($query) {
                return $query->where(function ($sub) {
                    $sub->whereHas('patient', function ($q) {
                        $q->where('name', 'like', '%' . $this->appointmentSearch . '%');
                    })->orWhereHas('doctor', function ($q) {
                        $q->where('name', 'like', '%' . $this->appointmentSearch . '%');
                    })->orWhere('reason', 'like', '%' . $this->appointmentSearch . '%');
                });
            });

        $appointments = $appointmentsQuery->orderBy('appointment_time', 'desc')->paginate(10, ['*'], 'appointmentsPage');

        $recentActivities = Appointment::with(['patient', 'doctor'])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin-dashboard', [
            'totalUsers' => $totalUsers,
            'totalPatients' => $totalPatients,
            'totalDoctors' => $totalDoctors,
            'totalAdmins' => $totalAdmins,
            'totalAppointments' => $totalAppointments,
            'pendingAppointmentsCount' => $pendingAppointmentsCount,
            'confirmedAppointmentsCount' => $confirmedAppointmentsCount,
            'completedAppointmentsCount' => $completedAppointmentsCount,
            'cancelledAppointmentsCount' => $cancelledAppointmentsCount,
            'todayAppointmentsCount' => $todayAppointmentsCount,
            'users' => $users,
            'appointments' => $appointments,
            'recentActivities' => $recentActivities,
        ])->layout('components.layout.layout', ['title' => 'Admin Dashboard']);
    }
}
