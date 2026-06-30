<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">

    <!-- Top Admin Header -->
    <div class="mt-8 mb-8 flex flex-col lg:flex-row lg:items-end justify-between gap-6">
        <div class="flex-1">
            <div class="flex items-center space-x-3 mb-2">
                <span
                    class="bg-rose-150/80 text-rose-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-rose-50 border border-rose-100/50">
                    ADMINISTRATIVE AUTHORITY
                </span>
                
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none">Control Panel</h1>
            <p class="text-slate-500 font-medium mt-2 max-w-xl">Supervise medical personnel credentials, role-based access tokens, database registries, and clinical session logs.</p>
        </div>

        <div class="flex gap-4">
            <div class="bg-white/80 backdrop-blur-md border border-slate-100 p-4 rounded-2xl shadow-xs min-w-[140px] hover:border-rose-100 transition-all duration-300">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Clinic Directory</p>
                <p class="text-2xl font-black text-slate-900 flex items-baseline gap-1">
                    {{ $totalUsers }} <span class="text-xs font-bold text-slate-400">users</span>
                </p>
            </div>
            <div class="bg-rose-50/50 backdrop-blur-md border border-rose-100/60 p-4 rounded-2xl shadow-xs min-w-[140px] hover:shadow-rose-100/20 transition-all duration-300">
                <p class="text-[9px] font-black text-rose-400 uppercase tracking-widest mb-1">Today's Schedule</p>
                <p class="text-2xl font-black text-rose-600 flex items-baseline gap-1">
                    {{ $todayAppointmentsCount }} <span class="text-xs font-bold text-rose-400">slots</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Alert Message Popups -->
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition.opacity.duration.300ms
            class="mb-6 bg-emerald-550 bg-emerald-50 border border-emerald-100 text-emerald-850 p-4 rounded-2xl shadow-xs flex items-center justify-between text-sm font-semibold">
            <div class="flex items-center gap-2">
                <span class="text-emerald-500">✓</span>
                <span class="text-slate-800">{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-slate-400 hover:text-slate-600 font-bold">&times;</button>
        </div>
    @endif
    @if (session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition.opacity.duration.300ms
            class="mb-6 bg-rose-50 border border-rose-100 text-rose-850 p-4 rounded-2xl shadow-xs flex items-center justify-between text-sm font-semibold">
            <div class="flex items-center gap-2">
                <span class="text-rose-500">⚠️</span>
                <span class="text-slate-800">{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="text-slate-400 hover:text-slate-600 font-bold">&times;</button>
        </div>
    @endif

    <!-- Main Navigation Tab bar -->
    <div class="mb-8 border-b border-rose-100/40 flex items-center gap-8 overflow-x-auto scrollbar-none">
        <button wire:click="setTab('overview')"
            class="pb-4 text-xs font-black uppercase tracking-widest border-b-2 transition-all duration-300 focus:outline-none whitespace-nowrap {{ $activeTab === 'overview' ? 'text-rose-600 border-rose-500' : 'text-slate-400 border-transparent hover:text-slate-600' }}">
            System Overview
        </button>
        <button wire:click="setTab('users')"
            class="pb-4 text-xs font-black uppercase tracking-widest border-b-2 transition-all duration-300 focus:outline-none whitespace-nowrap {{ $activeTab === 'users' ? 'text-rose-600 border-rose-500' : 'text-slate-400 border-transparent hover:text-slate-600' }}">
            User Accounts ({{ $totalUsers }})
        </button>
        <button wire:click="setTab('appointments')"
            class="pb-4 text-xs font-black uppercase tracking-widest border-b-2 transition-all duration-300 focus:outline-none whitespace-nowrap {{ $activeTab === 'appointments' ? 'text-rose-600 border-rose-500' : 'text-slate-400 border-transparent hover:text-slate-600' }}">
            Appointments ({{ $totalAppointments }})
        </button>
        <button wire:click="setTab('messages')"
            class="pb-4 text-xs font-black uppercase tracking-widest border-b-2 transition-all duration-300 focus:outline-none whitespace-nowrap flex items-center gap-1.5 {{ $activeTab === 'messages' ? 'text-rose-600 border-rose-500' : 'text-slate-400 border-transparent hover:text-slate-600' }}">
            Support Messages ({{ $totalMessages }})
            @if ($pendingMessagesCount > 0)
                <span class="bg-amber-500 text-white text-[9px] font-black px-1.5 py-0.5 rounded-full shrink-0 animate-pulse">
                    {{ $pendingMessagesCount }}
                </span>
            @endif
        </button>

    </div>
    

    <!-- ================== 1. OVERVIEW TAB SCREEN ================== -->
    @if ($activeTab === 'overview')
        <!-- Key Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Patient Card -->
            <div class="bg-gradient-to-br from-cyan-50/60 to-white border border-cyan-100/30 p-6 rounded-3xl shadow-xs flex items-center space-x-5 hover:-translate-y-1 hover:shadow-md hover:border-cyan-100/80 transition-all duration-300 group">
                <div class="w-12 h-12 bg-rose-500 rounded-2xl flex items-center justify-center text-white shadow-sm shadow-rose-200 group-hover:scale-105 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Active Patients</h3>
                    <p class="text-3xl font-black text-slate-900 mt-1 leading-none">{{ $totalPatients }}</p>
                </div>
            </div>

            <!-- Doctor Card -->
            <div class="bg-gradient-to-br from-cyan-50/60 to-white border border-cyan-100/30 p-6 rounded-3xl shadow-xs flex items-center space-x-5 hover:-translate-y-1 hover:shadow-md hover:border-cyan-100/80 transition-all duration-300 group">
                <div class="w-12 h-12 bg-cyan-500 rounded-2xl flex items-center justify-center text-white shadow-sm shadow-cyan-200 group-hover:scale-105 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.25 2.25 0 0 1 10.5 2.25h4.5a2.25 2.25 0 0 1 2.25 2.25m-10.5 0c-1.13 0-2.049.917-2.117 2.044a48.253 48.253 0 0 0-1.123.08M3.75 6.108c0-1.135.845-2.098 1.976-2.192a48.424 48.424 0 0 1 1.123-.08" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Medical Officers</h3>
                    <p class="text-3xl font-black text-slate-900 mt-1 leading-none">{{ $totalDoctors }}</p>
                </div>
            </div>

            <!-- Admin Card -->
            <div class="bg-gradient-to-br from-slate-50 to-white border border-slate-200/40 p-6 rounded-3xl shadow-xs flex items-center space-x-5 hover:-translate-y-1 hover:shadow-md hover:border-slate-300/40 transition-all duration-300 group">
                <div class="w-12 h-12 bg-slate-800 rounded-2xl flex items-center justify-center text-white shadow-sm shadow-slate-200 group-hover:scale-105 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Administrators</h3>
                    <p class="text-3xl font-black text-slate-900 mt-1 leading-none">{{ $totalAdmins }}</p>
                </div>
            </div>

            <!-- Support Messages Card -->
            <div wire:click="setTab('messages')" class="bg-gradient-to-br from-amber-50/60 to-white border border-amber-100/30 p-6 rounded-3xl shadow-xs flex items-center space-x-5 hover:-translate-y-1 hover:shadow-md hover:border-amber-100/80 transition-all duration-300 group cursor-pointer">
                <div class="w-12 h-12 bg-amber-500 rounded-2xl flex items-center justify-center text-white shadow-sm shadow-amber-200 group-hover:scale-105 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pending Support</h3>
                    <p class="text-3xl font-black text-slate-900 mt-1 leading-none">
                        {{ $pendingMessagesCount }} <span class="text-xs font-bold text-slate-400">new</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left: Appointment Distribution Summary -->
            <div class="lg:col-span-7 bg-white p-8 rounded-3xl border border-slate-100 shadow-xs flex flex-col justify-between">
                <div>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Appointment Allocation Details</h2>
                    <p class="text-xs font-semibold text-slate-400 mt-1">Allocation percentage based on status.</p>
                </div>

                <div class="space-y-5 my-8">
                    <!-- Progress bar formulas -->
                    @php
                        $calcPercentage = fn($part) => $totalAppointments > 0 ? round(($part / $totalAppointments) * 100, 1) : 0;
                        $pendingPct = $calcPercentage($pendingAppointmentsCount);
                        $confirmedPct = $calcPercentage($confirmedAppointmentsCount);
                        $completedPct = $calcPercentage($completedAppointmentsCount);
                        $cancelledPct = $calcPercentage($cancelledAppointmentsCount);
                    @endphp

                    <!-- Pending bar -->
                    <div class="space-y-1">
                        <div class="flex justify-between text-xs font-bold">
                            <span class="text-slate-500 uppercase tracking-wider text-[10px]">Pending Actions</span>
                            <span class="text-slate-800">{{ $pendingAppointmentsCount }} ({{ $pendingPct }}%)</span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-amber-500 rounded-full" style="width: {{ $pendingPct }}%"></div>
                        </div>
                    </div>

                    <!-- Confirmed bar -->
                    <div class="space-y-1">
                        <div class="flex justify-between text-xs font-bold">
                            <span class="text-sky-500 uppercase tracking-wider text-[10px]">Confirmed Bookings</span>
                            <span class="text-sky-600">{{ $confirmedAppointmentsCount }} ({{ $confirmedPct }}%)</span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-sky-550 bg-sky-500 rounded-full" style="width: {{ $confirmedPct }}%"></div>
                        </div>
                    </div>

                    <!-- Completed bar -->
                    <div class="space-y-1">
                        <div class="flex justify-between text-xs font-bold">
                            <span class="text-emerald-500 uppercase tracking-wider text-[10px]">Completed Audits</span>
                            <span class="text-emerald-600">{{ $completedAppointmentsCount }} ({{ $completedPct }}%)</span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $completedPct }}%"></div>
                        </div>
                    </div>

                    <!-- Cancelled bar -->
                    <div class="space-y-1">
                        <div class="flex justify-between text-xs font-bold">
                            <span class="text-rose-500 uppercase tracking-wider text-[10px]">Cancelled Sessions</span>
                            <span class="text-rose-600">{{ $cancelledAppointmentsCount }} ({{ $cancelledPct }}%)</span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-rose-500 rounded-full" style="width: {{ $cancelledPct }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="pt-2 flex gap-4">
                    <button wire:click="setTab('appointments')" class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white text-xs font-black rounded-xl transition-all duration-200 tracking-wider uppercase shadow-xs">
                        Open Booking Registry
                    </button>
                    <button wire:click="setTab('users')" class="w-full py-3 bg-rose-50 border border-rose-100 text-rose-600 hover:bg-rose-100/50 text-xs font-black rounded-xl transition-all duration-200 tracking-wider uppercase">
                        Manage Accounts
                    </button>
                </div>
            </div>

            <!-- Right: System Activity Timeline -->
            <div class="lg:col-span-5 bg-white p-8 rounded-3xl border border-slate-100 shadow-xs flex flex-col justify-between">
                <div>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Recent System Feed</h2>
                    <p class="text-xs font-semibold text-slate-400 mt-1">Real-time log of clinic transaction bookings.</p>
                </div>

                <div class="my-6 space-y-6 flex-1">
                    @forelse ($recentActivities as $act)
                        <div class="flex items-start gap-4">
                            <!-- Avatar circle -->
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-rose-400 to-rose-600 flex items-center justify-center text-white text-xs font-black flex-shrink-0">
                                {{ substr($act->patient?->name ?? '?', 0, 1) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-bold text-slate-800">
                                    <strong class="text-slate-900 font-extrabold">{{ $act->patient?->name }}</strong>
                                    booked with Dr. {{ $act->doctor?->name }}
                                </p>
                                <span class="text-[9px] font-bold text-slate-400 block mt-0.5">{{ $act->created_at->diffForHumans() }}</span>
                            </div>
                            <div>
                                @if ($act->status === 'pending')
                                    <span class="bg-amber-50 text-amber-600 text-[8px] font-black uppercase px-2 py-0.5 rounded-sm">Pending</span>
                                @elseif ($act->status === 'confirmed')
                                    <span class="bg-sky-50 text-sky-600 text-[8px] font-black uppercase px-2 py-0.5 rounded-sm">Active</span>
                                @elseif ($act->status === 'completed')
                                    <span class="bg-emerald-50 text-emerald-600 text-[8px] font-black uppercase px-2 py-0.5 rounded-sm">Done</span>
                                @else
                                    <span class="bg-rose-50 text-rose-600 text-[8px] font-black uppercase px-2 py-0.5 rounded-sm">Void</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-400 text-xs text-center py-10">No recent transactions recorded.</p>
                    @endforelse
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-between items-center text-[10px] font-black text-slate-400 tracking-wider uppercase">
                    <span>Database Status: HEALTHY</span>
                    <span>100% Integrity</span>
                </div>
            </div>
        </div>

        <!-- Inbox Quick View Section -->
        @if ($recentMessages->count() > 0)
            <div class="mt-8 bg-amber-50/20 border border-amber-100/50 p-8 rounded-3xl shadow-2xs">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                            Pending Support Inbox
                        </h2>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Review recently received inquiries requiring administrative attention.</p>
                    </div>
                    <button wire:click="setTab('messages')" class="text-xs font-black text-rose-500 hover:text-rose-600 uppercase tracking-widest bg-white border border-slate-100 px-4 py-2 rounded-xl shadow-2xs">
                        View All Messages &rarr;
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($recentMessages as $msg)
                        <div class="bg-white border border-slate-100 p-6 rounded-2xl shadow-3xs flex flex-col justify-between hover:border-amber-200 transition">
                            <div>
                                <div class="flex justify-between items-start gap-1">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-extrabold text-slate-800 truncate leading-tight">{{ $msg->name }}</p>
                                        <span class="text-[10px] text-slate-400 font-semibold truncate block mt-0.5">{{ $msg->email }}</span>
                                    </div>
                                    <span class="text-[9px] font-black text-slate-400 shrink-0">
                                        {{ $msg->created_at->diffForHumans(null, true) }}
                                    </span>
                                </div>
                                <div class="mt-3.5 mb-4">
                                    <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[8px] font-black uppercase tracking-wider">
                                        {{ $msg->subject }}
                                    </span>
                                    <p class="text-xs text-slate-500 leading-relaxed font-medium mt-2 line-clamp-3" title="{{ $msg->message }}">
                                        {{ $msg->message }}
                                    </p>
                                </div>
                            </div>
                            <button wire:click="toggleMessageStatus({{ $msg->id }})" class="w-full py-2 bg-slate-50 hover:bg-rose-50 border border-slate-150 hover:text-rose-600 hover:border-rose-100 text-[10px] font-black tracking-widest rounded-xl transition uppercase text-slate-600">
                                Mark Resolved
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endif

    <!-- ================== 2. USERS MANAGEMENT TAB SCREEN ================== -->
    @if ($activeTab === 'users')
        <div class="bg-white border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.02)] rounded-3xl p-6">
            
            <!-- Filters and Search Bar -->
            <div class="mb-6 flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="relative w-full md:max-w-xs">
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search name, email, phone..." 
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-rose-450 focus:ring-1 focus:ring-rose-400 focus:bg-white transition" />
                </div>

                <div class="flex items-center gap-4 w-full md:w-auto">
                    <select wire:model.live="roleFilter" 
                        class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:border-rose-450 focus:ring-1 focus:ring-rose-400 focus:bg-white transition w-full md:w-auto">
                        <option value="all">All Roles</option>
                        <option value="patient">Patients Only</option>
                        <option value="doctor">Doctors Only</option>
                        <option value="admin">Administrators Only</option>
                    </select>

                    <button wire:click="startCreateUser" 
                        class="bg-rose-500 text-white text-xs font-black px-5 py-3 rounded-xl shadow-xs hover:bg-rose-600 transition-all duration-300 hover:shadow-md tracking-wider uppercase whitespace-nowrap flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        New Account
                    </button>
                </div>
            </div>

            <!-- User Creation Form Drawer -->
            @if ($isCreatingUser)
                <div class="mb-8 p-6 bg-slate-50 border border-slate-100 rounded-3xl transition duration-300 relative shadow-inner">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-black text-slate-900 leading-none">Register New User Account</h3>
                            <p class="text-xs text-slate-500 mt-1">Fill in the fields to establish a patient, doctor, or administrator profile.</p>
                        </div>
                        <button wire:click="cancelCreateUser" class="text-slate-400 hover:text-slate-600 font-bold text-sm">Cancel</button>
                    </div>

                    <form wire:submit.prevent="createUser" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Full Name</label>
                                <input wire:model="newName" type="text" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-rose-400 focus:ring-1 focus:ring-rose-400" />
                                @error('newName') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Email Address</label>
                                <input wire:model="newEmail" type="email" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-rose-400 focus:ring-1 focus:ring-rose-400" />
                                @error('newEmail') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Phone Number</label>
                                <input wire:model="newPhone" type="text" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-rose-400 focus:ring-1 focus:ring-rose-400" />
                                @error('newPhone') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Secure Password</label>
                                <input wire:model="newPassword" type="password" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-rose-400 focus:ring-1 focus:ring-rose-400" />
                                @error('newPassword') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Account Access Role</label>
                                <select wire:model.live="newRole" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:border-rose-400 focus:ring-1 focus:ring-rose-400">
                                    <option value="patient">Patient</option>
                                    <option value="doctor">Doctor</option>
                                    <option value="admin">Administrator</option>
                                </select>
                                @error('newRole') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Doctor specific details form -->
                        @if ($newRole === 'doctor')
                            <div class="mt-6 pt-6 border-t border-slate-200 space-y-4">
                                <div class="bg-cyan-50/40 border border-cyan-100/50 p-6 rounded-2xl">
                                    <h4 class="text-xs font-black text-cyan-700 uppercase tracking-widest mb-4 flex items-center gap-1.5">
                                        🩺 Medical Practitioner Credentials & Details
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Specialization area</label>
                                            <input wire:model="newSpecialization" type="text" placeholder="e.g. Pediatrics, Cardiology" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400" />
                                            @error('newSpecialization') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Clinic License Number</label>
                                            <input wire:model="newLicense" type="text" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400" />
                                            @error('newLicense') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Consultation Fee (RM)</label>
                                            <input wire:model="newFee" type="number" step="0.01" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400" />
                                            @error('newFee') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Bio Details</label>
                                            <textarea wire:model="newBio" rows="3" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400"></textarea>
                                            @error('newBio') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="pt-4 flex gap-4">
                            <button type="submit" class="bg-rose-500 text-white text-xs font-black px-6 py-3.5 rounded-xl shadow-xs hover:bg-rose-600 transition tracking-wider uppercase">
                                Register Account
                            </button>
                            <button type="button" wire:click="cancelCreateUser" class="bg-white border border-slate-200 text-slate-600 text-xs font-black px-6 py-3.5 rounded-xl shadow-2xs hover:bg-slate-50 transition tracking-wider uppercase">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- User Editing Form Drawer -->
            @if ($isEditingUser && $selectedUser)
                <div class="mb-8 p-6 bg-rose-50/30 border border-rose-100 rounded-3xl transition duration-300 relative shadow-inner">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-black text-slate-900 leading-none">Modify Credentials & Role</h3>
                            <p class="text-xs text-slate-500 mt-1">Manage authorization tokens and doctor specifics for <strong>{{ $selectedUser->name }}</strong>.</p>
                        </div>
                        <button wire:click="cancelEdit" class="text-slate-400 hover:text-slate-600 font-bold text-sm">Cancel</button>
                    </div>

                    <form wire:submit.prevent="saveUserRole" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Assign Core Role</label>
                                <select wire:model.live="editRole" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:border-rose-400 focus:ring-1 focus:ring-rose-400">
                                    <option value="patient">Patient</option>
                                    <option value="doctor">Doctor</option>
                                    <option value="admin">Administrator</option>
                                </select>
                                @error('editRole') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Doctor specific details form -->
                        @if ($editRole === 'doctor')
                            <div class="mt-6 pt-6 border-t border-slate-200 space-y-4">
                                <div class="bg-cyan-50/40 border border-cyan-100/50 p-6 rounded-2xl">
                                    <h4 class="text-xs font-black text-cyan-700 uppercase tracking-widest mb-4 flex items-center gap-1.5">
                                        🩺 Medical Practitioner Credentials & Details
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Specialization area</label>
                                            <input wire:model="specialization" type="text" placeholder="e.g. Pediatrics" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400" />
                                            @error('specialization') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Clinic License Number</label>
                                            <input wire:model="license_number" type="text" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400" />
                                            @error('license_number') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Consultation Fee (RM)</label>
                                            <input wire:model="consultation_fee" type="number" step="0.01" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400" />
                                            @error('consultation_fee') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Doctor Bio Details</label>
                                            <textarea wire:model="bio" rows="3" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400"></textarea>
                                            @error('bio') <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="pt-4 flex gap-4">
                            <button type="submit" class="bg-rose-500 text-white text-xs font-black px-6 py-3.5 rounded-xl shadow-xs hover:bg-rose-600 transition tracking-wider uppercase">
                                Save Settings
                            </button>
                            <button type="button" wire:click="cancelEdit" class="bg-white border border-slate-200 text-slate-600 text-xs font-black px-6 py-3.5 rounded-xl shadow-2xs hover:bg-slate-50 transition tracking-wider uppercase">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Delete Confirmation Modal (Frosted backdrop) -->
            @if ($confirmingDeleteUserId)
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
                    <div class="bg-white max-w-md w-full p-8 rounded-3xl shadow-2xl border border-rose-100 flex flex-col space-y-6">
                        <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-900">Purge User Profile?</h3>
                            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                                Are you absolutely certain you want to permanently delete the profile of
                                <strong class="text-slate-800">{{ User::find($confirmingDeleteUserId)?->name }}</strong>?
                                This operation will cascade-delete all related scheduling records, diagnostics, and clinical observations. This cannot be undone.
                            </p>
                        </div>
                        <div class="flex gap-4">
                            <button wire:click="deleteUser" class="w-full bg-rose-600 text-white text-xs font-black py-3.5 rounded-xl hover:bg-rose-700 transition tracking-wider uppercase">
                                Purge Profile
                            </button>
                            <button wire:click="cancelDelete" class="w-full bg-white border border-slate-200 text-slate-600 text-xs font-black py-3.5 rounded-xl hover:bg-slate-50 transition tracking-wider uppercase">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Users Accounts List Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-widest text-[9px]">
                            <th class="py-4 px-3">Name & Practitioner Status</th>
                            <th class="py-4 px-3">Email Address</th>
                            <th class="py-4 px-3">Phone</th>
                            <th class="py-4 px-3">Role Status</th>
                            <th class="py-4 px-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm font-semibold text-slate-700">
                        @foreach ($users as $u)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-3">
                                    <div class="flex items-center gap-3">
                                        <!-- Mini Initial Badge -->
                                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-rose-400/20 to-rose-600/10 text-rose-600 flex items-center justify-center font-bold text-xs">
                                            {{ substr($u->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-850 text-sm leading-none">{{ $u->name }}</div>
                                            @if ($u->role === 'doctor' && $u->doctor)
                                                <span class="text-[9px] text-cyan-500 font-black tracking-wider uppercase block mt-1">🩺 {{ $u->doctor->specialization }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 font-medium text-slate-500">{{ $u->email }}</td>
                                <td class="py-4 px-3 font-medium text-slate-500">{{ $u->phone ?: '-' }}</td>
                                <td class="py-4 px-3">
                                    @if ($u->role === 'admin')
                                        <span class="bg-slate-900 text-slate-200 text-[9px] font-black uppercase px-2.5 py-1 rounded-md tracking-wider border border-slate-800">Admin</span>
                                    @elseif ($u->role === 'doctor')
                                        <span class="bg-cyan-50 text-cyan-600 text-[9px] font-black uppercase px-2.5 py-1 rounded-md tracking-wider border border-cyan-100/50">Doctor</span>
                                    @else
                                        <span class="bg-rose-50 text-rose-600 text-[9px] font-black uppercase px-2.5 py-1 rounded-md tracking-wider border border-rose-100/50">Patient</span>
                                    @endif
                                </td>
                                <td class="py-4 px-3 text-right flex items-center justify-end gap-2.5">
                                    <button wire:click="editUser({{ $u->id }})" class="bg-slate-50 border border-slate-200 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-100 px-3 py-1.5 rounded-lg text-[10px] font-black tracking-widest transition-all duration-200 uppercase text-slate-600">
                                        Manage Role
                                    </button>
                                    @if ($u->id !== auth()->id())
                                        <button wire:click="confirmDelete({{ $u->id }})" class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition duration-200" title="Delete User">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6" id="users-scroll-target">
                {{ $users->links('livewire::tailwind') }}
            </div>
        </div>
    @endif

    <!-- ================== 3. APPOINTMENTS TAB SCREEN ================== -->
    @if ($activeTab === 'appointments')
        <div class="bg-white border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.02)] rounded-3xl p-6">
            
            <!-- Filters and Search Bar -->
            <div class="mb-6 flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="relative w-full md:max-w-xs">
                    <input wire:model.live.debounce.300ms="appointmentSearch" type="text" placeholder="Search patient, doctor, reason..." 
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-rose-450 focus:ring-1 focus:ring-rose-400 focus:bg-white transition" />
                </div>

                <div class="flex items-center gap-4 w-full md:w-auto">
                    <select wire:model.live="appointmentFilter" 
                        class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:border-rose-450 focus:ring-1 focus:ring-rose-400 focus:bg-white transition w-full md:w-auto">
                        <option value="all">All Appointments</option>
                        <option value="pending">Pending Status</option>
                        <option value="confirmed">Confirmed Status</option>
                        <option value="completed">Completed Status</option>
                        <option value="cancelled">Cancelled Status</option>
                    </select>
                </div>
            </div>

            <!-- List Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-widest text-[9px]">
                            <th class="py-4 px-3">Date & Time Slot</th>
                            <th class="py-4 px-3">Patient Registry</th>
                            <th class="py-4 px-3">Medical Officer</th>
                            <th class="py-4 px-3">Reason for consultation</th>
                            <th class="py-4 px-3">Consultation Status</th>
                            <th class="py-4 px-3 text-right">Actions Override</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm font-semibold text-slate-700">
                        @forelse ($appointments as $a)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-3 text-sm">
                                    <div class="flex items-center gap-3">
                                        <!-- Mini Calendar Icon -->
                                        <div class="w-9 h-9 bg-slate-50 rounded-xl flex flex-col items-center justify-center text-slate-400 flex-shrink-0 border border-slate-100">
                                            <span class="text-[8px] font-black uppercase text-rose-500 leading-none mb-0.5">{{ \Carbon\Carbon::parse($a->appointment_time)->format('M') }}</span>
                                            <span class="text-xs font-black text-slate-800 leading-none">{{ \Carbon\Carbon::parse($a->appointment_time)->format('d') }}</span>
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-slate-900">{{ \Carbon\Carbon::parse($a->appointment_time)->format('d M Y') }}</div>
                                            <span class="text-[10px] text-slate-400 font-black block mt-0.5">{{ \Carbon\Carbon::parse($a->appointment_time)->format('h:i A') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 font-bold text-slate-800">
                                    {{ $a->patient?->name ?: 'Deleted Patient' }}
                                </td>
                                <td class="py-4 px-3 font-semibold text-slate-700">
                                    Dr. {{ $a->doctor?->name ?: 'Deleted Doctor' }}
                                </td>
                                <td class="py-4 px-3 max-w-[200px] truncate text-slate-500 font-medium" title="{{ $a->reason }}">
                                    {{ $a->reason ?: '-' }}
                                </td>
                                <td class="py-4 px-3">
                                    @if ($a->status === 'pending')
                                        <span class="bg-amber-50 text-amber-600 text-[9px] font-black uppercase px-2 py-0.5 rounded border border-amber-100">Pending</span>
                                    @elseif ($a->status === 'confirmed')
                                        <span class="bg-sky-50 text-sky-600 text-[9px] font-black uppercase px-2 py-0.5 rounded border border-sky-100">Confirmed</span>
                                    @elseif ($a->status === 'completed')
                                        <span class="bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase px-2 py-0.5 rounded border border-emerald-100">Completed</span>
                                    @else
                                        <span class="bg-rose-50 text-rose-600 text-[9px] font-black uppercase px-2 py-0.5 rounded border border-rose-100">Cancelled</span>
                                    @endif
                                </td>
                                <td class="py-4 px-3 text-right flex items-center justify-end gap-2 text-xs">
                                    @if ($a->status === 'pending')
                                        <button wire:click="confirmAppointment({{ $a->id }})" class="bg-emerald-50 text-emerald-600 hover:bg-emerald-550 hover:bg-emerald-100 hover:text-emerald-700 border border-emerald-100 px-3 py-1.5 rounded-lg font-black uppercase tracking-wider">
                                            Confirm
                                        </button>
                                    @endif
                                    @if ($a->status !== 'cancelled' && $a->status !== 'completed')
                                        <button wire:click="cancelAppointment({{ $a->id }})" class="bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-700 border border-rose-100 px-3 py-1.5 rounded-lg font-black uppercase tracking-wider">
                                            Cancel
                                        </button>
                                    @endif
                                    @if ($a->status === 'confirmed')
                                        <button wire:click="completeAppointment({{ $a->id }})" class="bg-emerald-50 text-emerald-600 hover:bg-emerald-100 hover:text-emerald-700 border border-emerald-100 px-3 py-1.5 rounded-lg font-black uppercase tracking-wider">
                                            Complete
                                        </button>
                                    @endif
                                    <button wire:click="deleteAppointment({{ $a->id }})" onclick="return confirm('Permanently remove this booking record?')" class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition duration-200" title="Delete Appointment">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400 font-semibold">No appointments found matches the filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6" id="appointments-scroll-target">
                {{ $appointments->links('livewire::tailwind') }}
            </div>
        </div>
    @endif

    <!-- ================== 4. SUPPORT MESSAGES TAB SCREEN ================== -->
    @if ($activeTab === 'messages')
        <div class="bg-white border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.02)] rounded-3xl p-6">
            
            <!-- Filters and Search Bar -->
            <div class="mb-6 flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="relative w-full md:max-w-xs">
                    <input wire:model.live.debounce.300ms="messageSearch" type="text" placeholder="Search sender, email, subject, message..." 
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-rose-450 focus:ring-1 focus:ring-rose-400 focus:bg-white transition" />
                </div>

                <div class="flex items-center gap-4 w-full md:w-auto">
                    <select wire:model.live="messageFilter" 
                        class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:border-rose-450 focus:ring-1 focus:ring-rose-400 focus:bg-white transition w-full md:w-auto">
                        <option value="all">All Messages</option>
                        <option value="pending">Pending Status</option>
                        <option value="resolved">Resolved Status</option>
                    </select>
                </div>
            </div>

            <!-- List Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-widest text-[9px]">
                            <th class="py-4 px-3">Sender Details</th>
                            <th class="py-4 px-3">Date Received</th>
                            <th class="py-4 px-3">Inquiry Type</th>
                            <th class="py-4 px-3">Message Body</th>
                            <th class="py-4 px-3">Status</th>
                            <th class="py-4 px-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm font-semibold text-slate-700">
                        @forelse ($messages as $msg)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-rose-400/20 to-rose-600/10 text-rose-600 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                            {{ substr($msg->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-850 text-sm leading-none">{{ $msg->name }}</div>
                                            <span class="text-[10px] text-slate-400 font-semibold block mt-1">{{ $msg->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 font-medium text-slate-500">
                                    {{ $msg->created_at->diffForHumans() }}
                                </td>
                                <td class="py-4 px-3">
                                    <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-wider">
                                        {{ $msg->subject }}
                                    </span>
                                </td>
                                <td class="py-4 px-3 max-w-[280px] truncate text-slate-500 font-medium" title="{{ $msg->message }}">
                                    {{ $msg->message }}
                                </td>
                                <td class="py-4 px-3">
                                    @if ($msg->status === 'pending')
                                        <span class="bg-amber-50 text-amber-600 text-[9px] font-black uppercase px-2.5 py-1 rounded-md tracking-wider border border-amber-100/50">
                                            Pending
                                        </span>
                                    @else
                                        <span class="bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase px-2.5 py-1 rounded-md tracking-wider border border-emerald-100/50">
                                            Resolved
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-3 text-right flex items-center justify-end gap-2.5">
                                    <button wire:click="toggleMessageStatus({{ $msg->id }})" 
                                            class="bg-slate-50 border border-slate-200 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-100 px-3 py-1.5 rounded-lg text-[10px] font-black tracking-widest transition-all duration-200 uppercase text-slate-600 whitespace-nowrap">
                                        {{ $msg->status === 'pending' ? 'Mark Resolved' : 'Mark Pending' }}
                                    </button>
                                    <button wire:click="deleteMessage({{ $msg->id }})" onclick="return confirm('Permanently delete this support message?')" class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition duration-200" title="Delete Message">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400 font-semibold">No support messages found matching the filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6" id="messages-scroll-target">
                {{ $messages->links('livewire::tailwind') }}
            </div>
        </div>
    @endif
</div>
