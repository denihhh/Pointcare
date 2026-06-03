@inject('appointmentService', App\Services\AppointmentService::class)

<x-layout title="Medical Record">
    <x-return to="dashboard" />

    <div class="max-w-3xl mx-auto px-6 py-12">
        <div class="border-b-4 border-slate-900 pb-6 mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Medical Record</h1>
                <p class="text-slate-400 font-bold text-xs mt-1">Ref ID: #{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="text-right">
                <p class="font-black text-slate-700">IIUM Smart Clinic</p>
                <p class="text-xs text-slate-400">Electronic Health Record System</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8 mb-12 bg-slate-50 p-6 rounded-3xl border border-slate-100">
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Patient</label>
                <p class="font-bold text-slate-800">{{ $appointment->patient->name }}</p>
            </div>
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Attending Doctor</label>
                <p class="font-bold text-slate-800">Dr. {{ $appointment->doctor->name }}</p>
            </div>
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Consultation Date</label>
                <p class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('d F Y') }}</p>
            </div>
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</label>
                <span class="inline-block px-2 py-0.5 {{ $appointmentService->isCompleted($appointment) ? 'bg-emerald-500' : 'bg-amber-500' }} text-white text-[9px] font-black rounded uppercase">
                    {{ ucfirst($appointment->status) }}
                </span>
            </div>
        </div>

        <div class="space-y-10">
            <section>
                <h2 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-3 flex items-center">
                    <span class="w-2 h-2 bg-rose-500 rounded-full mr-2"></span> Patient's Complaints
                </h2>
                <p class="text-slate-600 leading-relaxed pl-4 border-l-2 border-rose-300">{{ $appointment->symptoms }}</p>
            </section>

            <section>
                <h2 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-3 flex items-center">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span> Clinical Diagnosis
                </h2>
                <p class="text-slate-600 leading-relaxed pl-4 border-l-2 border-blue-300">{{ $appointment->diagnosis }}</p>
            </section>

            <section class="bg-rose-50 p-6 rounded-2xl border border-rose-100">
                <h2 class="text-sm font-black text-rose-600 uppercase tracking-widest mb-3">Prescription & Plan</h2>
                <p class="text-rose-900 font-bold leading-relaxed">{{ $appointment->prescription }}</p>
            </section>
        </div>

        <div class="mt-20 pt-6 border-t border-slate-900 text-center">
            <p class="text-slate-500 text-[10px] font-medium italic">This is a computer-generated document from the Smart Clinic EHR. No signature required.</p>
        </div>
    </div>
</x-layout>
