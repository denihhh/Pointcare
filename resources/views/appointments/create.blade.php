@props(['doctors'])
<x-layout>
    <form action="/appointments" method="POST" class="max-w-md mx-auto">
        @csrf
        <x-form.form-input label="Reason for Visit" name="reason" />

        <div class="mb-4">
            <label class="label">Select Doctor</label>
            <select name="doctor_id" class="select w-full border border-gray-300 p-2 rounded">
                @foreach ($doctors as $doctor)
                    <option class="bg-gray-500" value="{{ $doctor->id }}">Dr. {{ $doctor->name }}</option>
                @endforeach
            </select>
        </div>

        <x-form.datepicker label="Preferred Date & Time" name="appointment_time" />
        <button type="submit" class="btn btn-neutral mt-2 h-10 w-full shadow hover:shadow-lg transition">Book
            Appointment</button>

    </form>
</x-layout>
