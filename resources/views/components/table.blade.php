<table class="w-full text-left border-collapse">
    <thead>
        <tr class="border-b-2 border-gray-100 text-gray-600 font-semibold">
            <th class="py-4 px-2">{{ $role === 'doctor' ? 'Patient Name' : 'Doctor Name' }}</th>
            <th class="py-4 px-2">Date & Time</th>
            <th class="py-4 px-2">Reason</th>
            @if ($role === 'patient')
                <th class="py-4 px-2">Status</th>
            @endif
            @if ($role === 'doctor')
                <th class="py-4 px-2">Actions</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($appointments as $appointment)
            <tr class="border-b border-gray-50">
                <td class="py-4 px-2 text-gray-600 font-medium">
                    {{ $role === 'doctor' ? $appointment->patient->name : 'Dr. ' . $appointment->doctor->name }}
                </td>
                <td class="py-4 px-2 text-gray-600">
                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('d M, h:i A') }}
                </td>
                <td class="py-4 px-2 text-gray-600">{{ $appointment->reason }}</td>

                @if ($role === 'doctor' && $appointment->status === 'pending')
                    <td class="py-4 px-2 flex space-x-2">
                        <form action="/appointments/{{ $appointment->id }}/status" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="confirmed">
                            <button
                                class="text-xs bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">Confirm</button>
                        </form>

                        <form action="/appointments/{{ $appointment->id }}/status" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button
                                class="text-xs bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Cancel</button>
                        </form>
                    </td>
                @else
                <td class="py-4 px-2 flex space-x-2">
                    <span
                        class="px-3 py-1 rounded-full text-xs font-bold uppercase
                                            {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                            {{ $appointment->status === 'confirmed' ? 'bg-green-100 text-green-700' : '' }}
                                            {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ $appointment->status }}
                    </span>
                </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>


