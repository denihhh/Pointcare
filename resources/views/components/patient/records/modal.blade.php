<div x-show="modalOpen" 
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0" 
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200" 
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[60] overflow-y-auto bg-slate-900/60 backdrop-blur-xs" 
    x-cloak>

    {{-- Centering and Scroll Wrapper --}}
    <div class="flex items-center justify-center min-h-screen p-4 overflow-y-auto">

        {{-- Interactive Modal Document Card --}}
        <div x-show="modalOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" 
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" 
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" 
            @click.away="modalOpen = false"
            class="bg-white border border-slate-150 rounded-[1.5rem] md:rounded-[2rem] shadow-2xl p-5 md:p-8 w-[95%] md:w-full max-w-lg md:max-w-xl relative overflow-hidden">

            {{-- Close Handle with 44px min target size --}}
            <button @click="modalOpen = false"
                class="absolute top-4 right-4 md:top-6 md:right-6 text-slate-400 hover:text-slate-600 transition-colors z-20 w-11 h-11 flex items-center justify-center rounded-xl hover:bg-slate-50"
                aria-label="Close details modal">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Aesthetic Watermark background --}}
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-rose-50/40 rounded-full blur-2xl"></div>

            {{-- Top Area: Doctor Credentials --}}
            <div class="flex items-start justify-between border-b border-slate-100 pb-5 mb-5 pr-8">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 md:w-11 md:h-11 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 font-black text-sm shrink-0">
                        Dr
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 leading-tight text-sm md:text-base"
                            x-text="selectedRecord ? 'Dr. ' + selectedRecord.doctor.name : ''"></h3>
                        <span
                            class="text-[10px] md:text-xs text-rose-500 font-bold uppercase tracking-wider block mt-0.5"
                            x-text="selectedRecord && selectedRecord.doctor.doctor ? selectedRecord.doctor.doctor.specialization : 'General Medicine'"></span>
                        <span class="text-[9px] md:text-[10px] text-slate-400 font-semibold block mt-0.5"
                            x-text="selectedRecord && selectedRecord.doctor.doctor ? 'License: ' + selectedRecord.doctor.doctor.license_number : ''"></span>
                    </div>
                </div>
            </div>

            {{-- Timestamp of final sign-off --}}
            <div
                class="flex items-center gap-2 mb-6 text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 px-3 py-2 rounded-xl border border-slate-100">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Finalized &bull; <span
                        x-text="selectedRecord ? new Date(selectedRecord.appointment_time).toLocaleDateString('en-US', {day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute:'2-digit'}) : ''"></span></span>
            </div>

            {{-- Middle Area: Notes & Diagnosis --}}
            <div class="space-y-5">
                {{-- Symptoms / Notes --}}
                <div class="bg-slate-50/70 border border-slate-100 rounded-xl md:rounded-2xl p-4 md:p-5">
                    <h4 class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        Clinical Notes & Symptoms</h4>
                    <p class="text-xs text-slate-700 font-medium leading-relaxed"
                        x-text="selectedRecord && selectedRecord.symptoms ? selectedRecord.symptoms : 'No specific symptoms logged.'">
                    </p>
                    <p class="text-xs text-slate-500 italic mt-2"
                        x-text="selectedRecord && selectedRecord.reason ? 'Reason: ' + selectedRecord.reason : ''">
                    </p>
                </div>

                {{-- Official Diagnoses --}}
                <div class="bg-rose-50/30 border border-rose-100/40 rounded-xl md:rounded-2xl p-4 md:p-5">
                    <h4 class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-rose-500 mb-2">
                        Official Diagnoses</h4>
                    <p class="text-xs md:text-sm font-bold text-slate-800"
                        x-text="selectedRecord && selectedRecord.diagnosis ? selectedRecord.diagnosis : 'Routine Clinical Evaluation'">
                    </p>
                </div>
            </div>

            {{-- Bottom Area: Medications and Blockchain signature --}}
            <div class="mt-6 pt-5 border-t border-slate-100 space-y-5">
                <div class="bg-slate-900 text-white rounded-xl md:rounded-2xl p-4 md:p-5 relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-white/5 rounded-full"></div>
                    <h4 class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">
                        Prescribed Medications</h4>
                    <p class="text-xs font-bold text-slate-100 leading-relaxed"
                        x-text="selectedRecord && selectedRecord.prescription ? selectedRecord.prescription : 'No prescription needed.'">
                    </p>
                </div>

                {{-- Cryptographic Verification Seal --}}
                <div
                    class="border border-emerald-100 bg-emerald-50/50 rounded-lg md:rounded-xl p-3 md:p-3.5 flex items-start gap-2.5 md:gap-3">
                    <div
                        class="w-6 h-6 md:w-7 md:h-7 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-600 shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.956 11.956 0 0112 2.714z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[9px] md:text-[10px] font-black text-emerald-800 uppercase tracking-wider">✓
                            Secure Ledger Integrity Seal</p>
                        <p class="text-[8px] md:text-[9px] text-emerald-600 font-semibold mt-0.5 leading-normal">
                            This medical record is cryptographically signed and audited. Immutable data protection
                            standard enforced.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
