<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<div wire:poll.2s> <!-- This magic attribute refreshes the data every 30s -->
    <div class="mb-8 flex items-center justify-between">
        <h2 class="text-xl font-bold text-slate-800">Clinical Queue</h2>
        
        <div class="flex items-center text-xs text-emerald-600 font-bold bg-emerald-50 px-3 py-1.5 rounded-lg">
            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
            System Sync Active
        </div>
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
                <p class="text-slate-500">No upcoming consultations scheduled.</p>
            @elseif($statusFilter === 'completed')
                <p class="text-slate-500">No completed or past consultations found.</p>
            @elseif($statusFilter === 'cancelled')
                <p class="text-slate-500">No cancelled consultations found.</p>
            @else
                <p class="text-slate-500">No consultations found in your queue.</p>
            @endif
        </div>
    @else
        <!-- We call your existing table component here -->
        <x-table :appointments="$appointments" role="doctor" />
    @endif
    {{ $appointments->links('livewire::tailwind', data: ['scrollTo' => '#appointments-scroll-target']) }}
    {{-- untuk pagination --}}
</div>