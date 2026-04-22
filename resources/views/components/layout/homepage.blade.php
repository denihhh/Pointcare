@props(['upcomingAppointment' => null, 'todayCount' => 0, 'pendingCount' => 0])

<x-animation>
    @if (auth()->user()->role === 'patient')
        <div class=" max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 space-y-4 md:space-y-0 pb-6 border-b border-gray-300">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Hello, {{ auth()->user()->name }}
                    </h1>
                    <p class="text-slate-500 mt-1">Welcome back to PointCare. Here is your health overview.</p>
                </div>

                <a href="/appointments/create"
                    class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-bold rounded-xl shadow-sm text-white bg-rose-500 hover:bg-rose-600 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
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
                                        class="flex-shrink-0 w-24 h-24 bg-cyan-50 rounded-2xl flex flex-col items-center justify-center border border-cyan-100">
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
                                            {{ $upcomingAppointment->doctor->name }}</h3>
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

                    <section>
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 pb-6 border-b border-gray-300">
                <div>
                    <h1 class="text-4xl font-black text-slate-900 mt-1">Welcome, Dr. {{ auth()->user()->name }}</h1>
                    <p class="text-slate-500 mt-2 text-lg">
                        You have
                        <span class="text-slate-900 font-bold">
                            {{ $todayCount }} {{ Str::plural('consultation', $todayCount) }}
                        </span>
                        scheduled for today.
                    </p>
                </div>

                <div class=" mt-6 md:mt-0">
                    <a href="/dashboard"
                        class="inline-flex items-center justify-center px-8 py-4 border border-slate-200 text-sm font-bold rounded-2xl shadow-sm text-slate-700 bg-white hover:bg-slate-50 hover:border-slate-300 transition-all focus:outline-none">
                        <svg class="w-5 h-5 mr-2 text-rose-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Manage Appointments
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Consultations</p>
                    <h3 class="text-2xl font-black text-slate-900">{{ $todayCount }} Today</h3>
                </div>
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Pending Approvals</p>
                    <h3 class="text-2xl font-black text-rose-500">{{ $pendingCount }} New</h3>
                </div>
                <div class="bg-indigo-600 rounded-2xl p-5 shadow-lg text-white">
                    <p class="text-indigo-100 text-xs font-bold uppercase tracking-wider">Next Shift</p>
                    <h3 class="text-2xl font-black italic">02:00 PM</h3>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-slate-800">Next Scheduled Patient</h2>
                        <a href="/dashboard" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">Full
                            Schedule &rarr;</a>
                    </div>

                    @if ($upcomingAppointment)
                        <div
                            class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                            <div
                                class="p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start space-y-6 sm:space-y-0 sm:space-x-8">

                                <div
                                    class="flex-shrink-0 w-28 h-28 bg-indigo-50 rounded-full flex flex-col items-center justify-center border-4 border-white shadow-inner">
                                    <span class="text-indigo-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                    <span
                                        class="text-sm font-black text-indigo-700 mt-1">{{ $upcomingAppointment->appointment_time->format('H:i') }}</span>
                                </div>

                                <div class="flex-1 text-center sm:text-left">
                                    <div class="flex items-center justify-center sm:justify-start space-x-2 mb-2">
                                        <span
                                            class="px-2 py-0.5 rounded-md bg-indigo-100 text-indigo-700 text-[10px] font-bold uppercase tracking-wider italic">Priority</span>
                                        <span
                                            class="text-slate-500 text-sm font-medium">{{ $upcomingAppointment->appointment_time->format('l, d M') }}</span>
                                    </div>
                                    <h3 class="text-3xl font-extrabold text-slate-900">
                                        {{ $upcomingAppointment->patient->name }}</h3>

                                    <div class="mt-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                        <p class="text-xs text-slate-400 font-bold uppercase mb-1">Reason for
                                            Consultation
                                        </p>
                                        <p class="text-slate-700 leading-relaxed italic">
                                            "{{ $upcomingAppointment->reason }}"</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-slate-50 border-t border-slate-100 px-8 py-4 flex justify-end space-x-4">
                                <button
                                    class="text-sm font-bold text-slate-500 hover:text-slate-700 transition">Patient
                                    History</button>
                                <a href="/dashboard"
                                    class="bg-indigo-600 text-white px-6 py-2 rounded-xl text-sm font-bold hover:bg-indigo-700 shadow-md transition">Start
                                    Session</a>
                            </div>
                        </div>
                    @else
                        <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl p-16 text-center">
                            <div
                                class="bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-slate-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="text-slate-500 font-medium italic">You're all caught up! No more patients for
                                today.
                            </p>
                        </div>
                    @endif
                </div>

                <div class="space-y-6">
                    <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
                        <h3 class="font-bold text-slate-800 mb-4 flex items-center">
                            <span class="mr-2">📋</span> Daily Checklist
                        </h3>
                        <ul class="space-y-4">
                            <li class="flex items-center text-sm text-slate-600">
                                <input type="checkbox" class="rounded text-indigo-600 mr-3" checked disabled>
                                <span class="line-through">Review morning lab results</span>
                            </li>
                            <li class="flex items-center text-sm text-slate-600">
                                <input type="checkbox" class="rounded text-indigo-600 mr-3">
                                Sign 3 prescription renewals
                            </li>
                            <li class="flex items-center text-sm text-slate-600">
                                <input type="checkbox" class="rounded text-indigo-600 mr-3">
                                Update clinical notes for Dr. Smith
                            </li>
                        </ul>
                    </div>

                    <div class="bg-indigo-900 rounded-3xl p-6 text-white relative overflow-hidden">
                        <h3 class="font-bold text-lg mb-2 relative z-10">Clinical Portal</h3>
                        <p class="text-indigo-300 text-xs mb-4 relative z-10">Access the centralized medical database
                            for
                            research and drug interactions.</p>
                        <button
                            class="bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg text-xs font-bold transition relative z-10">Launch
                            Portal</button>
                        <div class="absolute -top-4 -right-4 w-20 h-20 bg-white/5 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-animation>
