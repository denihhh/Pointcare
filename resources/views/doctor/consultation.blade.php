<x-layout title="Clinical Consultation">
    <x-return to="dashboard"/>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-10 pb-24">

        <x-layout.consultation-header :appointment="$appointment" />

        @if ($errors->any())
            <div class="mb-8 p-5 bg-rose-50 border border-rose-100 rounded-3xl flex items-center text-rose-600 animate-shake">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <p class="text-xs font-black uppercase tracking-widest">Incomplete record: Please check clinical fields below.</p>
            </div>
        @endif
        

        <form action="/consultation/{{ $appointment->id }}/complete" method="POST" class="space-y-8">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <x-form.consultation-form
                    name="symptoms"
                    label="Chief Complaints"
                    placeholder="Detail the patient's reported symptoms..."
                    icon='<path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'
                />

                <x-form.consultation-form
                    name="diagnosis"
                    label="Clinical Diagnosis"
                    placeholder="Final clinical findings and assessment..."
                    icon='<path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>'
                />
            </div>

            <x-form.consultation-form
                name="prescription"
                label="Treatment Plan / Prescription"
                rows="4"
                placeholder="Medication, dosage instructions, and follow-up plan..."
                icon='<path d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>'
            />

            <div class="pt-6">
                <button type="submit" class="w-full bg-slate-900 text-white py-5 rounded-[2rem] font-black text-sm uppercase tracking-[0.3em] shadow-2xl shadow-slate-200 hover:bg-rose-600 hover:-translate-y-1 active:scale-95 transition-all duration-300">
                    Finalize & Archive Record
                </button>
                <p class="text-center text-[10px] text-slate-400 mt-4 font-bold uppercase tracking-widest">
                    This action will permanently close the consultation record
                </p>
            </div>
        </form>
    </div>
</x-layout>
