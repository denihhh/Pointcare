<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div wire:poll.2s >
    
    <div class="mb-8 flex items-center justify-between">
        <h2 class="text-xl font-bold text-slate-800">Your Appointments</h2>
        <a href="/appointments/create" data-test="new-appointment-btn"
            class="hidden sm:flex items-center bg-rose-600 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-rose-500 transition-all active:scale-95 shadow-lg shadow-slate-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
            </svg>
            New Appointment
        </a>
    </div>


    @if ($appointments->isEmpty())
        <div class="bg-white p-8 rounded-3xl border border-dashed border-slate-200 text-center">
            <p class="text-slate-500">No appointments found. Start by booking one above!</p>
        </div>
    @else
        <x-table :appointments="$appointments" role="patient" />
    @endif
    {{ $appointments->links('livewire::tailwind', data: ['scrollTo' => '#appointments-table']) }}
    {{-- untuk pagination --}}
</div>
