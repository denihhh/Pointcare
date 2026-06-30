<div x-show="step === 2" x-cloak x-transition:enter="transition ease-out duration-350" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
    <div class="text-center sm:text-left">
        <h2 class="text-xl font-black text-slate-900 tracking-tight">Visit Details & Date Selection</h2>
        <p class="text-slate-450 text-xs mt-1">Provide visit details and choose a date from the calendar.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
        
        <!-- Consultation Reason inputs -->
        <div class="space-y-4">
            <div class="space-y-2">
                <label for="reason-input-field" class="block text-xs font-black text-slate-750 uppercase tracking-widest ml-1">Reason for Visit</label>
                <textarea id="reason-input-field" x-model="reason" name="reason" rows="4" placeholder="Briefly describe your symptoms or booking reason (e.g. routine wellness check, persistent chest tightness, flu symptoms, prescription renewal...)"
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 outline-none focus:border-rose-500 focus:ring-4 focus:ring-rose-100 text-sm transition-all duration-200 placeholder-slate-400"></textarea>
                @error('reason') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase tracking-wider ml-1">{{ $message }}</p> @enderror
            </div>

            <!-- Predefined Quick Select Options -->
            <div class="space-y-2">
                <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Quick Select Reasons</span>
                <div class="flex flex-wrap gap-2">
                    <template x-for="r in ['General Health Screening', 'Chronic Illness Follow-Up', 'Medical Consultation', 'Prescription Renewal', 'Lab Result Review']">
                        <button type="button" @click="reason = r"
                            class="px-3 py-1.5 rounded-lg border text-xs font-bold transition-all"
                            :class="reason === r ? 'bg-rose-50 border-rose-200 text-rose-600 font-extrabold' : 'bg-white border-slate-200 text-slate-650 hover:bg-slate-50'">
                            <span x-text="r"></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Alpine-Based Custom Calendar Widget -->
        <div class="space-y-3">
            <span class="block text-xs font-black text-slate-750 uppercase tracking-widest ml-1">Select Date</span>
            <div class="bg-slate-50 border border-slate-150 rounded-2xl p-4">
                <!-- Calendar Header -->
                <div class="flex items-center justify-between mb-4 px-1">
                    <button type="button" @click="prevMonth()" class="p-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 transition text-slate-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <div class="text-xs sm:text-sm font-black text-slate-900 uppercase tracking-wider" x-text="monthNames[currentMonth] + ' ' + currentYear"></div>
                    <button type="button" @click="nextMonth()" class="p-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-50 transition text-slate-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>

                <!-- Weekdays Heading -->
                <div class="grid grid-cols-7 gap-1 text-center text-[10px] font-black uppercase text-slate-400 tracking-wider mb-2">
                    <span>Su</span><span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
                </div>

                <!-- Calendar Grid of Days -->
                <div class="grid grid-cols-7 gap-1.5 text-center">
                    <template x-for="(day, idx) in calendarDays" :key="idx">
                        <button type="button" 
                            @click="selectDate(day.dateStr, day.isDisabled)"
                            :disabled="day.isDisabled"
                            class="py-2 rounded-xl text-xs font-bold transition-all relative flex flex-col items-center justify-center aspect-square"
                            :class="[
                                day.isDisabled ? 'opacity-20 cursor-not-allowed text-slate-400' : 'cursor-pointer',
                                selectedDate === day.dateStr ? 'bg-rose-500 text-white shadow-md shadow-rose-200' : 'bg-white border border-slate-100 hover:border-rose-350 text-slate-750',
                                day.isToday && selectedDate !== day.dateStr ? 'ring-2 ring-slate-900 ring-offset-1' : ''
                            ]">
                            <span x-text="day.dayNum"></span>
                            <!-- Small dot under today -->
                            <span x-show="day.isToday && selectedDate !== day.dateStr" class="absolute bottom-1 w-1 h-1 bg-slate-900 rounded-full"></span>
                        </button>
                    </template>
                </div>
            </div>
            @error('appointment_date') <p class="text-red-500 text-[10px] font-bold uppercase tracking-wider ml-1">{{ $message }}</p> @enderror
        </div>

    </div>

    <!-- Step Footer Navigation -->
    <div class="flex justify-between pt-4 border-t border-slate-100">
        <button type="button" @click="step = 1"
            class="px-5 py-3 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-700 font-black text-xs uppercase tracking-widest transition-all">
            Previous
        </button>
        <button type="button" @click="step = 3" :disabled="!selectedDate || !reason"
            class="px-6 py-3 rounded-xl bg-slate-900 text-white font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
            Next Step
        </button>
    </div>
</div>
