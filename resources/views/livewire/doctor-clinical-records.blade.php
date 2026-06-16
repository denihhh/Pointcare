<div>
    {{-- Tab Navigation --}}
    <div class="flex flex-wrap items-center gap-2 mb-6 border-b border-slate-100 pb-4">
        <button wire:click="$set('tab', 'all')"
            class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-200
                {{ $tab === 'all' ? 'bg-rose-50 text-rose-600 shadow-sm' : 'text-slate-400 hover:text-slate-600 hover:bg-slate-50' }}">
            All Notes
        </button>
        <button wire:click="$set('tab', 'diagnoses')"
            class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-200
                {{ $tab === 'diagnoses' ? 'bg-rose-50 text-rose-600 shadow-sm' : 'text-slate-400 hover:text-slate-600 hover:bg-slate-50' }}">
            Diagnoses
        </button>
        <button wire:click="$set('tab', 'prescriptions')"
            class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-200
                {{ $tab === 'prescriptions' ? 'bg-rose-50 text-rose-600 shadow-sm' : 'text-slate-400 hover:text-slate-600 hover:bg-slate-50' }}">
            Prescriptions
        </button>
    </div>

    {{-- Search & Filter Row --}}
    <div class="mb-6 flex flex-col sm:flex-row gap-3">
        <div class="flex-1">
            <x-doctor.clinical-search />
        </div>
        @if($tab === 'all')
            <select wire:model.live="statusFilter"
                class="px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50/50 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-rose-200 focus:border-rose-300 transition sm:w-48">
                <option value="">All Statuses</option>
                <option value="completed">Completed</option>
                <option value="approved">Approved</option>
                <option value="pending">Pending</option>
                <option value="cancelled">Cancelled</option>
                <option value="rejected">Rejected</option>
            </select>
        @endif
    </div>

    {{-- Content --}}
    @if ($records->isEmpty())
        <x-doctor.clinical-empty-state
            icon-path="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"
            title="No records found"
            subtitle="Clinical records matching your filters will appear here." />
    @else
        <div class="space-y-4">
            @foreach ($records as $record)
                <x-doctor.appointment-card :appointment="$record" />
            @endforeach
        </div>

        {{-- Pagination --}}
        {{ $records->links('livewire::tailwind') }}
    @endif
</div>
