@props(['isEdit' => false])

<div x-show="step === 4" x-cloak x-transition:enter="transition ease-out duration-350" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
    <div class="text-center sm:text-left">
        <h2 class="text-xl font-black text-slate-900 tracking-tight">Review & Confirm Appointment</h2>
        <p class="text-slate-450 text-xs mt-1">Ensure all details are correct before finalize your booking request.</p>
    </div>

    <!-- Summary grid -->
    <div class="bg-slate-50 border border-slate-150 rounded-2xl p-6 space-y-5">
        
        <!-- Doctor block -->
        <div class="flex items-center gap-4 border-b border-slate-150 pb-4">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white font-black text-lg bg-gradient-to-br"
                 :class="getDoctorGradient(doctorId)">
                <span x-text="getInitials(selectedDoctorName())"></span>
            </div>
            <div>
                <div class="text-[10px] text-slate-400 font-black uppercase tracking-wider">Physician</div>
                <h4 class="font-extrabold text-slate-900 text-sm sm:text-base" x-text="'Dr. ' + cleanDoctorName(selectedDoctorName())"></h4>
                <span class="text-xs text-rose-500 font-bold" x-text="selectedDoctorSpecialization()"></span>
            </div>
        </div>

        <!-- Appointment details block -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-b border-slate-150 pb-4">
            <div>
                <div class="text-[10px] text-slate-400 font-black uppercase tracking-wider">Date & Time</div>
                <div class="text-slate-800 font-bold text-xs sm:text-sm mt-0.5 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span x-text="formatFullDate(selectedDate) + ' at ' + formatTime(selectedTime)"></span>
                </div>
            </div>
            <div>
                <div class="text-[10px] text-slate-400 font-black uppercase tracking-wider">Location / Facility</div>
                <div class="text-slate-800 font-bold text-xs sm:text-sm mt-0.5 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>PointCare Specialist Clinic</span>
                </div>
            </div>
        </div>

        <!-- Reason block -->
        <div class="border-b border-slate-150 pb-4">
            <div class="text-[10px] text-slate-400 font-black uppercase tracking-wider">Reason for Visit</div>
            <p class="text-slate-700 text-xs sm:text-sm font-semibold mt-1 italic" x-text="reason ? '“' + reason + '”' : 'No details provided.'"></p>
        </div>

        <!-- Cost block -->
        <div class="flex justify-between items-center pt-2">
            <div>
                <span class="block text-[10px] text-slate-400 font-black uppercase tracking-wider">Consultation Fee</span>
                <span class="text-xs text-slate-450">Payable at clinic desk after visit</span>
            </div>
            <div class="text-lg sm:text-xl font-black text-rose-500" x-text="'RM ' + parseFloat(selectedDoctorFee()).toFixed(2)"></div>
        </div>
    </div>

    <!-- Clinic notice warning -->
    <div class="p-4 bg-rose-50/40 border border-rose-100 rounded-2xl flex items-start space-x-3 text-rose-800 text-xs">
        <svg class="w-4 h-4 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div>
            <p class="font-extrabold uppercase tracking-wider text-[10px]">Cancellation & Rescheduling Policy</p>
            <p class="text-rose-700/80 mt-0.5">If you need to change or cancel this appointment, please do so at least 24 hours prior to the slot. Thank you for your cooperation.</p>
        </div>
    </div>

    <!-- Step Footer Navigation -->
    <div class="flex justify-between pt-4 border-t border-slate-100">
        <button type="button" @click="step = 3"
            class="px-5 py-3 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-700 font-black text-xs uppercase tracking-widest transition-all">
            Previous
        </button>
        
        <button type="submit"
            class="px-8 py-3.5 rounded-xl bg-rose-500 hover:bg-rose-600 text-white font-black text-xs uppercase tracking-widest shadow-lg shadow-rose-200 transition-all hover:-translate-y-0.5 active:scale-95">
            {{ $isEdit ? 'Update Appointment' : 'Confirm Booking' }}
        </button>
    </div>
</div>
