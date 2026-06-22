@props(['appointment', 'showStatus' => true])

<div class="border border-slate-100 rounded-2xl p-6 hover:bg-slate-50/50 transition duration-200">
    {{-- Header: Patient + Date + Status --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
        <div class="flex items-center space-x-3">
            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-rose-100 to-rose-200 flex items-center justify-center text-rose-600 font-black text-sm border border-white shadow-sm">
                {{ substr($appointment->patient->name, 0, 1) }}
            </div>
            <div>
                <p class="text-sm font-bold text-slate-800">{{ $appointment->patient->name }}</p>
                <p class="text-xs text-slate-400 font-medium">
                    {{ $appointment->appointment_time->format('l, d M Y · h:i A') }}
                </p>
            </div>
        </div>
        @if($showStatus)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest w-fit
                @if($appointment->status === 'completed') bg-emerald-50 text-emerald-600
                @elseif($appointment->status === 'approved') bg-blue-50 text-blue-600
                @elseif($appointment->status === 'pending') bg-amber-50 text-amber-600
                @elseif($appointment->status === 'cancelled' || $appointment->status === 'rejected') bg-red-50 text-red-500
                @else bg-slate-50 text-slate-500
                @endif">
                {{ ucfirst($appointment->status) }}
            </span>
        @endif
    </div>

    {{-- Clinical Fields --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @if($appointment->reason)
            <div>
                <p class="text-[10px] uppercase tracking-[0.15em] text-slate-400 font-black mb-1">Reason for Visit</p>
                <p class="text-sm text-slate-600 font-medium">{{ $appointment->reason }}</p>
            </div>
        @endif

        @if($appointment->symptoms)
            <div>
                <p class="text-[10px] uppercase tracking-[0.15em] text-slate-400 font-black mb-1">Symptoms</p>
                <p class="text-sm text-slate-600 font-medium">{{ $appointment->symptoms }}</p>
            </div>
        @endif

        @if($appointment->diagnosis)
            <div>
                <p class="text-[10px] uppercase tracking-[0.15em] text-slate-400 font-black mb-1">Diagnosis</p>
                <p class="text-sm text-slate-700 font-semibold">{{ $appointment->diagnosis }}</p>
            </div>
        @endif

        @if($appointment->prescription)
            <div>
                <p class="text-[10px] uppercase tracking-[0.15em] text-slate-400 font-black mb-1">Prescription</p>
                <p class="text-sm text-slate-700 font-semibold">{{ $appointment->prescription }}</p>
            </div>
        @endif
    </div>

    {{-- Action Links --}}
    @if($appointment->status === 'completed')
        <div class="mt-4 pt-3 border-t border-slate-100">
            <a href="{{ route('appointments.record', $appointment) }}"
               class="inline-flex items-center text-xs font-bold text-rose-500 hover:text-rose-700 transition">
                View Full Record
                <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    @elseif($appointment->status === 'approved')
        <div class="mt-4 pt-3 border-t border-slate-100">
            <a href="{{ route('consultation', $appointment) }}"
               class="inline-flex items-center text-xs font-bold text-blue-500 hover:text-blue-700 transition">
                Start Consultation
                <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    @endif
</div>
