@props(['doctors'])
<x-layout>
    <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full mt-2">
        <a href="/dashboard"
           class="inline-flex items-center text-gray-500 hover:text-primary transition-colors font-medium group">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5 mr-1 transform group-hover:-translate-x-1 transition-transform"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back
        </a>
    </div>

    <div class="min-h-[75vh] flex flex-col justify-center items-center">

        <h1 class="mb-8 text-3xl font-bold text-center text-gray-800">Appointment Details</h1>
        <form action="/appointments" method="POST"
            class="w-full max-w-md p-8 rounded-xl shadow-sm border border-gray-500">
            @csrf

            <x-form.form-input label="Reason for Visit" name="reason" />

            <div class="mb-4">
                <label class="mb-2 label font-semibold">Select Doctor</label>
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
