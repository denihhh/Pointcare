<x-layout title="{{ $patient->name }} — Consultations">
    <x-return />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">

        {{-- Header Section --}}
        <div class="mt-8 mb-10">
            <div class="flex items-center space-x-3 mb-2">
                <a href="{{ route('doctor.patients') }}"
                   class="inline-flex items-center text-slate-400 hover:text-rose-500 transition text-xs font-bold uppercase tracking-widest">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Patients
                </a>
            </div>
            <div class="flex items-center space-x-4 mt-3">
                <div class="h-14 w-14 rounded-full bg-gradient-to-br from-rose-100 to-rose-200 flex items-center justify-center text-rose-600 font-black text-xl border-2 border-white shadow-md">
                    {{ substr($patient->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight">{{ $patient->name }}</h1>
                    <p class="text-slate-500 font-medium mt-0.5">{{ $patient->email }}</p>
                </div>
            </div>
        </div>

        {{-- Summary Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400 font-black mb-1">Total Consultations</p>
                <p class="text-3xl font-black text-slate-900">{{ $appointments->total() }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400 font-black mb-1">Completed</p>
                <p class="text-3xl font-black text-emerald-600">
                    {{ $appointments->getCollection()->where('status', 'completed')->count() }}
                </p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400 font-black mb-1">Upcoming</p>
                <p class="text-3xl font-black text-amber-600">
                    {{ $appointments->getCollection()->whereIn('status', ['approved', 'pending'])->count() }}
                </p>
            </div>
        </div>

        {{-- Consultation Timeline --}}
        <div class="bg-white shadow-[0_20px_50px_rgba(0,0,0,0.03)] rounded-[2.5rem] border border-slate-100 overflow-hidden">
            <div class="p-6 sm:p-10">
                <h2 class="text-lg font-black text-slate-800 mb-6">Consultation History</h2>

                @if ($appointments->isEmpty())
                    <div class="py-20 text-center">
                        <h3 class="text-lg font-bold text-slate-800">No consultations found</h3>
                        <p class="text-slate-400 text-sm mt-1">This patient has no consultations with you.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($appointments as $appointment)
                            <div class="border border-slate-100 rounded-2xl p-6 hover:bg-slate-50/50 transition duration-200">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-10 w-10 rounded-xl flex items-center justify-center
                                            @if($appointment->status === 'completed') bg-emerald-50 text-emerald-600
                                            @elseif($appointment->status === 'approved') bg-blue-50 text-blue-600
                                            @elseif($appointment->status === 'pending') bg-amber-50 text-amber-600
                                            @elseif($appointment->status === 'cancelled' || $appointment->status === 'rejected') bg-red-50 text-red-500
                                            @else bg-slate-50 text-slate-500
                                            @endif">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($appointment->status === 'completed')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                @elseif($appointment->status === 'cancelled' || $appointment->status === 'rejected')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                @endif
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800">
                                                {{ $appointment->appointment_time->format('l, d M Y') }}
                                            </p>
                                            <p class="text-xs text-slate-400 font-medium">
                                                {{ $appointment->appointment_time->format('h:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest w-fit
                                        @if($appointment->status === 'completed') bg-emerald-50 text-emerald-600
                                        @elseif($appointment->status === 'approved') bg-blue-50 text-blue-600
                                        @elseif($appointment->status === 'pending') bg-amber-50 text-amber-600
                                        @elseif($appointment->status === 'cancelled' || $appointment->status === 'rejected') bg-red-50 text-red-500
                                        @else bg-slate-50 text-slate-500
                                        @endif">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>

                                {{-- Reason --}}
                                @if($appointment->reason)
                                    <div class="mb-3">
                                        <p class="text-[10px] uppercase tracking-[0.15em] text-slate-400 font-black mb-1">Reason</p>
                                        <p class="text-sm text-slate-600 font-medium">{{ $appointment->reason }}</p>
                                    </div>
                                @endif

                                {{-- Symptoms --}}
                                @if($appointment->symptoms)
                                    <div class="mb-3">
                                        <p class="text-[10px] uppercase tracking-[0.15em] text-slate-400 font-black mb-1">Symptoms</p>
                                        <p class="text-sm text-slate-600 font-medium">{{ $appointment->symptoms }}</p>
                                    </div>
                                @endif

                                {{-- Diagnosis & Prescription (only if completed) --}}
                                @if($appointment->status === 'completed')
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-3 pt-3 border-t border-slate-100">
                                        @if($appointment->diagnosis)
                                            <div>
                                                <p class="text-[10px] uppercase tracking-[0.15em] text-slate-400 font-black mb-1">Diagnosis</p>
                                                <p class="text-sm text-slate-700 font-semibold">{{ $appointment->diagnosis }}</p>
                                            </div>
                                        @endif
                                        @if($appointment->prescription)
                                            <div>
                                                <p class="text-[10px] uppercase tracking-[0.15em] text-slate-400 font-black mb-1">Prescription</p>
                                                <p class="text-sm text-slate-700 font-semibold">{{ $appointment->prescription }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                {{-- View Full Record Link for completed appointments --}}
                                @if($appointment->status === 'completed')
                                    <div class="mt-4">
                                        <a href="{{ route('appointments.record', $appointment) }}"
                                           class="inline-flex items-center text-xs font-bold text-rose-500 hover:text-rose-700 transition">
                                            View Full Record
                                            <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if ($appointments->hasPages())
                        <div class="mt-8 flex justify-center">
                            {{ $appointments->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>

    </div>
</x-layout>
