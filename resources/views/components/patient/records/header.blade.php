@props([
    'title' => 'Health Ledger',
    'subtitle' => 'Verify and audit your completed historical clinical consultations.'
])

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-slate-100 pb-5">
    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">{{ $title }}</h1>
        <p class="text-sm text-slate-500 font-medium">{{ $subtitle }}</p>
    </div>

    {{-- Search/Filter bar layout --}}
    <div class="flex items-center gap-3 w-full md:w-auto">
        <div class="relative flex-1 md:w-64">
            <input type="text" x-model="search" placeholder="Search by doctor or diagnosis..."
                class="w-full text-xs font-semibold pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-rose-500/10 focus:border-primary transition bg-white">
            <svg class="absolute left-3 top-3 h-4 w-4 text-slate-400" fill="none" stroke="currentColor"
                stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>
</div>
