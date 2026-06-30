<div class="bg-white border border-slate-100 rounded-[2rem] p-6 shadow-xs relative overflow-hidden">
    <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-4 flex items-center justify-between">
        <span>Booking Summary</span>
        <span class="text-[9px] px-2 py-0.5 bg-slate-100 text-slate-500 rounded-md font-bold" x-text="'Step ' + step"></span>
    </h3>

    <!-- Live Details Panel -->
    <div class="space-y-4">
        <!-- Empty Selection state -->
        <div x-show="!doctorId" class="py-6 text-center text-slate-405 space-y-2 border border-dashed border-slate-150 rounded-2xl">
            <svg class="w-8 h-8 mx-auto text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <p class="text-xs font-semibold">Select a Physician</p>
        </div>

        <!-- Doctor Summary Details -->
        <div x-show="doctorId" x-cloak class="p-3 bg-slate-50 rounded-2xl flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-black text-sm bg-gradient-to-br"
                 :class="getDoctorGradient(doctorId)">
                <span x-text="getInitials(selectedDoctorName())"></span>
            </div>
            <div class="min-w-0">
                <div class="text-[9px] text-slate-400 font-black uppercase tracking-wider leading-none">Selected Doctor</div>
                <div class="font-extrabold text-slate-800 text-xs truncate mt-1" x-text="'Dr. ' + cleanDoctorName(selectedDoctorName())"></div>
                <div class="text-[10px] text-rose-500 font-bold truncate leading-none mt-0.5" x-text="selectedDoctorSpecialization()"></div>
            </div>
        </div>

        <!-- Reason summary details -->
        <div x-show="doctorId && reason" x-cloak class="p-3 bg-slate-50 rounded-2xl">
            <div class="text-[9px] text-slate-400 font-black uppercase tracking-wider leading-none">Reason</div>
            <p class="text-slate-700 text-xs font-semibold mt-1.5 line-clamp-2 italic" x-text="'“' + reason + '”'"></p>
        </div>

        <!-- Date details -->
        <div x-show="doctorId && selectedDate" x-cloak class="p-3 bg-slate-50 rounded-2xl flex items-center gap-2.5">
            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <div class="min-w-0">
                <div class="text-[9px] text-slate-400 font-black uppercase tracking-wider leading-none">Date</div>
                <div class="text-slate-800 font-bold text-xs mt-1 truncate" x-text="formatFullDate(selectedDate)"></div>
            </div>
        </div>

        <!-- Time details -->
        <div x-show="doctorId && selectedDate && selectedTime" x-cloak class="p-3 bg-slate-50 rounded-2xl flex items-center gap-2.5">
            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div class="min-w-0">
                <div class="text-[9px] text-slate-400 font-black uppercase tracking-wider leading-none">Timeslot</div>
                <div class="text-slate-800 font-bold text-xs mt-1 truncate" x-text="formatTime(selectedTime)"></div>
            </div>
        </div>

        <!-- Fee calculations and breakdown -->
        <div x-show="doctorId" x-cloak class="pt-4 border-t border-slate-100 space-y-2">
            <div class="flex justify-between text-xs text-slate-550">
                <span>Physician Consultation</span>
                <span class="font-bold text-slate-800" x-text="'RM ' + parseFloat(selectedDoctorFee()).toFixed(2)"></span>
            </div>
            <div class="flex justify-between text-xs text-slate-550">
                <span>Clinic Service Fee</span>
                <span class="font-bold text-slate-800">FREE</span>
            </div>
            <div class="flex justify-between items-center pt-2 border-t border-slate-100">
                <span class="text-xs font-black uppercase text-slate-800 tracking-wider">Estimated Total</span>
                <span class="text-base font-black text-rose-500" x-text="'RM ' + parseFloat(selectedDoctorFee()).toFixed(2)"></span>
            </div>
        </div>

    </div>
    
    <!-- Mini Checklist validation -->
    <div x-show="doctorId" x-cloak class="mt-6 p-4 bg-slate-50 rounded-2xl border border-slate-150 space-y-2.5">
        <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none">Requirements Checklist</span>
        
        <div class="flex items-center space-x-2 text-xs">
            <div class="w-4 h-4 rounded-full flex items-center justify-center" :class="doctorId ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-300'">
                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <span class="font-semibold text-slate-650" :class="doctorId ? 'text-slate-800 font-extrabold' : ''">Select a Physician</span>
        </div>

        <div class="flex items-center space-x-2 text-xs">
            <div class="w-4 h-4 rounded-full flex items-center justify-center" :class="reason.trim().length > 0 ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-300'">
                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <span class="font-semibold text-slate-650" :class="reason.trim().length > 0 ? 'text-slate-800 font-extrabold' : ''">Add Visit Description</span>
        </div>

        <div class="flex items-center space-x-2 text-xs">
            <div class="w-4 h-4 rounded-full flex items-center justify-center" :class="selectedDate ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-300'">
                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <span class="font-semibold text-slate-650" :class="selectedDate ? 'text-slate-800 font-extrabold' : ''">Select Date</span>
        </div>

        <div class="flex items-center space-x-2 text-xs">
            <div class="w-4 h-4 rounded-full flex items-center justify-center" :class="selectedTime ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-300'">
                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <span class="font-semibold text-slate-650" :class="selectedTime ? 'text-slate-800 font-extrabold' : ''">Select Timeslot</span>
        </div>
    </div>
</div>
