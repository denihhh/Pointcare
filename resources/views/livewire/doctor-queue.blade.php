<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div wire:poll.2s> <!-- This magic attribute refreshes the data every 30s -->
    <div class="mb-8 px-2 flex items-center justify-between">
        <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">Live Patient List</h3>
        <div class="flex items-center text-xs text-emerald-600 font-bold bg-emerald-50 px-3 py-1.5 rounded-lg">
            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
            System Sync Active
        </div>
    </div>

    @if ($appointments->isEmpty())
        <div class="py-20 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-slate-50 rounded-full mb-4">
                <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Your queue is empty</h3>
            <p class="text-slate-400 text-sm">No patients have booked appointments with you yet.</p>
        </div>
    @else
        <!-- We call your existing table component here -->
        <x-table :appointments="$appointments" role="doctor" />
    @endif
    {{ $appointments->links('livewire::tailwind', data: ['scrollTo' => '#appointments-scroll-target']) }}
    {{-- untuk pagination --}}
</div>