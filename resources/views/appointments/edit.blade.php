<x-layout title="Edit Appointment">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 pt-4"
         x-data="appointmentFlow()"
         x-init="init()">
        
        <!-- Back button and title -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
            <div>
                <x-return to="dashboard"/>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight mt-3">Edit Appointment</h1>
                <p class="text-slate-500 text-sm">Reschedule or modify details of your active booking.</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-rose-50/70 border border-rose-100 rounded-2xl flex items-start space-x-3 text-rose-800 text-sm animate-shake">
                <svg class="w-5 h-5 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <div>
                    <p class="font-bold">Please resolve the following issues:</p>
                    <ul class="list-disc list-inside mt-1 space-y-0.5 text-xs text-rose-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="/appointments/{{ $appointment->id }}" method="POST" id="appointment-form">
            @csrf
            @method('PATCH')
            
            <!-- Hidden Fields for Form Submission -->
            <input type="hidden" name="doctor_id" :value="doctorId">
            <input type="hidden" name="appointment_time" :value="selectedDate && selectedTime ? selectedDate + ' ' + selectedTime : ''">
            <input type="hidden" name="selected_time" :value="selectedTime">
            <input type="hidden" name="appointment_date" :value="selectedDate">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Hand: Editing Panel -->
                <div class="lg:col-span-8 space-y-6">
                    
                    <!-- Section: Doctor Selection & Details -->
                    <div class="bg-white border border-slate-100 rounded-[2rem] p-6 sm:p-8 shadow-xs relative overflow-hidden">
                        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-rose-400 to-rose-600"></div>
                        
                        <!-- Header -->
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-black text-slate-900 uppercase tracking-wider">1. Physician</h2>
                            <button type="button" @click="showDoctorSelect = !showDoctorSelect"
                                    class="px-4 py-1.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-black uppercase tracking-wider transition-all">
                                <span x-text="showDoctorSelect ? 'Keep Current Physician' : 'Change Physician'"></span>
                            </button>
                        </div>

                        <!-- Current Doctor Card Details -->
                        <div x-show="!showDoctorSelect" class="p-5 rounded-2xl border border-slate-150 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white font-extrabold text-lg bg-gradient-to-br"
                                     :class="getDoctorGradient(doctorId)">
                                    <span x-text="getInitials(selectedDoctorName())"></span>
                                </div>
                                <div>
                                    <h3 class="text-base font-black text-slate-900" x-text="'Dr. ' + cleanDoctorName(selectedDoctorName())"></h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-rose-50 text-rose-600 border border-rose-100/50" x-text="selectedDoctorSpecialization()"></span>
                                </div>
                            </div>
                            <div class="text-right sm:border-l sm:border-slate-200 sm:pl-6">
                                <div class="text-[9px] text-slate-450 uppercase font-black tracking-wider">Consultation Fee</div>
                                <div class="text-base font-black text-slate-900" x-text="'RM ' + parseFloat(selectedDoctorFee()).toFixed(2)"></div>
                            </div>
                        </div>

                        <!-- Doctor selector list component, visible only when changing -->
                        <div x-show="showDoctorSelect" x-cloak class="space-y-6 pt-2">
                            <!-- Search and Filter Bar -->
                            <div class="flex flex-col md:flex-row gap-4 items-stretch md:items-center justify-between pb-2">
                                <div class="relative flex-1">
                                    <input type="text" x-model="doctorSearch" placeholder="Search by name or specialization..."
                                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 outline-none focus:border-rose-500 focus:ring-4 focus:ring-rose-100 text-sm transition-all duration-200">
                                    <svg class="w-5 h-5 text-slate-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                                <div class="flex items-center space-x-2 overflow-x-auto pb-1 scrollbar-thin md:max-w-xs">
                                    <button type="button" @click="selectedSpecialization = 'All'"
                                        class="px-4 py-2 rounded-xl text-xs font-black whitespace-nowrap transition-all duration-200"
                                        :class="selectedSpecialization === 'All' ? 'bg-rose-500 text-white' : 'bg-slate-50 border border-slate-150 text-slate-650 hover:bg-slate-100'">
                                        All Care
                                    </button>
                                    <template x-for="spec in getSpecializations()" :key="spec">
                                        <button type="button" @click="selectedSpecialization = spec"
                                            class="px-4 py-2 rounded-xl text-xs font-black whitespace-nowrap transition-all duration-200"
                                            :class="selectedSpecialization === spec ? 'bg-rose-500 text-white' : 'bg-slate-50 border border-slate-150 text-slate-650 hover:bg-slate-100'">
                                            <span x-text="spec"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[350px] overflow-y-auto pr-1">
                                <template x-for="doctor in filteredDoctors()" :key="doctor.id">
                                    <div @click="selectDoctor(doctor)" 
                                         class="p-4 rounded-xl border transition-all duration-350 cursor-pointer flex flex-col justify-between hover:shadow-xs group relative overflow-hidden"
                                         :class="doctorId === doctor.id ? 'border-rose-500 bg-rose-50/20' : 'border-slate-150 bg-white hover:border-slate-350'">
                                        <div>
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-extrabold text-sm shrink-0 bg-gradient-to-br"
                                                     :class="getDoctorGradient(doctor.id)">
                                                    <span x-text="getInitials(doctor.name)"></span>
                                                </div>
                                                <div class="min-w-0">
                                                    <h4 class="text-xs sm:text-sm font-black text-slate-900 group-hover:text-rose-600 truncate" x-text="'Dr. ' + cleanDoctorName(doctor.name)"></h4>
                                                    <span class="text-[9px] font-black uppercase text-rose-500" x-text="doctor.doctor ? doctor.doctor.specialization : 'General Practitioner'"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between border-t border-slate-100 mt-4 pt-2">
                                            <span class="text-[9px] text-slate-400 font-bold uppercase">Fee</span>
                                            <span class="text-xs font-black text-slate-900" x-text="'RM ' + parseFloat(doctor.doctor ? doctor.doctor.consultation_fee : 60).toFixed(2)"></span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                    </div>

                    <!-- Section: Reason and Schedule -->
                    <div class="bg-white border border-slate-100 rounded-[2rem] p-6 sm:p-8 shadow-xs relative overflow-hidden">
                        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-indigo-400 to-indigo-600"></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <!-- Reason for visit -->
                            <div class="space-y-4">
                                <h2 class="text-lg font-black text-slate-900 uppercase tracking-wider">2. Reason for Visit</h2>
                                
                                <div class="space-y-2">
                                    <textarea id="reason-input-edit" x-model="reason" name="reason" rows="4" placeholder="Describe symptoms or reasons..."
                                              class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 outline-none focus:border-rose-500 focus:ring-4 focus:ring-rose-100 text-sm transition-all duration-200 placeholder-slate-400"></textarea>
                                    @error('reason') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase tracking-wider ml-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="space-y-2">
                                    <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Quick Select Reasons</span>
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="r in ['General Health Screening', 'Chronic Illness Follow-Up', 'Medical Consultation', 'Prescription Renewal', 'Lab Result Review']">
                                            <button type="button" @click="reason = r"
                                                class="px-2.5 py-1.5 rounded-lg border text-[11px] font-bold transition-all"
                                                :class="reason === r ? 'bg-rose-50 border-rose-200 text-rose-600 font-extrabold' : 'bg-white border-slate-200 text-slate-650 hover:bg-slate-50'">
                                                <span x-text="r"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Calendar -->
                            <div class="space-y-4">
                                <h2 class="text-lg font-black text-slate-900 uppercase tracking-wider">3. Schedule Date</h2>

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
                                                <span x-show="day.isToday && selectedDate !== day.dateStr" class="absolute bottom-1 w-1 h-1 bg-slate-900 rounded-full"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Section: Timeslots -->
                    <div class="bg-white border border-slate-100 rounded-[2rem] p-6 sm:p-8 shadow-xs relative overflow-hidden" x-show="selectedDate">
                        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-emerald-400 to-emerald-600"></div>
                        
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-black text-slate-900 uppercase tracking-wider">4. Timeslot</h2>
                            <span class="text-xs text-slate-450 font-bold" x-text="formatFullDate(selectedDate)"></span>
                        </div>

                        <!-- Loading Indicator -->
                        <div x-show="loadingSlots" class="py-8 flex flex-col items-center justify-center space-y-2">
                            <svg class="animate-spin h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Loading Available Slots...</span>
                        </div>

                        <!-- Slots Grid -->
                        <div x-show="!loadingSlots && slots.length > 0" class="space-y-4">
                            <!-- Morning Slots Section -->
                            <div class="space-y-2" x-show="morningSlots().length > 0">
                                <h3 class="text-[10px] font-black uppercase text-slate-400 tracking-widest flex items-center gap-1.5">Morning Appointments</h3>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    <template x-for="slot in morningSlots()" :key="slot">
                                        <button type="button" @click="selectedTime = slot"
                                            class="py-2.5 px-3 rounded-xl text-xs font-black tracking-wider transition-all duration-200 flex items-center justify-between border"
                                            :class="selectedTime === slot ? 'bg-slate-900 border-slate-900 text-white' : 'bg-white border-slate-200 text-slate-700 hover:border-rose-350'">
                                            <span x-text="formatTime(slot)"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <!-- Afternoon Slots Section -->
                            <div class="space-y-2" x-show="afternoonSlots().length > 0">
                                <h3 class="text-[10px] font-black uppercase text-slate-400 tracking-widest flex items-center gap-1.5">Afternoon Appointments</h3>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    <template x-for="slot in afternoonSlots()" :key="slot">
                                        <button type="button" @click="selectedTime = slot"
                                            class="py-2.5 px-3 rounded-xl text-xs font-black tracking-wider transition-all duration-200 flex items-center justify-between border"
                                            :class="selectedTime === slot ? 'bg-slate-900 border-slate-900 text-white' : 'bg-white border-slate-200 text-slate-700 hover:border-rose-350'">
                                            <span x-text="formatTime(slot)"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- No Slots State -->
                        <div x-show="!loadingSlots && slots.length === 0" x-cloak class="p-4 bg-amber-50/40 text-amber-800 rounded-xl border border-amber-200/50 text-center text-xs">
                            No scheduling slots available on this date.
                        </div>
                    </div>

                </div>

                <!-- Right Hand: Side-by-Side Comparison & Submit Card -->
                <div class="lg:col-span-4 space-y-6 sticky top-8">
                    <div class="bg-white border border-slate-100 rounded-[2rem] p-6 shadow-xs relative overflow-hidden">
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-4">
                            Reschedule Overview
                        </h3>

                        <!-- Side by Side Panel -->
                        <div class="space-y-4">
                            
                            <!-- Before Panel -->
                            <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl space-y-3 opacity-75">
                                <div class="flex items-center justify-between">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Original Schedule</span>
                                    <span class="text-[8px] bg-slate-200 text-slate-600 px-1.5 py-0.5 rounded font-black uppercase">Current</span>
                                </div>
                                <div class="space-y-1.5 text-xs text-slate-700">
                                    <div class="font-extrabold truncate" x-text="'Dr. ' + cleanDoctorName(originalDoctorName)"></div>
                                    <div class="flex items-center gap-1.5 font-semibold text-slate-500">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span x-text="formatFullDate(originalDate) + ' - ' + formatTime(originalTime)"></span>
                                    </div>
                                    <div class="italic truncate text-slate-450 mt-1" x-text="'“' + originalReason + '”'"></div>
                                </div>
                            </div>

                            <!-- Indicator Line -->
                            <div class="flex justify-center -my-2">
                                <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 13l-7 7-7-7m14-6l-7 7-7-7"/></svg>
                                </div>
                            </div>

                            <!-- After Panel -->
                            <div class="p-4 rounded-2xl border transition-all duration-300 space-y-3"
                                 :class="isAnyChanged() ? 'border-rose-100 bg-rose-50/10' : 'border-slate-150 bg-white'">
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-[9px] font-black text-rose-550 uppercase tracking-wider">Proposed Changes</span>
                                    <span x-show="isAnyChanged()" class="text-[8px] bg-rose-500 text-white px-1.5 py-0.5 rounded font-black uppercase tracking-wider">Modified</span>
                                </div>
                                
                                <div class="space-y-2 text-xs">
                                    <!-- Doctor -->
                                    <div class="flex flex-col">
                                        <span class="text-[8px] text-slate-400 uppercase font-bold">Physician</span>
                                        <div class="flex items-center justify-between mt-0.5">
                                            <span class="font-extrabold text-slate-850" :class="isDoctorChanged() ? 'text-rose-600' : ''" x-text="'Dr. ' + cleanDoctorName(selectedDoctorName())"></span>
                                            <span x-show="isDoctorChanged()" class="text-[8px] text-rose-600 bg-rose-50 px-1 rounded font-bold uppercase tracking-wider">New</span>
                                        </div>
                                    </div>

                                    <!-- Date Time -->
                                    <div class="flex flex-col">
                                        <span class="text-[8px] text-slate-400 uppercase font-bold">Rescheduled Date & Time</span>
                                        <div class="flex items-center justify-between mt-0.5">
                                            <div class="flex items-center gap-1 font-extrabold text-slate-850" :class="isDateChanged() ? 'text-rose-600 font-black' : ''">
                                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                <span x-text="selectedDate && selectedTime ? formatFullDate(selectedDate) + ' - ' + formatTime(selectedTime) : 'Select a date and slot'"></span>
                                            </div>
                                            <span x-show="isDateChanged()" class="text-[8px] text-rose-600 bg-rose-50 px-1 rounded font-bold uppercase tracking-wider">Changed</span>
                                        </div>
                                    </div>

                                    <!-- Reason -->
                                    <div class="flex flex-col">
                                        <span class="text-[8px] text-slate-400 uppercase font-bold">Reason</span>
                                        <div class="flex items-center justify-between mt-0.5">
                                            <span class="font-semibold italic text-slate-700 truncate max-w-[150px]" :class="isReasonChanged() ? 'text-rose-600 font-extrabold' : ''" x-text="reason ? '“' + reason + '”' : '—'"></span>
                                            <span x-show="isReasonChanged()" class="text-[8px] text-rose-600 bg-rose-50 px-1 rounded font-bold uppercase tracking-wider">Edited</span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Cost calculations -->
                            <div class="pt-4 border-t border-slate-100 space-y-2">
                                <div class="flex justify-between text-xs text-slate-500">
                                    <span>Consultation Fee</span>
                                    <span class="font-bold text-slate-800" x-text="'RM ' + parseFloat(selectedDoctorFee()).toFixed(2)"></span>
                                </div>
                                <div class="flex justify-between items-center pt-2 border-t border-slate-100">
                                    <span class="text-xs font-black uppercase text-slate-800 tracking-wider">Estimated Total</span>
                                    <span class="text-base font-black text-rose-500" x-text="'RM ' + parseFloat(selectedDoctorFee()).toFixed(2)"></span>
                                </div>
                            </div>

                        </div>

                        <!-- Update action buttons -->
                        <div class="mt-6 pt-4 border-t border-slate-100">
                            <button type="submit" :disabled="!selectedDate || !selectedTime || !reason || !isAnyChanged()"
                                    class="w-full py-3.5 rounded-xl bg-rose-500 hover:bg-rose-600 disabled:bg-slate-200 disabled:text-slate-400 disabled:shadow-none text-white font-black text-xs uppercase tracking-widest shadow-lg shadow-rose-200 transition-all hover:-translate-y-0.5 active:scale-95 disabled:cursor-not-allowed">
                                Update Appointment
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <!-- Alpine JS App Script Implementation -->
    <script>
        function appointmentFlow() {
            return {
                // Form Data & State Bindings (Pre-filled for Editing)
                doctorId: @json(old('doctor_id', $appointment->doctor_id)),
                selectedDate: @json(old('appointment_date', \Carbon\Carbon::parse($appointment->appointment_time)->format('Y-m-d'))),
                selectedTime: @json(old('selected_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i'))),
                reason: @json(old('reason', $appointment->reason)),
                slots: [],
                loadingSlots: false,
                showDoctorSelect: false,

                // Original details for side-by-side comparison
                originalDoctorId: @json($appointment->doctor_id),
                originalDoctorName: @json($appointment->doctor->name),
                originalDoctorSpecialization: @json($appointment->doctor->doctor->specialization),
                originalDoctorFee: @json($appointment->doctor->doctor->consultation_fee),
                originalDate: @json(\Carbon\Carbon::parse($appointment->appointment_time)->format('Y-m-d')),
                originalTime: @json(\Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')),
                originalReason: @json($appointment->reason),

                // Doctors collection injected from Laravel Backend
                doctorsData: @json($doctors),
                
                // Filters & Search
                doctorSearch: '',
                selectedSpecialization: 'All',

                // Custom Calendar Core State
                currentYear: new Date().getFullYear(),
                currentMonth: new Date().getMonth(), // 0-11
                calendarDays: [],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],

                init() {
                    // Populate initial calendar days grid
                    this.generateCalendar();

                    // Load current slots based on initial doctor/date
                    if (this.doctorId) {
                        if (this.selectedDate) {
                            const d = new Date(this.selectedDate);
                            if (!isNaN(d.getTime())) {
                                this.currentYear = d.getFullYear();
                                this.currentMonth = d.getMonth();
                                this.generateCalendar();
                            }
                            this.fetchAvailableSlots();
                        }
                    }
                },

                // Filters doctors list in search/specialization panel
                filteredDoctors() {
                    return this.doctorsData.filter(doc => {
                        const nameMatch = doc.name.toLowerCase().includes(this.doctorSearch.toLowerCase());
                        const spec = doc.doctor ? doc.doctor.specialization : 'General Practitioner';
                        const specMatch = this.selectedSpecialization === 'All' || spec === this.selectedSpecialization;
                        return nameMatch && specMatch;
                    });
                },

                // Resolves distinct list of specializations from database doctors
                getSpecializations() {
                    const specs = this.doctorsData.map(doc => doc.doctor ? doc.doctor.specialization : 'General Practitioner');
                    return [...new Set(specs)].filter(Boolean);
                },

                // Action when doctor card gets clicked
                selectDoctor(doc) {
                    this.doctorId = doc.id;
                    this.selectedDate = '';
                    this.selectedTime = '';
                    this.slots = [];
                    this.showDoctorSelect = false;
                },

                // Action when calendar day is clicked
                selectDate(dateStr, isDisabled) {
                    if (isDisabled) return;
                    this.selectedDate = dateStr;
                    this.selectedTime = '';
                    this.slots = [];
                    this.fetchAvailableSlots();
                },

                // Retrieve slot list using fetch API (Includes original booked time if criteria match)
                async fetchAvailableSlots() {
                    if (!this.doctorId || !this.selectedDate) return;
                    this.loadingSlots = true;
                    try {
                        const params = new URLSearchParams({
                            doctor_id: this.doctorId,
                            date: this.selectedDate
                        });
                        const response = await fetch(`/api/available-slots?${params}`);
                        if (!response.ok) throw new Error(`HTTP ${response.status}`);
                        let data = await response.json();

                        // SPECIAL EDIT LOGIC:
                        // If the doctor and date match the ORIGINAL appointment,
                        // we must add the current booked time back into the list
                        // so it shows up as an option to keep.
                        const originalDate = this.originalDate;
                        const originalTime = this.originalTime;
                        const originalDoctor = this.originalDoctorId;

                        if (this.doctorId == originalDoctor && this.selectedDate == originalDate) {
                            if (!data.includes(originalTime)) {
                                data.push(originalTime);
                                data.sort(); // Keep them in chronological order
                            }
                        }

                        this.slots = data;
                    } catch (e) {
                        console.error("Error fetching slots:", e);
                        this.slots = [];
                    } finally {
                        this.loadingSlots = false;
                    }
                },

                // Comparison checks for UI highlights
                isDoctorChanged() {
                    return this.doctorId !== this.originalDoctorId;
                },

                isDateChanged() {
                    return this.selectedDate !== this.originalDate || this.selectedTime !== this.originalTime;
                },

                isReasonChanged() {
                    return this.reason.trim() !== this.originalReason.trim();
                },

                isAnyChanged() {
                    return this.isDoctorChanged() || this.isDateChanged() || this.isReasonChanged();
                },

                // Generate Calendar Grid Days Objects
                generateCalendar() {
                    const year = this.currentYear;
                    const month = this.currentMonth;
                    
                    const firstDayIndex = new Date(year, month, 1).getDay();
                    const totalDays = new Date(year, month + 1, 0).getDate();
                    const prevTotalDays = new Date(year, month, 0).getDate();
                    
                    const days = [];
                    
                    for (let i = firstDayIndex - 1; i >= 0; i--) {
                        const d = prevTotalDays - i;
                        const prevMonth = month === 0 ? 11 : month - 1;
                        const prevYear = month === 0 ? year - 1 : year;
                        days.push({
                            dayNum: d,
                            dateStr: `${prevYear}-${String(prevMonth + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`,
                            isDisabled: true,
                            isToday: false
                        });
                    }
                    
                    const today = new Date();
                    today.setHours(0,0,0,0);
                    
                    for (let d = 1; d <= totalDays; d++) {
                        const dateObj = new Date(year, month, d);
                        dateObj.setHours(0,0,0,0);
                        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
                        
                        const isPast = dateObj < today;
                        const isDisabled = isPast;
                        
                        days.push({
                            dayNum: d,
                            dateStr: dateStr,
                            isDisabled: isDisabled,
                            isToday: dateObj.getTime() === today.getTime()
                        });
                    }
                    
                    const remainingSlots = 42 - days.length;
                    for (let i = 1; i <= remainingSlots; i++) {
                        const nextMonth = month === 11 ? 0 : month + 1;
                        const nextYear = month === 11 ? year + 1 : year;
                        days.push({
                            dayNum: i,
                            dateStr: `${nextYear}-${String(nextMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`,
                            isDisabled: true,
                            isToday: false
                        });
                    }
                    
                    this.calendarDays = days;
                },

                prevMonth() {
                    const today = new Date();
                    if (this.currentYear === today.getFullYear() && this.currentMonth === today.getMonth()) {
                        return; // Prevent navigating to past months
                    }

                    if (this.currentMonth === 0) {
                        this.currentMonth = 11;
                        this.currentYear--;
                    } else {
                        this.currentMonth--;
                    }
                    this.generateCalendar();
                },

                nextMonth() {
                    if (this.currentMonth === 11) {
                        this.currentMonth = 0;
                        this.currentYear++;
                    } else {
                        this.currentMonth++;
                    }
                    this.generateCalendar();
                },

                // Period slots filters
                morningSlots() {
                    return this.slots.filter(s => parseInt(s.split(':')[0]) < 12);
                },

                afternoonSlots() {
                    return this.slots.filter(s => parseInt(s.split(':')[0]) >= 12);
                },

                // UI Text Helpers
                cleanDoctorName(name) {
                    if (!name) return '';
                    return name.replace(/^dr\.?\s+/i, '');
                },

                getInitials(name) {
                    if (!name) return 'PC';
                    const cleaned = this.cleanDoctorName(name);
                    const parts = cleaned.trim().split(/\s+/);
                    if (parts.length >= 2) {
                        return (parts[0][0] + parts[1][0]).toUpperCase();
                    }
                    return cleaned.substring(0, 2).toUpperCase();
                },

                getDoctorGradient(id) {
                    const gradients = [
                        'from-rose-500 to-pink-600',
                        'from-violet-500 to-indigo-600',
                        'from-blue-500 to-cyan-600',
                        'from-teal-500 to-emerald-600',
                        'from-amber-500 to-orange-600',
                        'from-fuchsia-500 to-purple-600'
                    ];
                    return gradients[id % gradients.length];
                },

                formatTime(time) {
                    if (!time) return '';
                    const [hour, minute] = time.split(':');
                    const h = hour % 12 || 12;
                    const ampm = hour >= 12 ? 'PM' : 'AM';
                    return `${h}:${minute} ${ampm}`;
                },

                formatFullDate(dateStr) {
                    if (!dateStr) return '';
                    const d = new Date(dateStr);
                    if (isNaN(d.getTime())) return '';
                    
                    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    
                    return `${days[d.getDay()]}, ${months[d.getMonth()]} ${d.getDate()}, ${d.getFullYear()}`;
                },

                // Selected doctor getters
                selectedDoctorObj() {
                    return this.doctorsData.find(d => d.id === this.doctorId) || null;
                },

                selectedDoctorName() {
                    const doc = this.selectedDoctorObj();
                    return doc ? doc.name : '';
                },

                selectedDoctorSpecialization() {
                    const doc = this.selectedDoctorObj();
                    return doc && doc.doctor ? doc.doctor.specialization : 'General Practitioner';
                },

                selectedDoctorFee() {
                    const doc = this.selectedDoctorObj();
                    return doc && doc.doctor ? doc.doctor.consultation_fee : 60.00;
                },
            }
        }
    </script>
</x-layout>
