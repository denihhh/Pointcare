@props([
    'appointments'
])

<div class="md:hidden space-y-4">
    @foreach($appointments as $index => $appointment)
        <div @click="selectedRecord = records[{{ $index }}]; modalOpen = true"
            class="bg-white border border-slate-100 rounded-2xl p-5 shadow-xs hover:shadow-md transition duration-150 hover:cursor-pointer relative overflow-hidden flex flex-col gap-4"
            x-show="!search || 
                             '{{ strtolower($appointment->doctor->name) }}'.includes(search.toLowerCase()) || 
                             '{{ strtolower($appointment->diagnosis ?? '') }}'.includes(search.toLowerCase())">

            {{-- Top Row: Date/Time and Reason --}}
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="font-black text-slate-900 tracking-tight text-sm">
                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('d M, Y') }}
                    </p>
                    <span
                        class="text-[9px] font-black text-slate-500 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded inline-block mt-0.5 uppercase tracking-wider">
                        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                    </span>
                </div>

                {{-- Reason text display --}}
                <span class="text-[10px] text-slate-400 font-bold truncate max-w-[180px] text-right" title="{{ $appointment->reason }}">
                    {{ $appointment->reason ?? 'General Evaluation' }}
                </span>
            </div>

            {{-- Doctor Profile Stack --}}
            <div class="flex items-center gap-3 border-t border-slate-50 pt-3">
                <div
                    class="w-9 h-9 rounded-lg bg-rose-50 border border-rose-100 flex items-center justify-center text-primary font-black text-xs shrink-0">
                    Dr
                </div>
                <div>
                    <p class="font-bold text-slate-900 leading-tight text-sm">{{ $appointment->doctor->name }}</p>
                    <span class="text-[10px] text-slate-400 font-semibold block mt-0.5">
                        {{ $appointment->doctor->doctor->specialization ?? 'General Medicine' }}
                    </span>
                </div>
            </div>

            {{-- Primary Diagnosis & Actions --}}
            <div class="border-t border-slate-50 pt-3 flex items-center justify-between">
                <div class="min-w-0 flex-1 pr-4">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Diagnosis</p>
                    <p class="font-bold text-slate-800 text-xs truncate mt-0.5">
                        {{ $appointment->diagnosis ?? 'Routine Clinical Evaluation' }}
                    </p>
                </div>
                <button
                    class="inline-flex items-center justify-center px-4 py-2 border border-slate-200 text-xs font-black rounded-lg text-slate-800 bg-white hover:bg-slate-50 transition shadow-xs h-[44px] min-w-[100px] shrink-0"
                    @click.stop="selectedRecord = records[{{ $index }}]; modalOpen = true">
                    View Record
                </button>
            </div>
        </div>
    @endforeach
</div>
