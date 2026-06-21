@props([
    'title' => 'Health Ledger',
    'subtitle' => 'Verify and audit your completed historical clinical consultations.'
])

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mt-8 mb-10 gap-y-4">
    <div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">{{ $title }}</h1>
        <p class="text-slate-500 font-medium mt-1">{{ $subtitle }}</p>
    </div>

    {{-- Search/Filter bar layout --}}
    <div class="flex items-center gap-3 w-full sm:w-auto">
        <div class="relative flex-1 sm:w-80">
            <input type="text" x-model="search" placeholder="Search by doctor or diagnosis..."
                class="w-full text-sm font-semibold pl-10 pr-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:ring-4 focus:ring-rose-100 focus:border-rose-500 transition bg-white shadow-xs">
            <svg class="absolute left-3.5 top-3.5 h-4.5 w-4.5 text-slate-400" fill="none" stroke="currentColor"
                stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>
</div>
