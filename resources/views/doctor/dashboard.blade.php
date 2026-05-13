<x-layout title="Doctor Dashboard">
    <x-return />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">

        <div class="mt-8 mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <span
                        class="bg-rose-100 text-rose-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">
                        Staff Portal
                    </span>
                    <span class="text-slate-400 text-xs font-medium">{{ now()->format('l, d F Y') }}</span>
                </div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Clinical Queue</h1>
                <p class="text-slate-500 font-medium mt-1">Review and manage your daily patient consultations.</p>
            </div>

            <div class="flex gap-4">
                <div class="bg-white border border-slate-100 p-4 rounded-2xl shadow-sm min-w-[140px]">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Upcoming Active</p>
                    <p class="text-2xl font-black text-slate-900">
                        {{ $appointments->filter(fn($a) => in_array($a->status, ['pending', 'confirmed']) && $a->appointment_time >= now())->count() }}
                    </p>
                </div>

                <div class="bg-rose-50 border border-rose-100 p-4 rounded-2xl shadow-sm min-w-[140px]">
                    <p class="text-[10px] font-black text-rose-400 uppercase tracking-widest mb-1">New Requests</p>
                    <p class="text-2xl font-black text-rose-600">
                        {{ $appointments->where('status', 'pending')->where('appointment_time', '>=', now())->count() }}
                    </p>
                </div>
            </div>
        </div>

        <div
            class="bg-white shadow-[0_20px_50px_rgba(0,0,0,0.03)] rounded-[2.5rem] border border-slate-100 overflow-hidden">
            <div class="p-6 sm:p-10">

                @livewire('doctor-queue')
            </div>
        </div>

        <div class="mt-8 p-6 bg-slate-900 rounded-3xl flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-rose-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-slate-400 text-xs font-medium max-w-md">
                    <strong class="text-white">Quick Tip:</strong> Confirming an appointment sends an automated
                    notification to the patient. Please review the 'Reason' carefully before accepting.
                </p>
            </div>
        </div>
    </div>
</x-layout>
