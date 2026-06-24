{{-- Sidebar Component Layer Container --}}
<div class="print:hidden">

    {{-- 1. Mobile Drawer Backdrop Overlay (Alpine-controlled) --}}
    <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs md:hidden"
        @click="sidebarOpen = false" x-cloak></div>

    {{-- 2. Sidebar Navigation Panel --}}
    <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col bg-white border-r border-rose-100 transition-transform duration-300 ease-in-out lg:translate-x-0"
        x-cloak>

        {{-- Top Brand Identity Panel --}}
        <div class="flex h-20 items-center border-b border-rose-50 px-6 justify-between">
            <a href="/" class="flex items-center group">
                <div
                    class="w-9 h-9 rounded-xl bg-gradient-to-br from-rose-500 to-rose-600 flex items-center justify-center shadow-xs group-hover:opacity-95 transition">
                    <x-logo.weblogo class="h-5 w-5 text-white" />
                </div>
                <div class="ml-3">
                    <p class="text-base font-black text-slate-900 tracking-tight">PointCare</p>
                    <span class="text-[10px] text-primary font-black uppercase tracking-widest block -mt-0.5">
                        {{ auth()->user()->role === 'admin' ? 'Admin Portal' : (auth()->user()->role === 'patient' ? 'Patient Portal' : 'Clinical Desk') }}
                    </span>
                </div>
            </a>

            <livewire:notification-bell />

            {{-- Close drawer handle for small mobile screens --}}
            <button @click="sidebarOpen = false" class="p-1 rounded-lg hover:bg-red-50 lg:hidden text-slate-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Dynamic Navigation Options Lists --}}
        <nav class="flex-1 space-y-6 px-4 py-6 overflow-y-auto">

            {{-- Category 1: Overview (SHARED BETWEEN PATIENT & ADMIN) --}}
            @if (auth()->user()->role !== 'doctor')
                <div class="space-y-1">
                    <span
                        class="px-3 text-[10px] font-black tracking-widest text-slate-400 uppercase block mb-2">General</span>

                    <a href="/"
                        class="group flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ request()->is('/') ? 'bg-rose-50 text-rose-600' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        System Overview
                    </a>
                </div>
            @endif

            {{-- PATIENT ONLY PERIMETERS --}}
            @if (auth()->user()->role === 'patient')
                {{-- Category 2: Clinical Operations --}}
                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-black tracking-widest text-slate-400 uppercase block mb-2">Clinical
                        Apps</span>

                    <a href="/dashboard"
                        class="group flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ request()->is('dashboard') ? 'bg-rose-50 text-rose-600' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg>
                        My Bookings
                    </a>

                    <a href="/records"
                        class="group flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ (request()->is('records') || (auth()->user()->role === 'patient' && request()->is('appointments/*/record'))) ? 'bg-rose-50 text-rose-600' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.25 2.25 0 0 1 10.5 2.25h4.5a2.25 2.25 0 0 1 2.25 2.25m-10.5 0c-1.13 0-2.049.917-2.117 2.044a48.253 48.253 0 0 0-1.123.08M3.75 6.108c0-1.135.845-2.098 1.976-2.192a48.424 48.424 0 0 1 1.123-.08" />
                        </svg>
                        Pass Records
                    </a>

                    {{-- Fast Scheduling Trigger --}}
                    <div class="pt-3 px-1">
                        <a href="/appointments/create"
                            class="w-full flex items-center justify-center gap-2 bg-primary text-white text-xs font-black py-3 px-4 rounded-xl shadow-xs hover:opacity-90 transition tracking-wider uppercase">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Book Session
                        </a>
                    </div>
                </div>

                {{-- Category 3: Security & Infrastructure --}}
                <div class="space-y-1">
                    <span
                        class="px-3 text-[10px] font-black tracking-widest text-slate-400 uppercase block mb-2">Profile</span>

                    {{-- My Profile (Connected: /profile) --}}
                    <a href="/profile"
                        class="group flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ request()->is('profile') ? 'bg-rose-50 text-rose-600' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        My Profile
                    </a>

                    <a href="{{ route('profile.account-settings') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ request()->routeIs('profile.account-settings') ? 'bg-rose-50 text-rose-600' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.43l-1.003.828c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.43l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.991l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        Account Settings
                    </a>
                </div>
            @endif

            {{-- ADMIN ONLY PERIMETERS --}}
            @if (auth()->user()->role === 'admin')
                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-black tracking-widest text-slate-400 uppercase block mb-2">Admin Panel</span>

                    <a href="/admin/dashboard"
                        class="group flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ request()->is('admin/dashboard*') ? 'bg-rose-50 text-rose-600' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                        </svg>
                        Admin Dashboard
                    </a>

                    <a href="{{ route('profile.account-settings') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ request()->routeIs('profile.account-settings') ? 'bg-rose-50 text-rose-600' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.43l-1.003.828c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.43l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.991l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        Account Settings
                    </a>
                </div>
            @endif

            {{-- DOCTOR ONLY PERIMETERS --}}
            @if (auth()->user()->role === 'doctor')
                {{-- GENERAL --}}
                <div class="space-y-1">
                    <span
                        class="px-3 text-[10px] font-black tracking-widest text-slate-400 uppercase block mb-2">GENERAL</span>

                    <a href="/"
                        class="group flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ request()->is('/') ? 'bg-rose-50 text-rose-600' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        System Overview
                    </a>
                    {{-- Dashboard (Connected: /dashboard) --}}
                    <a href="/dashboard"
                        class="group flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ request()->is('dashboard') ? 'bg-rose-50 text-rose-600' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                        </svg>
                        Booking List
                    </a>

                    {{-- Calendar / Schedule (Connected: /schedule) --}}
                    <a href="/schedule"
                        class="group flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ request()->is('schedule*') ? 'bg-rose-50 text-rose-600' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg>
                        Calendar / Schedule
                    </a>
                </div>

                {{-- CLINICAL APP --}}
                <div class="space-y-1">
                    <span class="px-3 text-[10px] font-black tracking-widest text-slate-400 uppercase block mb-2">CLINICAL
                        APP</span>

                    {{-- Patients (Connected: /patients) --}}
                    <a href="/patients"
                        class="group flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ request()->is('patients*') ? 'bg-rose-50 text-rose-600' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A2.25 2.25 0 0 1 12.75 21.5h-1.5a2.25 2.25 0 0 1-2.25-2.263v-.11m0-.003c0-1.113.285-2.16.786-3.07M9.75 19.128a9.38 9.38 0 0 1-2.625.372 9.337 9.337 0 0 1-4.121-.952 4.125 4.125 0 0 1 7.533-2.493M9.75 19.128v-.003a9.3 9.3 0 0 0 4.464-3.07M12 11.25a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" />
                        </svg>
                        Patients
                    </a>

                    {{-- Clinical Records (Connected: /clinical-records) --}}
                    <a href="/clinical-records"
                        class="group flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ (request()->is('clinical-records*') || (auth()->user()->role === 'doctor' && request()->is('appointments/*/record'))) ? 'bg-rose-50 text-rose-600' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        Clinical Records
                    </a>
                </div>

                {{-- PROFILE --}}
                <div class="space-y-1">
                    <span
                        class="px-3 text-[10px] font-black tracking-widest text-slate-400 uppercase block mb-2">PROFILE</span>

                    {{-- My Profile (Connected: /profile) --}}
                    <a href="/profile"
                        class="group flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ request()->is('profile') ? 'bg-rose-50 text-rose-600' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        My Profile
                    </a>

                    {{-- Account Settings (Placeholder - TODO) --}}
                    <a href="{{ route('profile.account-settings') }}"
                        class="group flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ request()->routeIs('profile.account-settings') ? 'bg-rose-50 text-rose-600' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.43l-1.003.828c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.43l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.991l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        Account Settings
                    </a>
                </div>
            @endif

        </nav>

        {{-- Footer Identity Section --}}
        <div class="border-t border-rose-50 p-4 bg-slate-50/60">
            <div class="flex items-center justify-between gap-2">
                <div class="min-w-0 flex-1">
                    <p class="truncate text-xs font-black text-slate-800 tracking-tight">{{ auth()->user()->name }}</p>
                    <p class="truncate text-[9px] font-bold text-slate-400 uppercase tracking-tight">
                        {{ auth()->user()->email }}
                    </p>
                </div>

                {{-- Secure Logout Action --}}
                <form action="/logout" method="POST" class="m-0 p-0 flex-shrink-0">
                    @csrf
                    <button type="submit"
                        class="p-2.5 rounded-xl border border-slate-200 bg-white text-slate-400 hover:text-rose-600 hover:border-rose-200 transition shadow-2xs"
                        title="Secure Terminate Session">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>