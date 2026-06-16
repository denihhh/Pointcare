<nav x-data="{ open: false }" class="pt-4 px-4">
    <div
        class="max-w-7xl mx-auto bg-white/90 backdrop-blur-xl border border-rose-100 rounded-3xl shadow-lg shadow-rose-100/30">
        <div class="px-6 lg:px-8">
            <div class="flex items-center justify-between h-18">

                <a href="/" class="flex items-center group">
                    <div
                        class="w-11 h-11 rounded-2xl bg-gradient-to-br from-rose-500 to-rose-600 flex items-center justify-center shadow-md">
                        <x-logo.weblogo class="h-6 w-6 text-white" />
                    </div>
                    <div class="ml-3">
                        <p class="text-lg font-black text-slate-900 tracking-tight">PointCare</p>
                        <p class="text-xs text-slate-500 -mt-0.5">Smart Healthcare</p>
                    </div>
                </a>

                <div class="hidden md:flex items-center">
                    <div class="flex items-center gap-2 bg-slate-50 border border-slate-100 rounded-2xl p-1">
                        <a href="/"
                            class="px-5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->is('/') ? 'bg-white text-rose-600 shadow-xs' : 'text-slate-600 hover:bg-white hover:text-rose-600' }}">Home</a>
                        <a href="/about"
                            class="px-5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->is('about*') ? 'bg-white text-rose-600 shadow-xs' : 'text-slate-600 hover:bg-white hover:text-rose-600' }}">About</a>
                        <a href="/contact"
                            class="px-5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->is('contact*') ? 'bg-white text-rose-600 shadow-xs' : 'text-slate-600 hover:bg-white hover:text-rose-600' }}">Contact</a>
                    </div>
                </div>

                <div class="hidden md:flex items-center gap-4">
                    <a href="/login" class="text-sm font-bold text-slate-600 hover:text-rose-600 transition">Login</a>
                    <a href="/register"
                        class="bg-primary text-white text-sm font-black px-5 py-2.5 rounded-xl shadow-xs hover:opacity-90 transition">Get
                        Started</a>
                </div>

                <button @click="open = !open" class="md:hidden p-2 rounded-xl hover:bg-slate-100 transition">
                    <svg x-show="!open" class="h-6 w-6 text-slate-700" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" x-cloak class="h-6 w-6 text-slate-700" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div x-show="open" x-transition x-cloak class="md:hidden border-t border-slate-100 p-4 bg-white rounded-b-3xl">
            <div class="space-y-1 pb-3">
                <a href="/"
                    class="block px-4 py-2.5 rounded-xl text-sm font-semibold {{ request()->is('/') ? 'bg-rose-50 text-rose-600' : 'text-slate-700 hover:bg-rose-50' }}">Home</a>
                <a href="/about"
                    class="block px-4 py-2.5 rounded-xl text-sm font-semibold {{ request()->is('about*') ? 'bg-rose-50 text-rose-600' : 'text-slate-700 hover:bg-rose-50' }}">About</a>
                <a href="/contact"
                    class="block px-4 py-2.5 rounded-xl text-sm font-semibold {{ request()->is('contact*') ? 'bg-rose-50 text-rose-600' : 'text-slate-700 hover:bg-rose-50' }}">Contact</a>
            </div>
            <div class="border-t border-slate-100 pt-4 flex flex-col gap-2">
                <a href="/login"
                    class="w-full text-center py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 transition">Login</a>
                <a href="/register"
                    class="w-full text-center bg-primary text-white text-sm font-black py-2.5 rounded-xl shadow-xs">Get
                    Started</a>
            </div>
        </div>
    </div>
</nav>