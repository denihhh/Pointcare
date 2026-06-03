{{-- @props(['appointment', 'doctors'])
<x-layout>
    <x-return to="dashboard" />

    <div class="px-6 max-w-2xl mx-auto">
        <div class="mt-8 mb-10">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Edit Appointment</h1>
            <p class="text-slate-500">Adjust the details below to secure your consultation slot.</p>
        </div>

        <form action="/appointments/{{ $appointment->id }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            <x-form.field label="Reason for Visit" name="reason" :value="$appointment->reason" />

            <div class="space-y-1.5 w-full mb-5">
                <label class="block text-sm font-black text-slate-700 tracking-tight ml-1">Select Doctor</label>
                <select name="doctor_id"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 focus:border-rose-500 focus:ring-4 focus:ring-rose-100 outline-none transition-all duration-200">
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}"
                            {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                            Dr. {{ $doctor->name }}
                        </option>
                    @endforeach
                </select>
                @error('doctor_id')
                    <p class="text-red-500 text-xs mt-1 ml-1 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <x-form.field label="Preferred Date & Time" name="appointment_time" type="datetime-local"
                :value="$appointment->appointment_time" />

            <button type="submit"
                class="w-full py-4 px-4 rounded-2xl shadow-lg shadow-rose-200 text-sm font-black text-white bg-rose-500 hover:bg-rose-600 transition-all hover:-translate-y-0.5 active:translate-y-0">
            Update Appointment
            </button>
        </form>
    </div>
</x-layout> --}}

@props(['appointment', 'doctors'])

<x-layout title="Edit Appointment">
    <x-return to="dashboard" />

    <div class="px-6 max-w-2xl mx-auto"
         x-data="appointmentFlow()"
         x-init="init()">

        <div class="mt-8 mb-10">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Edit Appointment</h1>
            <p class="text-slate-500">Adjust the details below to reschedule your session.</p>
        </div>

        <form action="/appointments/{{ $appointment->id }}" method="POST" class="space-y-8">
            @csrf
            @method('PATCH')

            <div class="space-y-1.5">
                <label class="block text-sm font-black text-slate-700 tracking-tight ml-1">1. Select Doctor</label>
                <select name="doctor_id" x-model="doctorId" @change="resetSelection()"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 outline-none focus:border-rose-500 focus:ring-4 focus:ring-rose-100 transition-all">
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}">Dr. {{ $doctor->name }}</option>
                    @endforeach
                </select>
                @error('doctor_id') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1.5" x-cloak x-show="doctorId" x-transition>
                <x-form.field label="2. Reason for Visit" name="reason"
                    :value="old('reason', $appointment->reason)" placeholder="Briefly describe your symptoms" />
            </div>

            <div class="space-y-1.5" x-cloak x-show="doctorId" x-transition>
                <label class="block text-sm font-black text-slate-700 tracking-tight ml-1">3. Select Date</label>
                <input type="date" name="appointment_date" x-model="selectedDate" @change="fetchAvailableSlots()"
                    min="{{ date('Y-m-d') }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 outline-none focus:border-rose-500 focus:ring-4 focus:ring-rose-100">
                @error('appointment_date') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-3" x-cloak x-show="slots.length > 0 && selectedDate" x-transition>
                <label class="block text-sm font-black text-slate-700 tracking-tight ml-1">4. Select an available time</label>

                <input type="hidden" name="selected_time" x-model="selectedTime">
                <input type="hidden" name="appointment_time" :value="selectedTime ? selectedDate + ' ' + selectedTime : ''">

                <div class="grid grid-cols-3 gap-3">
                    <template x-for="slot in slots" :key="slot">
                        <button type="button"
                            @click="selectedTime = slot"
                            :class="selectedTime === slot ? 'bg-slate-900 text-white shadow-lg scale-105' : 'bg-white border border-slate-200 text-slate-600 hover:border-rose-300'"
                            class="py-3 rounded-xl text-sm font-bold transition-all duration-200"
                            x-text="formatTime(slot)">
                        </button>
                    </template>
                </div>
                @error('selected_time') <p class="text-red-500 text-xs mt-1 font-bold">Please select a timeslot.</p> @enderror
            </div>

            <button type="submit" x-show="selectedTime" x-cloak x-transition
                class="w-full py-4 rounded-2xl shadow-lg shadow-rose-200 text-sm font-black text-white bg-rose-500 hover:bg-rose-600 transition-all hover:-translate-y-0.5">
                Update Appointment
            </button>
        </form>
    </div>

    <script>
        function appointmentFlow() {
            return {
                // Initialize with Old Data (if validation failed) OR Existing Data (from DB)
                doctorId: @json(old('doctor_id', $appointment->doctor_id)),
                selectedDate: @json(old('appointment_date', \Carbon\Carbon::parse($appointment->appointment_time)->format('Y-m-d'))),
                selectedTime: @json(old('selected_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i'))),
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
                        const response = await fetch(`/api/available-slots?doctor_id=${this.doctorId}&date=${this.selectedDate}`);
                        let data = await response.json();

                        // SPECIAL EDIT LOGIC:
                        // If the doctor and date match the ORIGINAL appointment,
                        // we must add the current booked time back into the list
                        // so it shows up as an option to keep.
                        const originalDate = @json(\Carbon\Carbon::parse($appointment->appointment_time)->format('Y-m-d'));
                        const originalTime = @json(\Carbon\Carbon::parse($appointment->appointment_time)->format('H:i'));
                        const originalDoctor = @json($appointment->doctor_id);

                        if (this.doctorId == originalDoctor && this.selectedDate == originalDate) {
                            if (!data.includes(originalTime)) {
                                data.push(originalTime);
                                data.sort(); // Keep them in order
                            }
                        }

                        this.slots = data;
                    } catch (e) {
                        console.error("Error fetching slots");
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
