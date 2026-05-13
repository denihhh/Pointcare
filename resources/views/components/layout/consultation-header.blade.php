@props(['appointment'])

<div class="bg-white rounded-[2.5rem] p-8 sm:p-10 shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-slate-100 mb-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="flex items-center">
            <div class="w-16 h-16 rounded-2xl bg-rose-500 text-white flex items-center justify-center font-black text-2xl shadow-lg shadow-rose-200 mr-5">
                {{ substr($appointment->patient->name, 0, 1) }}
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Consultation Session</h1>
                <p class="text-slate-500 font-medium">Patient: <span class="text-slate-900 font-bold">{{ $appointment->patient->name }}</span></p>
            </div>
        </div>

        <div class="flex flex-col md:items-end">
            <span class="bg-slate-100 text-slate-600 px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border border-slate-200">
                Ref: #{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}
            </span>
            <span class="mt-2 text-slate-400 text-xs font-bold">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('l, d M Y') }}</span>
        </div>
    </div>

    <div class="mt-8 pt-8 border-t border-slate-50 flex items-center text-slate-400 text-xs italic">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Original reason for visit: "{{ $appointment->reason }}"
    </div>
</div>
