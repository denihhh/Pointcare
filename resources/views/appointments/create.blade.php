<x-layout title="Book Appointment">
    <x-return to="dashboard"/>

    <div class="px-4 sm:px-6 max-w-2xl mx-auto pb-10"
         x-data="appointmentFlow()"
         x-init="init()">

        <div class="mt-8 mb-10 text-center sm:text-left">
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">New Appointment</h1>
            <p class="text-slate-500 text-sm sm:text-base">Follow the steps to secure your slot.</p>
        </div>

        <form action="/appointments" method="POST" class="space-y-8">
            @csrf

            <div class="space-y-1.5">
                <label class="block text-sm font-black text-slate-700 tracking-tight ml-1">1. Select Doctor</label>
                <select name="doctor_id" x-model="doctorId" @change="resetSelection()"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 outline-none focus:border-rose-500 focus:ring-4 focus:ring-rose-100 transition-all text-sm sm:text-base">
                    <option value="">-- Choose a physician --</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}">Dr. {{ preg_replace('/^dr\.?\s+/i', '', $doctor->name) }}</option>
                    @endforeach
                </select>
                @error('doctor_id') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1.5" x-show="doctorId" x-cloak x-transition>
                <x-form.field label="2. Reason for Visit" name="reason" :value="old('reason')" placeholder="Briefly describe your symptoms" />
            </div>

            <div class="space-y-1.5" x-show="doctorId" x-cloak x-transition>
                <label class="block text-sm font-black text-slate-700 tracking-tight ml-1">3. Select Date</label>
                <input type="date" name="appointment_date" x-model="selectedDate" @change="fetchAvailableSlots()" min="{{ date('Y-m-d') }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 outline-none focus:border-rose-500 focus:ring-4 focus:ring-rose-100 text-sm sm:text-base">
                @error('appointment_date') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-3" x-show="slots.length > 0 && selectedDate" x-cloak x-transition>
                <label class="block text-sm font-black text-slate-700 tracking-tight ml-1">4. Select an available time</label>

                <input type="hidden" name="selected_time" x-model="selectedTime">
                <input type="hidden" name="appointment_time" :value="selectedDate + ' ' + selectedTime">

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <template x-for="slot in slots" :key="slot">
                        <button type="button"
                            @click="selectedTime = slot"
                            :class="selectedTime === slot ? 'bg-slate-900 text-white shadow-lg scale-105' : 'bg-white border border-slate-200 text-slate-600 hover:border-rose-300'"
                            class="py-3 rounded-xl text-xs sm:text-sm font-bold transition-all duration-200"
                            x-text="formatTime(slot)">
                        </button>
                    </template>
                </div>
                @error('selected_time') <p class="text-red-500 text-xs mt-1 font-bold">Please select a timeslot.</p> @enderror
            </div>

            <div x-show="selectedDate && slots.length === 0 && doctorId" x-cloak class="p-4 bg-amber-50 text-amber-700 rounded-xl text-xs sm:text-sm border border-amber-100 text-center sm:text-left">
                Fetching availability or no slots available for this date...
            </div>

            <button type="submit" x-show="selectedTime" x-cloak x-transition
                class="w-full py-4 rounded-2xl shadow-lg shadow-rose-200 text-sm font-black text-white bg-rose-500 hover:bg-rose-600 transition-all hover:-translate-y-0.5 active:scale-95">
                Confirm Booking
            </button>
        </form>
    </div>

    <script>
        // Your logic remains exactly the same
        function appointmentFlow() {
            return {
                doctorId: @json(old('doctor_id', '')),
                selectedDate: @json(old('appointment_date', '')),
                selectedTime: @json(old('selected_time', '')),
                slots: [],

                init() {
                    if (this.doctorId && this.selectedDate) {
                        this.fetchAvailableSlots();
                    }
                },

                resetSelection() {
                    this.selectedDate = '';
                    this.selectedTime = '';
                    this.slots = [];
                },

                async fetchAvailableSlots() {
                    if (!this.doctorId || !this.selectedDate) return;

                    try {
                        const params = new URLSearchParams({
                            doctor_id: this.doctorId,
                            date: this.selectedDate
                        });
                        const response = await fetch(`/api/available-slots?${params}`);
                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}`);
                        }
                        this.slots = await response.json();
                    } catch (e) {
                        console.error("Error fetching slots:", e);
                        this.slots = [];
                    }
                },

                formatTime(time) {
                    const [hour, minute] = time.split(':');
                    const h = hour % 12 || 12;
                    const ampm = hour >= 12 ? 'PM' : 'AM';
                    return `${h}:${minute} ${ampm}`;
                }
            }
        }
    </script>
</x-layout>
