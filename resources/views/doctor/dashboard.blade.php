<x-layout >
    <div class="mb-12">
        <x-return/>
        <div class="max-w-7xl mt-8 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Doctor Queue</h2>
                        <p class="text-sm text-gray-500">Manage your upcoming patient consultations</p>
                    </div>
                    <div class="bg-blue-50 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">
                        Today: {{ now()->format('d M Y') }}
                    </div>
                </div>
                @if($appointments->isEmpty())
                    <p class="text-gray-500 text-center italic my-10">No scheduled appointments for now.</p>
                @else
                <x-table :appointments="$appointments" title="Patient Details" role="doctor" />
                @endif
            </div>
        </div>
    </div>
</x-layout>
