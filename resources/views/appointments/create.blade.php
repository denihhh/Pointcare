<x-layout title="Book Appointment">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 pt-4"
         x-data="appointmentFlow()"
         x-init="init()">
        
        <!-- Back button and title -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
            <div>
                <x-return to="dashboard"/>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight mt-3">Book an Appointment</h1>
                <p class="text-slate-500 text-sm">Select a physician, pick a date, and secure your schedule in minutes.</p>
            </div>
            
            <!-- Progress stepper for desktop -->
            <div class="bg-white border border-slate-100 rounded-2xl p-3 shadow-xs hidden md:block w-72">
                <div class="flex justify-between text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1 px-1">
                    <span>Progress</span>
                    <span class="text-rose-500" x-text="step + '/4 Completed'"></span>
                </div>
                <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-rose-500 rounded-full transition-all duration-500" :style="'width: ' + (step * 25) + '%'"></div>
                </div>
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

        <form action="/appointments" method="POST" id="appointment-form">
            @csrf
            
            <!-- Hidden Fields for Form Submission -->
            <input type="hidden" name="doctor_id" :value="doctorId">
            <input type="hidden" name="appointment_time" :value="selectedDate && selectedTime ? selectedDate + ' ' + selectedTime : ''">
            <input type="hidden" name="selected_time" :value="selectedTime">
            <input type="hidden" name="appointment_date" :value="selectedDate">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Hand: Interactive Booking Wizard Card -->
                <div class="lg:col-span-8 bg-white border border-slate-100 rounded-[2rem] p-6 sm:p-8 shadow-xs relative overflow-hidden">
                    
                    <!-- Top Ambient Flow Glow -->
                    <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-rose-400 via-rose-500 to-indigo-500"></div>

                    <!-- Step Stepper Indicators component -->
                    <x-appointment.stepper />

                    <!-- Step 1: Doctor select list component -->
                    <x-appointment.doctor-select />

                    <!-- Step 2: Reason details & Calendar date component -->
                    <x-appointment.details-date />

                    <!-- Step 3: Timeslot selector list component -->
                    <x-appointment.timeslot-select />

                    <!-- Step 4: Summary checkout & confirmation component -->
                    <x-appointment.review-confirm :isEdit="false" />

                </div>

                <!-- Right Hand: Sticky Summary Panel component (Desktop Only) -->
                <div class="lg:col-span-4 space-y-6 sticky top-8 hidden lg:block">
                    <x-appointment.summary-sidebar />
                </div>

            </div>
        </form>
    </div>

    <!-- Alpine JS App Script Implementation -->
    <script>
        function appointmentFlow() {
            return {
                // Form Data & State Bindings
                doctorId: @json(old('doctor_id', '')),
                selectedDate: @json(old('appointment_date', '')),
                selectedTime: @json(old('selected_time', '')),
                reason: @json(old('reason', '')),
                slots: [],
                loadingSlots: false,

                // Wizard Steps Control (auto switches to correct step on validation error redirect)
                step: {{ $errors->has('doctor_id') ? 1 : ($errors->has('reason') || $errors->has('appointment_date') ? 2 : ($errors->has('selected_time') ? 3 : 1)) }},

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

                    // If loading back from validation or old inputs redirect
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
                },

                // Action when calendar day is clicked
                selectDate(dateStr, isDisabled) {
                    if (isDisabled) return;
                    this.selectedDate = dateStr;
                    this.selectedTime = '';
                    this.slots = [];
                    this.fetchAvailableSlots();
                },

                // Retrieve slot list using fetch API
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
                        this.slots = await response.json();
                    } catch (e) {
                        console.error("Error fetching slots:", e);
                        this.slots = [];
                    } finally {
                        this.loadingSlots = false;
                    }
                },

                // Generate Calendar Grid Days Objects
                generateCalendar() {
                    const year = this.currentYear;
                    const month = this.currentMonth;
                    
                    // First day of target month (0 = Sun, 1 = Mon)
                    const firstDayIndex = new Date(year, month, 1).getDay();
                    
                    // Total days in target month
                    const totalDays = new Date(year, month + 1, 0).getDate();
                    
                    // Total days in previous month
                    const prevTotalDays = new Date(year, month, 0).getDate();
                    
                    const days = [];
                    
                    // Previous month filler days
                    for (let i = firstDayIndex - 1; i >= 0; i--) {
                        const d = prevTotalDays - i;
                        const prevMonth = month === 0 ? 11 : month - 1;
                        const prevYear = month === 0 ? year - 1 : year;
                        days.push({
                            dayNum: d,
                            dateStr: `${prevYear}-${String(prevMonth + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`,
                            isCurrentMonth: false,
                            isDisabled: true,
                            isToday: false
                        });
                    }
                    
                    // Current month days
                    const today = new Date();
                    today.setHours(0,0,0,0);
                    
                    for (let d = 1; d <= totalDays; d++) {
                        const dateObj = new Date(year, month, d);
                        dateObj.setHours(0,0,0,0);
                        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
                        
                        // Disable if date is in the past
                        const isPast = dateObj < today;
                        const isDisabled = isPast;
                        
                        days.push({
                            dayNum: d,
                            dateStr: dateStr,
                            isCurrentMonth: true,
                            isDisabled: isDisabled,
                            isToday: dateObj.getTime() === today.getTime()
                        });
                    }
                    
                    // Next month filler padding days to ensure complete grid of 42 slots
                    const remainingSlots = 42 - days.length;
                    for (let i = 1; i <= remainingSlots; i++) {
                        const nextMonth = month === 11 ? 0 : month + 1;
                        const nextYear = month === 11 ? year + 1 : year;
                        days.push({
                            dayNum: i,
                            dateStr: `${nextYear}-${String(nextMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`,
                            isCurrentMonth: false,
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
