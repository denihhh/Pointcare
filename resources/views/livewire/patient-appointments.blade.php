<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div wire:poll.2s>

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

    <!-- Status Tabs Filter Bar -->
    <div class="mb-6 border-b border-slate-100 flex items-center justify-between overflow-x-auto scrollbar-none">
        <div class="flex space-x-8 -mb-px">
            <button wire:click="setFilter('all')"
                class="pb-4 text-xs font-black uppercase tracking-widest transition-all duration-200 border-b-2 focus:outline-none whitespace-nowrap {{ $statusFilter === 'all' ? 'text-rose-600 border-rose-500' : 'text-slate-400 border-transparent hover:text-slate-600' }}">
                All Sessions <span class="ml-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusFilter === 'all' ? 'bg-rose-50 text-rose-600' : 'bg-slate-50 text-slate-400' }}">{{ $allCount }}</span>
            </button>
            <button wire:click="setFilter('upcoming')"
                class="pb-4 text-xs font-black uppercase tracking-widest transition-all duration-200 border-b-2 focus:outline-none whitespace-nowrap {{ $statusFilter === 'upcoming' ? 'text-rose-600 border-rose-500' : 'text-slate-400 border-transparent hover:text-slate-600' }}">
                Upcoming <span class="ml-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusFilter === 'upcoming' ? 'bg-rose-50 text-rose-600' : 'bg-slate-50 text-slate-400' }}">{{ $upcomingCount }}</span>
            </button>
            <button wire:click="setFilter('completed')"
                class="pb-4 text-xs font-black uppercase tracking-widest transition-all duration-200 border-b-2 focus:outline-none whitespace-nowrap {{ $statusFilter === 'completed' ? 'text-rose-600 border-rose-500' : 'text-slate-400 border-transparent hover:text-slate-600' }}">
                Completed / Past Records <span class="ml-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusFilter === 'completed' ? 'bg-rose-50 text-rose-600' : 'bg-slate-50 text-slate-400' }}">{{ $completedCount }}</span>
            </button>
            <button wire:click="setFilter('cancelled')"
                class="pb-4 text-xs font-black uppercase tracking-widest transition-all duration-200 border-b-2 focus:outline-none whitespace-nowrap {{ $statusFilter === 'cancelled' ? 'text-rose-600 border-rose-500' : 'text-slate-400 border-transparent hover:text-slate-600' }}">
                Cancelled <span class="ml-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusFilter === 'cancelled' ? 'bg-rose-50 text-rose-600' : 'bg-slate-50 text-slate-400' }}">{{ $cancelledCount }}</span>
            </button>
        </div>
    </div>

    @if ($appointments->isEmpty())
        <div class="bg-white p-8 rounded-3xl border border-dashed border-slate-200 text-center py-12">
            @if($statusFilter === 'upcoming')
                <p class="text-slate-500">No upcoming appointments scheduled.</p>
            @elseif($statusFilter === 'completed')
                <p class="text-slate-500">No completed or past appointments found.</p>
            @elseif($statusFilter === 'cancelled')
                <p class="text-slate-500">No cancelled appointments found.</p>
            @else
                <p class="text-slate-500">No appointments found. Start by booking one above!</p>
            @endif
        </div>
    @else
        <x-table :appointments="$appointments" role="patient" />
    @endif
    {{ $appointments->links('livewire::tailwind', data: ['scrollTo' => '#appointments-scroll-target']) }}
    {{-- untuk pagination --}}
</div>