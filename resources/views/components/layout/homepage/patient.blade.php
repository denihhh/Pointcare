@props(['upcomingAppointment' => null, 'pastAppointments' => collect()])

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    {{-- ═══════════════════════════════════════════════════════════════ --}}
    {{--  HEADER: Greeting + Quick Access CTA                            --}}
    {{-- ═══════════════════════════════════════════════════════════════ --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 space-y-4 md:space-y-0 pb-6 border-b border-gray-200">
        <div>
            <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Your Patient Dashboard</h1>
            <p class="text-slate-500 mt-1.5 text-base font-medium">Coordinate your clinical appointments, view medical footprint records, and check safety alerts.</p>
        </div>

        <div>
            <a href="/appointments/create" class="inline-flex items-center justify-center min-h-[44px] px-6 py-3.5 bg-rose-500 text-white text-sm font-bold rounded-2xl shadow-md hover:bg-rose-600 transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Book New Appointment
            </a>
        </div>
    </div>

    <!-- Your Next Visit Section (Full Width Hero) -->
    <section class="mb-10 animate__animated animate__fadeIn">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Your Next Visit</h2>
            <a href="/dashboard" class="text-sm font-semibold text-rose-500 hover:text-rose-600">View History &rarr;</a>
        </div>

        @if ($upcomingAppointment)
            <div class="relative overflow-hidden bg-white border-l-4 border-l-cyan-500 border border-slate-100 rounded-3xl shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:shadow-md transition-shadow">
                <div class="absolute top-0 right-0 w-32 h-32 -mr-8 -mt-8 bg-cyan-50 rounded-full opacity-40"></div>

                <div class="relative p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6">
                    <div class="shrink-0 w-24 h-24 bg-cyan-50/50 rounded-2xl flex flex-col items-center justify-center border border-cyan-100">
                        <span class="text-3xl font-black text-cyan-700">{{ $upcomingAppointment->appointment_time->format('d') }}</span>
                        <span class="text-sm font-bold text-cyan-600 uppercase tracking-widest">{{ $upcomingAppointment->appointment_time->format('M') }}</span>
                    </div>

                    <div class="flex-1 text-center sm:text-left">
                        <div class="flex items-center justify-center sm:justify-start space-x-2 mb-1">
                            <span class="px-2 py-0.5 rounded-md bg-green-50 text-green-700 border border-green-100/50 text-[10px] font-bold uppercase tracking-wider">Confirmed</span>
                            <span class="text-slate-400 text-sm">•</span>
                            <span class="text-slate-500 text-sm font-medium">{{ $upcomingAppointment->appointment_time->format('h:i A') }}</span>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800">Dr. {{ preg_replace('/^dr\.?\s+/i', '', $upcomingAppointment->doctor->name) }}</h3>
                        <p class="text-slate-500 font-medium mt-1 font-semibold">Consultation regarding: <span class="text-slate-700 font-normal">{{ Str::limit($upcomingAppointment->reason, 120) }}</span></p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] rounded-[1.75rem] p-8 text-center flex flex-col items-center justify-center">
                <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-350 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <p class="text-slate-450 font-bold text-sm">No upcoming appointments scheduled.</p>
                <p class="text-xs text-slate-400 mt-1 max-w-sm">Ready to coordinate with a doctor? Click the book button above to schedule a consultation.</p>
            </div>
        @endif
    </section>

    <!-- 2-Column Grid (Past History & Sidebar) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="space-y-8">
            <!-- Past Appointments Section -->
            <section>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-slate-800">Past Appointments</h2>
                    <span class="text-xs font-semibold text-slate-450">Recent History</span>
                </div>

                @if ($pastAppointments->isEmpty())
                    <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl p-8 text-center">
                        <p class="text-slate-400 font-medium italic">No past appointments recorded.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($pastAppointments as $appointment)
                            <div class="group bg-white border border-slate-100 rounded-2xl p-5 hover:shadow-md hover:border-slate-250 transition-all duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-center space-x-4">
                                    <div class="shrink-0 w-12 h-12 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-600 font-bold text-lg">
                                        {{ substr($appointment->doctor->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="text-base font-bold text-slate-800">Dr. {{ preg_replace('/^dr\.?\s+/i', '', $appointment->doctor->name) }}</h4>
                                        <p class="text-xs text-slate-500 font-medium mt-0.5">
                                            {{ $appointment->appointment_time->format('d M Y') }} at {{ $appointment->appointment_time->format('h:i A') }}
                                        </p>
                                        @if($appointment->reason)
                                            <p class="text-xs text-slate-450 italic mt-1 line-clamp-1">
                                                "{{ Str::limit($appointment->reason, 60) }}"
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center space-x-3 self-end sm:self-auto">
                                    @if ($appointment->status === 'completed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-600 border border-emerald-100">
                                            Completed
                                        </span>
                                        <a href="/appointments/{{ $appointment->id }}/record" class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-bold rounded-lg text-white bg-slate-900 hover:bg-slate-800 transition-all shadow-sm">
                                            View Record
                                        </a>
                                    @elseif ($appointment->status === 'cancelled')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-rose-50 text-rose-600 border border-rose-100">
                                            Cancelled
                                        </span>
                                    @elseif ($appointment->status === 'confirmed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-green-50 text-green-600 border border-green-100">
                                            Confirmed
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-600 border border-amber-100">
                                            Pending
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>

        <div class="space-y-8">
            <!-- Medical Safety Sheet Card -->
            <div class="bg-white rounded-[1.75rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden">
                <div class="px-6 pt-6 pb-2">
                    <div class="flex items-center justify-between mb-1">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-slate-800">Medical Safety Sheet</h2>
                                <p class="text-xs text-slate-400 font-medium">Critical safety profiles</p>
                            </div>
                        </div>
                        <span class="text-[9px] px-2 py-0.5 bg-rose-50 text-rose-600 rounded font-black uppercase tracking-wider">Vitals</span>
                    </div>
                </div>

                <div class="px-6 pb-6 pt-2 space-y-4">
                    <!-- Allergies -->
                    <div class="p-3.5 rounded-2xl bg-slate-50/50 border border-slate-100">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] text-slate-400 font-black uppercase tracking-wider">Known Allergies</span>
                            @if(auth()->user()->known_allergies)
                                <span class="text-[8px] bg-amber-100 text-amber-850 px-1.5 py-0.5 rounded font-black uppercase">Declared</span>
                            @else
                                <span class="text-[8px] bg-green-150/15 text-green-700 px-1.5 py-0.5 rounded font-black uppercase">None</span>
                            @endif
                        </div>
                        <p class="text-xs font-bold text-slate-800 mt-1.5 leading-relaxed">
                            {{ auth()->user()->known_allergies ?: 'No known drug or environmental allergies declared.' }}
                        </p>
                    </div>

                    <!-- Chronic Conditions -->
                    <div class="p-3.5 rounded-2xl bg-slate-50/50 border border-slate-100">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] text-slate-400 font-black uppercase tracking-wider">Chronic Conditions</span>
                            @if(auth()->user()->chronic_conditions)
                                <span class="text-[8px] bg-rose-100 text-rose-800 px-1.5 py-0.5 rounded font-black uppercase">Active</span>
                            @else
                                <span class="text-[8px] bg-slate-200/60 text-slate-600 px-1.5 py-0.5 rounded font-black uppercase">None</span>
                            @endif
                        </div>
                        <p class="text-xs font-bold text-slate-800 mt-1.5 leading-relaxed">
                            {{ auth()->user()->chronic_conditions ?: 'No ongoing chronic conditions declared.' }}
                        </p>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="p-3.5 rounded-2xl bg-slate-50/50 border border-slate-100">
                        <span class="text-[10px] text-slate-400 font-black uppercase tracking-wider block">Emergency Contact</span>
                        @if(auth()->user()->emergency_contact_name)
                            <div class="mt-1.5">
                                <div class="text-xs font-black text-slate-800">{{ auth()->user()->emergency_contact_name }}</div>
                                <div class="text-[11px] text-slate-500 font-bold mt-0.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    {{ auth()->user()->emergency_contact_phone }}
                                </div>
                            </div>
                        @else
                            <p class="text-xs font-bold text-slate-450 mt-1.5 italic">Emergency contact details not configured.</p>
                        @endif
                    </div>

                    <!-- Action button to edit profile -->
                    <a href="/profile" class="mt-2 w-full inline-flex items-center justify-center min-h-[44px] px-4 py-2.5 bg-slate-900 text-white text-xs font-black rounded-xl shadow-sm hover:bg-slate-800 transition-all uppercase tracking-widest">
                        Update Medical Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Clinic Operational & Contact Card (Full Width Footer) -->
    <div class="bg-white rounded-[1.75rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden mt-8">
        <div class="px-6 pt-6 pb-2 border-b border-slate-50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-cyan-50 flex items-center justify-center text-cyan-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-800">Clinic Operations & Support</h2>
                    <p class="text-xs text-slate-400 font-medium">Business hours and support contacts</p>
                </div>
            </div>
            @php
                $hour = (int) now('Asia/Kuala_Lumpur')->format('H');
                $day = now('Asia/Kuala_Lumpur')->format('N');
                $isOpen = ($day >= 1 && $day <= 5 && $hour >= 9 && $hour < 17) || ($day == 6 && $hour >= 9 && $hour < 13);
            @endphp
            @if($isOpen)
                <span class="text-[9px] bg-emerald-50 text-emerald-600 px-2 py-0.5 rounded font-black uppercase tracking-wider animate-pulse border border-emerald-100">Open Now</span>
            @else
                <span class="text-[9px] bg-slate-50 text-slate-400 px-2 py-0.5 rounded font-black uppercase tracking-wider border border-slate-100">Closed</span>
            @endif
        </div>

        <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 items-stretch">
            <!-- Column 1: Operating hours details -->
            <div class="space-y-3">
                <span class="text-[10px] text-slate-400 font-black uppercase tracking-wider block mb-1">Weekly Schedule</span>
                <div class="flex items-center justify-between py-2.5 px-3 rounded-xl bg-slate-50/80 border border-slate-100 text-xs">
                    <span class="font-bold text-slate-700">Mon - Fri</span>
                    <span class="font-extrabold text-slate-900">09:00 AM - 05:00 PM</span>
                </div>
                <div class="flex items-center justify-between py-2.5 px-3 rounded-xl bg-slate-50/80 border border-slate-100 text-xs">
                    <span class="font-bold text-slate-700">Saturday</span>
                    <span class="font-extrabold text-slate-900">09:00 AM - 01:00 PM</span>
                </div>
                <div class="flex items-center justify-between py-2.5 px-3 rounded-xl bg-slate-50/80 border border-slate-100 text-xs">
                    <span class="font-bold text-slate-505 text-slate-500">Sunday</span>
                    <span class="font-extrabold text-slate-400 italic">Off Duty</span>
                </div>
            </div>

            <!-- Column 2: Contact Hotline details -->
            <div class="space-y-3">
                <span class="text-[10px] text-slate-400 font-black uppercase tracking-wider block mb-1">Desk Helpline</span>
                <div class="space-y-2.5">
                    <div class="flex items-center gap-3 py-2 px-3 rounded-xl bg-slate-50/50 border border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-slate-450 border border-slate-100 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <div class="text-[9px] text-slate-450 font-black uppercase tracking-wider leading-none">Desk Hotline</div>
                            <div class="text-xs font-black text-slate-800 mt-1">+60 3-8000 1234</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 py-2 px-3 rounded-xl bg-slate-50/50 border border-slate-100">
                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-slate-450 border border-slate-100 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21.38 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-[9px] text-slate-450 font-black uppercase tracking-wider leading-none">Email Support</div>
                            <div class="text-xs font-black text-slate-800 mt-1 truncate">help@pointcare.test</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Column 3: Emergency Response -->
            <div class="flex flex-col justify-center">
                <span class="text-[10px] text-slate-400 font-black uppercase tracking-wider block mb-2">Emergency Response</span>
                <div class="p-3.5 bg-rose-50/70 border border-rose-100 rounded-2xl flex items-start space-x-2.5 text-rose-800 flex-1">
                    <svg class="w-4.5 h-4.5 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div>
                        <div class="text-[8px] font-black uppercase tracking-wider text-rose-600">24/7 Immediate Line</div>
                        <div class="text-xs font-black text-rose-900 mt-0.5">+60 3-8000 9999</div>
                        <p class="text-[10px] text-rose-600 font-bold mt-1 leading-relaxed">For life-threatening situations, dial the hotline immediately.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
