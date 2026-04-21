@props([ 'appointment', 'doctors'])
<x-layout>
    <x-return/>
    <form action="/appointments/{{ $appointment->id }}" method="POST" class="max-w-md mx-auto">
        @csrf
        @method('PATCH') <x-form.form-input label="Reason for Visit" name="reason" :value="$appointment->reason" />

        <div class="mb-4">
            <label class="label text-sm font-medium">Select Doctor</label>
            <select name="doctor_id" class="select w-full border border-gray-300 p-2 rounded">
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                        Dr. {{ $doctor->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <x-form.datepicker label="Preferred Date & Time" name="appointment_time" :value="$appointment->appointment_time" />

        <button type="submit" class="btn btn-neutral mt-2 h-10 w-full shadow hover:shadow-lg transition">Update Appointment</button>
    </form>
</x-layout>
