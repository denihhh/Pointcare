@props([
    'appointments'
])

<div class="hidden md:block bg-white border border-rose-100/60 rounded-[2rem] shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr
                    class="bg-slate-50/70 border-b border-slate-100 text-[10px] font-black uppercase tracking-widest text-slate-400">
                    <th class="py-4 px-6">Date & Time</th>
                    <th class="py-4 px-6">Attending Doctor</th>
                    <th class="py-4 px-6">Reason</th>
                    <th class="py-4 px-6 text-right">Record Details</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-slate-700 text-sm">
                @foreach($appointments as $index => $appointment)
                    <tr @click="selectedRecord = records[{{ $index }}]; modalOpen = true"
                        class="hover:bg-slate-50/40 hover:cursor-pointer transition duration-150"
                        x-show="!search || 
                                        '{{ strtolower($appointment->doctor->name) }}'.includes(search.toLowerCase()) || 
                                        '{{ strtolower($appointment->diagnosis ?? '') }}'.includes(search.toLowerCase())">

                        {{-- Date & Time --}}
                        <td class="py-5 px-6 whitespace-nowrap">
                            <p class="font-black text-slate-900 tracking-tight text-sm">
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('d M, Y') }}
                            </p>
                            <span
                                class="text-[10px] font-black text-slate-500 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded-md inline-block mt-1 uppercase tracking-wider">
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                            </span>
                        </td>

                        {{-- Attending Doctor --}}
                        <td class="py-5 px-6">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-rose-50 border border-rose-100 flex items-center justify-center text-primary font-black text-xs shrink-0">
                                    Dr
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 leading-tight text-sm">
                                        {{ $appointment->doctor->name }}</p>
                                    <span class="text-[10px] text-slate-400 font-semibold block mt-0.5">
                                        {{ $appointment->doctor->doctor->specialization ?? 'General Medicine' }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        {{-- Reason --}}
                        <td class="py-5 px-6">
                            <p class="font-semibold text-slate-700 text-xs truncate max-w-[200px]" title="{{ $appointment->reason }}">
                                {{ $appointment->reason ?? 'General Evaluation' }}
                            </p>
                        </td>

                        {{-- Record Details --}}
                        <td class="py-5 px-6 text-right whitespace-nowrap" @click.stop>
                            <button @click="selectedRecord = records[{{ $index }}]; modalOpen = true"
                                class="inline-flex items-center justify-center px-6 py-2.5 border border-slate-200 text-xs font-black rounded-xl text-slate-800 bg-white hover:bg-slate-50 transition shadow-xs h-[44px]">
                                View Record
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
