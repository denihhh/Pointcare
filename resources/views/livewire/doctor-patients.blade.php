<div>
    @if ($patients->isEmpty())
        <div class="py-20 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-slate-50 rounded-full mb-4">
                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">No patients found</h3>
            <p class="text-slate-400 text-sm mt-1">You do not have any patient consultations in your record
                history.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-y-3">
                <thead>
                    <tr class="text-slate-400 text-[10px] uppercase tracking-[0.2em] font-black">
                        <th class="pb-4 px-4">Patient Name</th>
                        <th class="pb-4 px-4">Contact Info</th>
                        <th class="pb-4 px-4 text-center">Consultations</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $patient)
                        <tr class="bg-white border border-slate-50 hover:bg-slate-50/50 transition duration-200 cursor-pointer group"
                            onclick="window.location='{{ route('doctor.patient.detail', $patient) }}'">
                            <td class="py-5 px-4 rounded-l-2xl border-y border-l border-slate-50">
                                <div class="flex items-center">
                                    <div
                                        class="h-9 w-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs mr-3 border border-slate-200">
                                        {{ substr($patient->name, 0, 1) }}
                                    </div>
                                    <a href="{{ route('doctor.patient.detail', $patient) }}"
                                        class="text-sm font-bold text-slate-700 group-hover:text-rose-600 transition duration-200">
                                        {{ $patient->name }}
                                    </a>
                                </div>
                            </td>
                            <td class="py-5 px-4 border-y border-slate-50">
                                <span class="text-sm font-semibold text-slate-500">{{ $patient->email }}</span>
                            </td>
                            <td
                                class="py-5 px-4 rounded-r-2xl border-y border-r border-slate-50 text-center font-bold text-slate-700">
                                <span class="bg-rose-50 text-rose-600 px-3 py-1 rounded-full text-xs font-black">
                                    {{ $patient->appointments_count }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        {{ $patients->links('livewire::tailwind') }}
    @endif
</div>
