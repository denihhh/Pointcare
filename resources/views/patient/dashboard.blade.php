<x-layout >
    
    <div class="mb-12">
        <x-return/>
        <div class="max-w-7xl mt-8 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Appointment Lists</h2>
                        <p class="text-sm text-gray-500">Manage your upcoming appointments</p>
                    </div>
                    <div class="bg-blue-50 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">
                        Today: {{ now()->format('d M Y') }}
                    </div>
                </div>
                @if($appointments->isEmpty())
                    <p class="text-gray-500 text-center italic mt-12">No appointments found. Book your first appointment now!</p>
                @else
                <x-table :appointments="$appointments" title="Appointment Details" role="patient" />
                @endif
                <div class="mt-2 flex flex-col items-end">
                    <a href="/appointments/create"
                        data-test="new-appointment-btn"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition
                                mt-4">
                        + New Appointment
                    </a>
                </div>
            </div>

        </div>

    </div>

</x-layout>
