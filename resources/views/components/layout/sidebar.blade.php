{{-- Sidebar Component Layer Container --}}
<div>
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
                        {{ auth()->user()->role === 'patient' ? 'Patient Portal' : 'Clinical Desk' }}
                    </span>
                </div>
            </a>
            
            {{-- Close drawer handle for small mobile screens --}}
            <button @click="sidebarOpen = false" class="p-1 rounded-lg hover:bg-slate-50 lg:hidden text-slate-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Dynamic Navigation Options Lists --}}
        <nav class="flex-1 space-y-6 px-4 py-6 overflow-y-auto">

            {{-- Category 1: Overview (SHARED BETWEEN PATIENT & DOCTOR) --}}
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

            {{-- PATIENT ONLY PERIMETERS --}}
            @if (auth()->user()->role === 'patient')
                {{-- Category 2: Clinical Operations --}}
                <div class="space-y-1">
                    <span
                        class="px-3 text-[10px] font-black tracking-widest text-slate-400 uppercase block mb-2">Clinical
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
                        class="group flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ request()->is('records') ? 'bg-rose-50 text-rose-600' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
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
                            class="w-full flex items-center justify-center gap-2 bg-primary text-white text-xs font-black py-3 px-4 rounded-xl shadow-xs hover:opacity-95 transition tracking-wider uppercase">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Book Session
                        </a>
                    </div>
                </div>

                {{-- Category 3: Security & Infrastructure --}}
                <div class="space-y-1">
                    <span
                        class="px-3 text-[10px] font-black tracking-widest text-slate-400 uppercase block mb-2">Account
                        Perimeter</span>

                    <a href="/security"
                        class="group flex items-center gap-3 px-3 py-2.5 text-sm font-bold rounded-xl transition-all {{ request()->is('security*') ? 'bg-rose-50 text-rose-600' : 'text-slate-600 hover:bg-slate-50/80 hover:text-slate-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.956 11.956 0 0112 2.714z" />
                        </svg>
                        Session Integrity
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
                        {{ auth()->user()->email }}</p>
                </div>

                {{-- Secure Logout Action --}}
                <form action="/logout" method="POST" class="m-0 p-0 flex-shrink-0">
                    @csrf
                    <button type="submit"
                        class="p-2.5 rounded-xl border border-slate-200 bg-white text-slate-400 hover:text-rose-600 hover:border-rose-200 transition shadow-2xs"
                        title="Secure Terminate Session">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
