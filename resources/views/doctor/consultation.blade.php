<x-layout title="Clinical Consultation">
    <x-return to="dashboard"/>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-10 pb-24">

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

        @if ($errors->any())
            <div class="mb-8 p-5 bg-rose-50 border border-rose-100 rounded-3xl flex items-center text-rose-600 animate-pulse">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <p class="text-xs font-black uppercase tracking-widest">Incomplete record: Please check clinical fields below.</p>
            </div>
        @endif

        <form action="/consultation/{{ $appointment->id }}/complete" method="POST" class="space-y-8">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <label class="flex items-center text-xs font-black uppercase tracking-[0.2em] text-slate-400 ml-1">
                        <svg class="w-4 h-4 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Chief Complaints
                    </label>
                    <textarea name="symptoms" rows="5"
                        class="w-full rounded-3xl p-5 border-slate-200 bg-white shadow-sm focus:border-rose-500 focus:ring-4 focus:ring-rose-100 outline-none transition-all duration-200 text-slate-700 font-medium @error('symptoms') border-rose-500 @enderror"
                        placeholder="Detail the patient's reported symptoms...">{{ old('symptoms') }}</textarea>
                    @error('symptoms')
                        <p class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-1 ml-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-3">
                    <label class="flex items-center text-xs font-black uppercase tracking-[0.2em] text-slate-400 ml-1">
                        <svg class="w-4 h-4 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Clinical Diagnosis
                    </label>
                    <textarea name="diagnosis" rows="5"
                        class="w-full rounded-3xl p-5 border-slate-200 bg-white shadow-sm focus:border-rose-500 focus:ring-4 focus:ring-rose-100 outline-none transition-all duration-200 text-slate-700 font-medium @error('diagnosis') border-rose-500 @enderror"
                        placeholder="Final clinical findings and assessment...">{{ old('diagnosis') }}</textarea>
                    @error('diagnosis')
                        <p class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-1 ml-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-3">
                <label class="flex items-center text-xs font-black uppercase tracking-[0.2em] text-slate-400 ml-1">
                    <svg class="w-4 h-4 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    Treatment Plan / Prescription
                </label>
                <textarea name="prescription" rows="4"
                    class="w-full rounded-3xl p-5 border-slate-200 bg-white shadow-sm focus:border-rose-500 focus:ring-4 focus:ring-rose-100 outline-none transition-all duration-200 text-slate-700 font-medium @error('prescription') border-rose-500 @enderror"
                    placeholder="Medication, dosage instructions, and follow-up plan...">{{ old('prescription') }}</textarea>
                @error('prescription')
                    <p class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-1 ml-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-6">
                <button type="submit"
                    class="w-full bg-slate-900 text-white py-5 rounded-[2rem] font-black text-sm uppercase tracking-[0.3em] shadow-2xl shadow-slate-200 hover:bg-rose-600 hover:-translate-y-1 active:scale-95 transition-all duration-300">
                    Finalize & Archive Record
                </button>
                <p class="text-center text-[10px] text-slate-400 mt-4 font-bold uppercase tracking-widest">
                    This action will permanently close the consultation record
                </p>
            </div>
        </form>
    </div>
</x-layout>
