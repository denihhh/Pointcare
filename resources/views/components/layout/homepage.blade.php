@props([
    'upcomingAppointment' => null, 
    'todayCount' => 0, 
    'pendingCount' => 0, 
    'pastAppointments' => collect(), 
    'todayAppointments' => collect(),
    'patientCount' => 0,
    'doctorCount' => 0,
    'adminCount' => 0,
    'appointmentCount' => 0,
    'systemMetrics' => [],
    'recentUsers' => collect()
])

<x-animation>
    @if (auth()->user()->role === 'patient')
        <div class=" max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 space-y-4 md:space-y-0 pb-6 border-b border-gray-300">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Hello, {{ Str::before(auth()->user()->name, ' ') }}
                    </h1>
                    <p class="text-slate-500 mt-1">Welcome back to PointCare. Here is your health overview.</p>
                </div>

                <a href="/appointments/create"
                    class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-bold rounded-xl shadow-sm text-white bg-primary hover:bg-rose-600 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Book New Appointment
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">

                    <section>
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-bold text-slate-800">Your Next Visit</h2>
                            <a href="/dashboard" class="text-sm font-semibold text-rose-500 hover:text-rose-600">View
                                History &rarr;</a>
                        </div>

                        @if ($upcomingAppointment)
                            <div
                                class="relative overflow-hidden bg-white border border-slate-200 rounded-3xl shadow-sm hover:shadow-md transition-shadow">
                                <div
                                    class="absolute top-0 right-0 w-32 h-32 -mr-8 -mt-8 bg-cyan-100 rounded-full opacity-50">
                                </div>

                                <div
                                    class="relative p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6">
                                    <div
                                        class="shrink-0 w-24 h-24 bg-cyan-50 rounded-2xl flex flex-col items-center justify-center border border-cyan-100">
                                        <span
                                            class="text-3xl font-black text-cyan-700">{{ $upcomingAppointment->appointment_time->format('d') }}</span>
                                        <span
                                            class="text-sm font-bold text-cyan-600 uppercase tracking-widest">{{ $upcomingAppointment->appointment_time->format('M') }}</span>
                                    </div>

                                    <div class="flex-1 text-center sm:text-left">
                                        <div class="flex items-center justify-center sm:justify-start space-x-2 mb-1">
                                            <span
                                                class="px-2 py-0.5 rounded-md bg-green-100 text-green-700 text-[10px] font-bold uppercase tracking-wider">Confirmed</span>
                                            <span class="text-slate-400 text-sm">•</span>
                                            <span
                                                class="text-slate-500 text-sm font-medium">{{ $upcomingAppointment->appointment_time->format('h:i A') }}</span>
                                        </div>
                                        <h3 class="text-2xl font-bold text-slate-800">Dr.
                                            {{ preg_replace('/^dr\.?\s+/i', '', $upcomingAppointment->doctor->name) }}</h3>
                                        <p class="text-slate-500 font-medium mt-1">Consultation regarding: <span
                                                class="text-slate-700">{{ Str::limit($upcomingAppointment->reason, 50) }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div
                                class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl p-12 text-center">
                                <p class="text-slate-400 font-medium italic">No upcoming appointments scheduled.</p>
                            </div>
                        @endif
                    </section>

                    {{-- <section>
                        <h2 class="text-xl font-bold text-slate-800 mb-6">Our Specializations</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            @foreach ([['name' => 'Paediatric', 'icon' => '👶', 'color' => 'rose'], ['name' => 'Physio', 'icon' => '🧘', 'color' => 'blue'], ['name' => 'Urology', 'icon' => '🧬', 'color' => 'amber'], ['name' => 'Dental', 'icon' => '🦷', 'color' => 'cyan']] as $cat)
                                <div
                                    class="group bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:border-{{ $cat['color'] }}-300 hover:shadow-md transition-all cursor-pointer text-center">
                                    <span
                                        class="text-4xl mb-3 block group-hover:scale-110 transition-transform">{{ $cat['icon'] }}</span>
                                    <p class="text-xs font-bold text-slate-700 uppercase tracking-widest">
                                        {{ $cat['name'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section> --}}

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
                    <section class="bg-slate-900 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden">
                        <div class="relative z-10">
                            <h3 class="text-lg font-bold mb-2">Health Tip of the Day</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">Remember to stay hydrated! Aim for at
                                least 8
                                glasses of water a day to maintain optimal kidney function.</p>
                            <button
                                class="mt-6 text-sm font-bold text-rose-400 hover:text-rose-300 transition-colors">Read
                                More &rarr;</button>
                        </div>
                        <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-rose-500 rounded-full opacity-20"></div>
                    </section>

                    <div class="bg-white border border-slate-200 rounded-3xl p-6">
                        <h3 class="font-bold text-slate-800 mb-4">Quick Links</h3>
                        <ul class="space-y-3">
                            <li><a href="#"
                                    class="text-slate-600 hover:text-rose-500 text-sm flex items-center"><span
                                        class="w-2 h-2 bg-rose-500 rounded-full mr-3"></span>Medical Records</a></li>
                            <li><a href="#"
                                    class="text-slate-600 hover:text-rose-500 text-sm flex items-center"><span
                                        class="w-2 h-2 bg-slate-300 rounded-full mr-3"></span>Prescriptions</a></li>
                            <li><a href="#"
                                    class="text-slate-600 hover:text-rose-500 text-sm flex items-center"><span
                                        class="w-2 h-2 bg-slate-300 rounded-full mr-3"></span>Billing History</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @elseif (auth()->user()->role === 'doctor')
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ═══════════════════════════════════════════════════════════════ --}}
            {{--  HEADER: Greeting + Date Badge + Primary CTA                  --}}
            {{-- ═══════════════════════════════════════════════════════════════ --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 pb-6 border-b border-slate-100">
                <div>
                    <div class="flex items-center space-x-3 mb-2">
                        <span
                            class="bg-rose-100 text-rose-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">
                            Clinical Desk
                        </span>
                        <span class="text-slate-400 text-xs font-medium">{{ now()->format('l, d F Y') }}</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Welcome, Dr. {{ ucfirst(explode(' ', auth()->user()->name)[1] ?? '') }}</h1>
                    <p class="text-slate-500 mt-1.5 text-base font-medium">
                        You have
                        <span class="text-slate-900 font-bold">
                            {{ $todayCount }} {{ Str::plural('consultation', $todayCount) }}
                        </span>
                        scheduled for today.
                    </p>
                </div>

                <div class="mt-6 md:mt-0 flex items-center gap-3">
                    <a href="/dashboard"
                        class="inline-flex items-center justify-center min-h-[44px] px-6 py-3 border border-slate-200 text-sm font-bold rounded-2xl shadow-sm text-slate-700 bg-white hover:bg-slate-50 hover:border-slate-300 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                        <svg class="w-5 h-5 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Manage Appointments
                    </a>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════════════════ --}}
            {{--  METRICS RIBBON: Borderless KPI Cards                          --}}
            {{-- ═══════════════════════════════════════════════════════════════ --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-8">

                {{-- KPI 1: Today's Consultations --}}
                <div class="group relative overflow-hidden bg-white rounded-2xl p-5 sm:p-6 transition-all duration-300 hover:shadow-lg hover:shadow-rose-100/40 border border-transparent hover:border-rose-100">
                    <div class="absolute top-0 right-0 w-24 h-24 -mr-6 -mt-6 bg-gradient-to-br from-rose-100 to-rose-50 rounded-full opacity-0 group-hover:opacity-60 transition-opacity duration-500"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Today's Consultations</p>
                            <div class="w-9 h-9 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-3xl font-black text-slate-900">{{ $todayCount }}</h3>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Confirmed sessions</p>
                    </div>
                </div>

                {{-- KPI 2: Pending Approvals --}}
                <div class="group relative overflow-hidden bg-white rounded-2xl p-5 sm:p-6 transition-all duration-300 hover:shadow-lg hover:shadow-amber-100/40 border border-transparent hover:border-amber-100">
                    <div class="absolute top-0 right-0 w-24 h-24 -mr-6 -mt-6 bg-gradient-to-br from-amber-100 to-amber-50 rounded-full opacity-0 group-hover:opacity-60 transition-opacity duration-500"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest">Pending Approvals</p>
                            <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-3xl font-black text-slate-900">{{ $pendingCount }}</h3>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Awaiting your review</p>
                    </div>
                </div>

                {{-- KPI 3: Completed Ledgers --}}
                <div class="group relative overflow-hidden bg-white rounded-2xl p-5 sm:p-6 transition-all duration-300 hover:shadow-lg hover:shadow-emerald-100/40 border border-transparent hover:border-emerald-100">
                    <div class="absolute top-0 right-0 w-24 h-24 -mr-6 -mt-6 bg-gradient-to-br from-emerald-100 to-emerald-50 rounded-full opacity-0 group-hover:opacity-60 transition-opacity duration-500"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Completed Ledgers</p>
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-3xl font-black text-slate-900">{{ $todayAppointments->where('status', 'completed')->count() }}</h3>
                        <p class="text-xs text-slate-400 font-semibold mt-1">Finalized today</p>
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════════════════ --}}
            {{--  MAIN GRID: Active Queue (Left) + Quick Actions (Right)        --}}
            {{-- ═══════════════════════════════════════════════════════════════ --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">

                {{-- ─────────────────────────────────────────────────────────── --}}
                {{--  ACTIVE QUEUE TABLE                                        --}}
                {{-- ─────────────────────────────────────────────────────────── --}}
                <div class="lg:col-span-2">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">Active Queue</h2>
                            <p class="text-xs text-slate-400 font-medium mt-0.5">Today's booked sessions</p>
                        </div>
                        <a href="/dashboard"
                            class="inline-flex items-center min-h-[44px] text-sm font-semibold text-rose-500 hover:text-rose-600 transition-colors">
                            Full Schedule
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>

                    @if ($todayAppointments->isNotEmpty())
                        {{-- Desktop Table View --}}
                        <div class="hidden sm:block bg-white rounded-[1.75rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-slate-100">
                                        <th class="text-left px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Patient Profile</th>
                                        <th class="text-left px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Appt Time</th>
                                        <th class="text-left px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Reason for Visit</th>
                                        <th class="text-left px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach ($todayAppointments as $appointment)
                                        <tr class="group hover:bg-rose-50/30 transition-colors duration-200">
                                            {{-- Patient Profile --}}
                                            <td class="px-6 py-3.5">
                                                <div class="flex items-center space-x-3">
                                                    <div class="shrink-0 w-9 h-9 rounded-xl bg-gradient-to-br from-rose-100 to-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 font-bold text-sm">
                                                        {{ strtoupper(substr($appointment->patient->name ?? 'P', 0, 1)) }}
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $appointment->patient->name ?? 'Unknown Patient' }}</p>
                                                        <p class="text-[11px] text-slate-400 font-medium truncate max-w-[150px]">{{ $appointment->patient->email ?? '' }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- Appointment Time --}}
                                            <td class="px-6 py-3.5">
                                                <span class="inline-flex items-center text-xs font-semibold text-slate-600">
                                                    <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                    {{ $appointment->appointment_time->format('h:i A') }}
                                                </span>
                                            </td>
                                            {{-- Reason for Visit --}}
                                            <td class="px-6 py-3.5">
                                                <p class="text-xs text-slate-500 italic truncate max-w-[160px]">
                                                    {{ Str::limit($appointment->reason ?? 'General Consultation', 35) }}
                                                </p>
                                            </td>
                                            {{-- Status Dot Indicator --}}
                                            <td class="px-6 py-3.5">
                                                @if ($appointment->status === 'confirmed')
                                                    <span class="inline-flex items-center text-xs font-semibold text-emerald-600">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                                                        Confirmed
                                                    </span>
                                                @elseif ($appointment->status === 'completed')
                                                    <span class="inline-flex items-center text-xs font-semibold text-slate-500">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-450 mr-2"></span>
                                                        Completed
                                                    </span>
                                                @elseif ($appointment->status === 'cancelled')
                                                    <span class="inline-flex items-center text-xs font-semibold text-rose-600">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-2"></span>
                                                        Cancelled
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center text-xs font-semibold text-amber-600">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-2 animate-pulse"></span>
                                                        Pending
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Mobile Card View --}}
                        <div class="sm:hidden space-y-3">
                            @foreach ($todayAppointments as $appointment)
                                <div class="bg-white rounded-2xl border border-slate-100 p-4 shadow-sm hover:shadow-md transition-shadow duration-300">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-rose-100 to-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 font-black text-sm">
                                                {{ strtoupper(substr($appointment->patient->name ?? 'P', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-800">{{ $appointment->patient->name ?? 'Unknown' }}</p>
                                                <p class="text-xs text-slate-400 font-medium">{{ $appointment->patient->email ?? '' }}</p>
                                            </div>
                                        </div>
                                        @if ($appointment->status === 'confirmed')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-600 border border-emerald-100">
                                                Confirmed
                                            </span>
                                        @elseif ($appointment->status === 'completed')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-slate-100 text-slate-500 border border-slate-200">
                                                Completed
                                            </span>
                                        @elseif ($appointment->status === 'cancelled')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-rose-50 text-rose-500 border border-rose-100">
                                                Cancelled
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-amber-50 text-amber-600 border border-amber-100">
                                                Pending
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-3 pt-2 border-t border-slate-50">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold">
                                            <svg class="w-3 h-3 mr-1 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                            {{ $appointment->appointment_time->format('h:i A') }}
                                        </span>
                                        <p class="text-xs text-slate-500 italic truncate">{{ Str::limit($appointment->reason ?? 'General', 30) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="bg-white rounded-[1.75rem] border-2 border-dashed border-slate-200 p-12 sm:p-16 text-center">
                            <div class="bg-slate-50 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-slate-800 mb-1">No appointments today</h3>
                            <p class="text-slate-400 text-sm font-medium">Your schedule is clear. Enjoy the downtime!</p>
                        </div>
                    @endif
                </div>

                {{-- ─────────────────────────────────────────────────────────── --}}
                {{--  QUICK ACTIONS SIDEBAR                                     --}}
                {{-- ─────────────────────────────────────────────────────────── --}}
                <div class="space-y-5">

                    {{-- Action 1: Manage Availability Slots --}}
                    <div class="group bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-lg hover:shadow-rose-100/30 hover:border-rose-100 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute -top-6 -right-6 w-24 h-24 bg-gradient-to-br from-rose-100 to-rose-50 rounded-full opacity-0 group-hover:opacity-50 transition-opacity duration-500"></div>
                        <div class="relative">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-rose-500 to-rose-600 flex items-center justify-center text-white mb-4 shadow-md shadow-rose-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-slate-800 mb-1">Manage Availability</h3>
                            <p class="text-xs text-slate-400 font-medium mb-4 leading-relaxed">Configure your open time slots, block off dates, and set recurring schedule patterns.</p>
                            <a href="/schedule"
                                class="inline-flex items-center justify-center w-full min-h-[44px] px-4 py-2.5 bg-slate-900 text-white text-xs font-black rounded-xl shadow-sm hover:bg-slate-800 transition-all uppercase tracking-widest">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                                </svg>
                                Open Scheduler
                            </a>
                        </div>
                    </div>

                    {{-- Action 2: Access Patient Health Ledgers --}}
                    <div class="group bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-lg hover:shadow-emerald-100/30 hover:border-emerald-100 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute -top-6 -right-6 w-24 h-24 bg-gradient-to-br from-emerald-100 to-emerald-50 rounded-full opacity-0 group-hover:opacity-50 transition-opacity duration-500"></div>
                        <div class="relative">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white mb-4 shadow-md shadow-emerald-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-slate-800 mb-1">Health Ledgers</h3>
                            <p class="text-xs text-slate-400 font-medium mb-4 leading-relaxed">Review patient clinical records, diagnoses, prescriptions, and past consultation history.</p>
                            <a href="/clinical-records"
                                class="inline-flex items-center justify-center w-full min-h-[44px] px-4 py-2.5 bg-emerald-600 text-white text-xs font-black rounded-xl shadow-sm hover:bg-emerald-700 transition-all uppercase tracking-widest">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                                Browse Ledgers
                            </a>
                        </div>
                    </div>

                    {{-- Contextual Tip Banner --}}
                    <div class="bg-slate-900 rounded-2xl p-5 relative overflow-hidden">
                        <div class="relative z-10 flex items-start space-x-3">
                            <div class="shrink-0 w-9 h-9 rounded-xl bg-slate-800 flex items-center justify-center text-rose-400">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-white text-xs font-bold mb-0.5">Quick Tip</p>
                                <p class="text-slate-400 text-[11px] font-medium leading-relaxed">Confirming an appointment sends an automated notification to the patient. Review the reason carefully before accepting.</p>
                            </div>
                        </div>
                        <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-rose-500/10 rounded-full"></div>
                        <div class="absolute -top-6 -left-6 w-16 h-16 bg-white/[0.03] rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>
    @elseif (auth()->user()->role === 'admin')
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header diagnostics check status -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 space-y-4 md:space-y-0 pb-6 border-b border-gray-200">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">System Infrastructure Overview</h1>
                    <p class="text-slate-500 mt-1.5 font-medium text-sm">Real-time status check, server diagnostics, environment configs, and registry logs.</p>
                </div>

                <div class="flex items-center text-xs text-emerald-600 font-black bg-emerald-50 px-4 py-2.5 rounded-xl border border-emerald-100/50 shadow-2xs">
                    <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full mr-2.5 animate-pulse"></span>
                    ALL SYSTEMS OPERATIONAL
                </div>
            </div>

            <!-- Stats Ribbon -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-6 mb-10">
                <div class="bg-white border border-slate-100 p-6 rounded-3xl shadow-xs hover:-translate-y-0.5 transition duration-300">
                    <p class="text-[9px] font-black text-slate-450 uppercase tracking-widest mb-1.5">Registered Patients</p>
                    <p class="text-3xl font-black text-slate-900 leading-none">{{ $patientCount }}</p>
                </div>
                <div class="bg-white border border-slate-100 p-6 rounded-3xl shadow-xs hover:-translate-y-0.5 transition duration-300">
                    <p class="text-[9px] font-black text-slate-455 text-slate-450 uppercase tracking-widest mb-1.5">Medical Officers</p>
                    <p class="text-3xl font-black text-slate-900 leading-none">{{ $doctorCount }}</p>
                </div>
                <div class="bg-white border border-slate-100 p-6 rounded-3xl shadow-xs hover:-translate-y-0.5 transition duration-300">
                    <p class="text-[9px] font-black text-slate-450 uppercase tracking-widest mb-1.5">Administrative Staff</p>
                    <p class="text-3xl font-black text-slate-900 leading-none">{{ $adminCount }}</p>
                </div>
                <div class="bg-white border border-slate-100 p-6 rounded-3xl shadow-xs hover:-translate-y-0.5 transition duration-300">
                    <p class="text-[9px] font-black text-slate-450 uppercase tracking-widest mb-1.5">Total Booked Sessions</p>
                    <p class="text-3xl font-black text-slate-900 leading-none">{{ $appointmentCount }}</p>
                </div>
            </div>

            <!-- Main diagnostics layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Server rack details -->
                <div class="lg:col-span-8 space-y-6">
                    <div class="bg-white border border-slate-100 p-8 rounded-3xl shadow-xs">
                        <h3 class="text-base font-black text-slate-800 mb-6 uppercase tracking-widest flex items-center gap-2">
                            <span>🖥️</span> Infrastructure Diagnostics
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs font-semibold">
                            <div class="p-4 bg-slate-50 border border-slate-100/50 rounded-2xl flex justify-between items-center">
                                <span class="text-slate-450 text-[10px] font-black uppercase tracking-wider">Laravel Core</span>
                                <span class="text-slate-800 font-extrabold bg-white border border-slate-100 px-2.5 py-1 rounded-lg">v{{ $systemMetrics['laravel_version'] }}</span>
                            </div>
                            <div class="p-4 bg-slate-50 border border-slate-100/50 rounded-2xl flex justify-between items-center">
                                <span class="text-slate-450 text-[10px] font-black uppercase tracking-wider">PHP Runtime</span>
                                <span class="text-slate-800 font-extrabold bg-white border border-slate-100 px-2.5 py-1 rounded-lg">v{{ $systemMetrics['php_version'] }}</span>
                            </div>
                            <div class="p-4 bg-slate-50 border border-slate-100/50 rounded-2xl flex justify-between items-center">
                                <span class="text-slate-450 text-[10px] font-black uppercase tracking-wider">Environment</span>
                                <span class="text-rose-600 font-black bg-rose-50 border border-rose-100/50 px-2.5 py-1 rounded-lg">{{ $systemMetrics['environment'] }}</span>
                            </div>
                            <div class="p-4 bg-slate-50 border border-slate-100/50 rounded-2xl flex justify-between items-center">
                                <span class="text-slate-455 text-[10px] font-black uppercase tracking-wider">Database Driver</span>
                                <span class="text-slate-850 uppercase font-extrabold bg-white border border-slate-100 px-2.5 py-1 rounded-lg">{{ $systemMetrics['db_driver'] }}</span>
                            </div>
                            <div class="p-4 bg-slate-50 border border-slate-100/50 rounded-2xl flex justify-between items-center">
                                <span class="text-slate-450 text-[10px] font-black uppercase tracking-wider">Timezone Config</span>
                                <span class="text-slate-700 font-bold">{{ $systemMetrics['timezone'] }}</span>
                            </div>
                            <div class="p-4 bg-slate-50 border border-slate-100/50 rounded-2xl flex justify-between items-center">
                                <span class="text-slate-450 text-[10px] font-black uppercase tracking-wider">Memory Allocation</span>
                                <span class="text-slate-700 font-bold">{{ $systemMetrics['memory_usage'] }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-6 p-4 bg-slate-900 rounded-2xl flex items-center justify-between text-white">
                            <div class="flex items-center gap-2">
                                <span class="text-amber-500">⚙️</span>
                                <span class="text-[10px] font-bold text-slate-400">DEBUG MODE STATUS</span>
                            </div>
                            <span class="text-[10px] font-black tracking-widest px-2.5 py-1 rounded-lg {{ $systemMetrics['debug_mode'] === 'ENABLED' ? 'bg-amber-500/20 text-amber-400' : 'bg-slate-800 text-slate-400' }}">
                                {{ $systemMetrics['debug_mode'] }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Registration timeline -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white border border-slate-100 p-6 rounded-3xl shadow-xs">
                        <h3 class="font-black text-slate-900 mb-4 uppercase tracking-widest text-xs">🆕 New Registrations</h3>
                        <div class="space-y-4">
                            @foreach ($recentUsers as $user)
                                <div class="flex items-center space-x-3.5 pb-3 border-b border-slate-50 last:border-0 last:pb-0">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-rose-400 to-rose-600 flex items-center justify-center text-white font-bold text-xs">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-bold text-slate-800 truncate leading-none mb-1">{{ $user->name }}</p>
                                        <span class="text-[9px] font-semibold text-slate-450 block truncate leading-none">{{ $user->email }}</span>
                                    </div>
                                    <div>
                                        <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[8px] font-black uppercase tracking-wider">{{ $user->role }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-animation>
