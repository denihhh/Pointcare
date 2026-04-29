
<div class="overflow-x-auto">
    <table class="w-full text-left border-separate border-spacing-y-3">
        <thead>
            <tr class="text-slate-400 text-[10px] uppercase tracking-[0.2em] font-black">
                <th class="pb-4 px-4">{{ $role === 'doctor' ? 'Patient' : 'Doctor' }}</th>
                <th class="pb-4 px-4">Schedule</th>
                <th class="pb-4 px-4">Consultation Reason</th>
                <th class="pb-4 px-4 text-right">Status</th>
            </tr>
        </thead>
        @foreach ($appointments as $appointment)
        <tbody x-data="{ expanded: false }">
            <tr @click="expanded = !expanded"
                class="group bg-white hover:bg-slate-50/50 hover:cursor-pointer transition-all duration-200">

                <td class="py-5 px-4 first:rounded-l-2xl border-y border-l border-slate-50">
                    <div class="flex items-center">
                        <div
                            class="h-9 w-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs mr-3 border border-slate-200">
                            {{ substr($role === 'doctor' ? $appointment->patient->name : $appointment->doctor->name, 0, 1) }}
                        </div>
                        <span class="text-sm font-bold text-slate-700">
                            {{ $role === 'doctor' ? $appointment->patient->name : 'Dr. ' . $appointment->doctor->name }}
                        </span>
                    </div>
                </td>

                <td class="py-5 px-4 border-y border-slate-50">
                    <div class="flex flex-col">
                        <span
                            class="text-sm font-bold text-slate-600">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('d M Y') }}</span>
                        <span
                            class="text-[11px] text-slate-400 font-medium">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</span>
                    </div>
                </td>

                <td class="py-5 px-4 border-y border-slate-50">
                    <p class="text-sm text-slate-500 line-clamp-1 max-w-[150px]">{{ $appointment->reason }}</p>
                </td>

                <td class="py-5 px-4 last:rounded-r-2xl border-y border-r border-slate-50 text-right">
                    <div class="flex items-center justify-end space-x-3">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border
                        {{ $appointment->status === 'pending' ? 'bg-amber-50 text-amber-600 border-amber-100' : '' }}
                        {{ $appointment->status === 'confirmed' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : '' }}
                        {{ $appointment->status === 'cancelled' ? 'bg-rose-50 text-rose-600 border-rose-100' : '' }}
                        {{ $appointment->status === 'completed' ? 'bg-slate-100 text-slate-600 border-slate-200' : '' }}">
                            {{ $appointment->status }}
                        </span>
                        <svg class="w-4 h-4 text-slate-300 transition-transform duration-300"
                            :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </td>
            </tr>

            <tr x-show="expanded" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2">
                <td colspan="4" class="px-4 pb-4">
                    <div
                        class="bg-slate-50 rounded-2xl p-6 border border-slate-100 shadow-inner flex flex-col md:flex-row justify-between items-start md:items-center gap-4">

                        <div class="flex-1">
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Full
                                Appointment Reason</h4>
                            <p class="text-sm text-slate-600 leading-relaxed italic">"{{ $appointment->reason }}"</p>
                        </div>

                        <div class="flex items-center space-x-3 shrink-0">
                            @if ($role === 'doctor' && $appointment->status === 'pending')
                                <div class="flex items-center space-x-2">
                                    <form action="/appointments/{{ $appointment->id }}/status" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="confirmed">
                                        <button
                                            class="px-4 py-2 text-slate-800 hover:text-slate-700 bg-emerald-300 hover:bg-emerald-400 hover:cursor-pointer text-[10px] shadow-sm font-bold uppercase rounded-xl transition-all">
                                            Approve
                                        </button>
                                    </form>
                                    <form action="/appointments/{{ $appointment->id }}/status" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button
                                            class="p-2 bg-rose-500 text-white rounded-lg hover:bg-rose-600 shadow-sm transition-transform active:scale-90">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>

                                </div>
                            @endif
                            @if ($appointment->status === 'completed')
                                <a href="/appointments/{{ $appointment->id }}/record"
                                    class="flex items-center px-5 py-2.5 bg-rose-500 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-rose-600 transition-all shadow-md">
                                    <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    View Full Medical Record
                                </a>
                            @endif

                            @if ($role === 'doctor' && $appointment->status === 'confirmed')
                                <a href="/consultation/{{ $appointment->id }}"
                                    class="px-5 py-2.5 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-rose-500 transition-all shadow-md">
                                    Start Consultation
                                </a>
                            @endif

                            @if ($role === 'patient' && $appointment->status === 'pending')
                                <a href="/appointments/{{ $appointment->id }}/edit"
                                    class="px-4 py-2 text-slate-600 bg-white border border-slate-200 text-[10px] font-bold uppercase rounded-xl hover:bg-slate-50 transition-all">
                                    Edit Details
                                </a>
                                <form action="/appointments/{{ $appointment->id }}" method="POST"
                                        onsubmit="return confirm('Cancel this appointment?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
        @endforeach

    </table>
</div>

