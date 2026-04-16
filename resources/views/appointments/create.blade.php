@props(['doctors'])
<x-layout>
    <x-return/>

    <div class="min-h-[75vh] flex flex-col justify-center items-center">

        <h1 class="mb-8 text-3xl font-bold text-center text-gray-800">Appointment Details</h1>
        <form action="/appointments" method="POST"
            class="w-full max-w-md p-8 rounded-xl shadow-sm border border-gray-500">
            @csrf

            <x-form.form-input label="Reason for Visit" name="reason" />

            <div class="mb-4">
                <label class=" label font-semibold">Select Doctor</label>
                <select name="doctor_id" class="select w-full border border-gray-500 p-2 rounded">
                    @foreach ($doctors as $doctor)
                        <option class="bg-gray-500" value="{{ $doctor->id }}">Dr. {{ $doctor->name }}</option>
                    @endforeach
                </select>
            </div>

            <x-form.datepicker label="Preferred Date & Time" name="appointment_time" />
            <button type="submit" class="btn btn-neutral mt-2 h-10 w-full shadow hover:shadow-lg transition">Book
                Appointment</button>

        </form>
    </div>
</x-layout>
