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
                    <td class="py-4 px-3 align-middle">
                        <div class="flex items-center justify-between space-x-4">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium tracking-wider uppercase
            {{ $appointment->status === 'pending' ? 'bg-amber-50 text-amber-700 border border-amber-200' : '' }}
            {{ $appointment->status === 'confirmed' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : '' }}
            {{ $appointment->status === 'cancelled' ? 'bg-rose-50 text-rose-700 border border-rose-200' : '' }}">
                                <svg class="mr-1.5 h-2 w-2 {{ $appointment->status === 'pending' ? 'text-amber-400' : ($appointment->status === 'confirmed' ? 'text-emerald-400' : 'text-rose-400') }}"
                                    fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                {{ $appointment->status }}
                            </span>

                            @if ($role === 'patient' && $appointment->status === 'pending')
                                <div class="flex items-center space-x-3">
                                    <a href="/appointments/{{ $appointment->id }}/edit"
                                        class="text-blue-600 hover:text-blue-800 transition-colors p-1 hover:bg-blue-50 rounded"
                                        title="Edit Appointment">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>

                                    <form action="/appointments/{{ $appointment->id }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to cancel this appointment?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 transition-colors p-1 hover:bg-red-50 rounded"
                                            title="Cancel Appointment">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
