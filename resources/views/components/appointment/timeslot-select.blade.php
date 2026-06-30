<div x-show="step === 3" x-cloak x-transition:enter="transition ease-out duration-350" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
    <div class="text-center sm:text-left">
        <h2 class="text-xl font-black text-slate-900 tracking-tight">Select Timeslot</h2>
        <p class="text-slate-450 text-xs mt-1">Choose an available slot for your appointment on <strong class="text-slate-800" x-text="formatFullDate(selectedDate)"></strong>.</p>
    </div>

    <!-- Loading Indicator -->
    <div x-show="loadingSlots" class="py-12 flex flex-col items-center justify-center space-y-3">
        <svg class="animate-spin h-8 w-8 text-rose-500" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="text-xs text-slate-500 font-bold uppercase tracking-wider">Checking Physician Availability...</span>
    </div>

    <!-- Slots Grid Grouped by Period -->
    <div x-show="!loadingSlots && slots.length > 0" class="space-y-6">
        
        <!-- Morning Slots Section -->
        <div class="space-y-3" x-show="morningSlots().length > 0">
            <h3 class="text-xs font-black uppercase text-slate-455 tracking-widest flex items-center gap-1.5">
                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
                Morning Appointments
            </h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <template x-for="slot in morningSlots()" :key="slot">
                    <button type="button" @click="selectedTime = slot"
                        class="py-3 px-4 rounded-xl text-xs font-black tracking-wider transition-all duration-200 flex items-center justify-between border hover:scale-[1.02]"
                        :class="selectedTime === slot ? 'bg-slate-900 border-slate-900 text-white shadow-md' : 'bg-white border-slate-200 text-slate-700 hover:border-rose-300 hover:bg-rose-50/10'">
                        <span x-text="formatTime(slot)"></span>
                        <span class="text-[9px] uppercase font-black tracking-widest" :class="selectedTime === slot ? 'text-rose-400' : 'text-slate-450'">Select</span>
                    </button>
                </template>
            </div>
        </div>

        <!-- Afternoon Slots Section -->
        <div class="space-y-3" x-show="afternoonSlots().length > 0">
            <h3 class="text-xs font-black uppercase text-slate-455 tracking-widest flex items-center gap-1.5">
                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 110 8 4 4 0 010-8z"/></svg>
                Afternoon Appointments
            </h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <template x-for="slot in afternoonSlots()" :key="slot">
                    <button type="button" @click="selectedTime = slot"
                        class="py-3 px-4 rounded-xl text-xs font-black tracking-wider transition-all duration-200 flex items-center justify-between border hover:scale-[1.02]"
                        :class="selectedTime === slot ? 'bg-slate-900 border-slate-900 text-white shadow-md' : 'bg-white border-slate-200 text-slate-700 hover:border-rose-300 hover:bg-rose-50/10'">
                        <span x-text="formatTime(slot)"></span>
                        <span class="text-[9px] uppercase font-black tracking-widest" :class="selectedTime === slot ? 'text-rose-400' : 'text-slate-450'">Select</span>
                    </button>
                </template>
            </div>
        </div>
    </div>

    <!-- No Slots State -->
    <div x-show="!loadingSlots && slots.length === 0" x-cloak class="p-6 bg-amber-50/40 text-amber-800 rounded-2xl border border-amber-200/50 text-center">
        <svg class="w-8 h-8 text-amber-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <h4 class="font-bold text-xs uppercase tracking-wider text-amber-800">No Availability Detected</h4>
        <p class="text-xs text-amber-700/80 mt-1 max-w-sm mx-auto">Dr. <span x-text="selectedDoctorName()"></span> is fully booked or has no scheduling slots on this date. Please check back later or choose another date/doctor.</p>
    </div>
    
    @error('selected_time') <p class="text-red-500 text-[10px] font-bold uppercase tracking-wider ml-1">Please select an available timeslot before booking.</p> @enderror

    <!-- Step Footer Navigation -->
    <div class="flex justify-between pt-4 border-t border-slate-100">
        <button type="button" @click="step = 2"
            class="px-5 py-3 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-700 font-black text-xs uppercase tracking-widest transition-all">
            Previous
        </button>
        <button type="button" @click="step = 4" :disabled="!selectedTime"
            class="px-6 py-3 rounded-xl bg-slate-900 text-white font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
            Next Step
        </button>
    </div>
</div>
