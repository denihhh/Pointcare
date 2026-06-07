<nav x-data="{ open: false }" class="pt-2 px-4">
    <div
        class="max-w-7xl mx-auto bg-white/90 backdrop-blur-xl border border-rose-100 rounded-3xl shadow-lg shadow-rose-100/50">

        <div class="px-6 lg:px-8">
            <div class="flex items-center justify-between h-18">

                <!-- Logo -->
                <a href="/" class="flex items-center group">
                    <div
                        class="w-11 h-11 rounded-2xl bg-gradient-to-br from-rose-500 to-rose-600 flex items-center justify-center shadow-md">
                        <x-logo.weblogo class="h-6 w-6 text-white" />
                    </div>

                    <div class="ml-3">
                        <p class="text-lg font-black text-slate-900">
                            PointCare
                        </p>
                        <p class="text-xs text-slate-500">
                            Smart Healthcare
                        </p>
                    </div>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center">
                    <div
                        class="flex items-center gap-2 bg-slate-50 border border-slate-100 rounded-2xl p-1">

                        <a href="/"
                            class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-white hover:text-rose-600 transition">
                            Home
                        </a>

                        <a href="/about"
                            class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-white hover:text-rose-600 transition">
                            About
                        </a>

                        <a href="/contact"
                            class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-white hover:text-rose-600 transition">
                            Contact
                        </a>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="flex items-center gap-4">

                    <x-layout.profilenav />

                    <!-- Mobile Toggle -->
                    <button
                        @click="open = !open"
                        class="md:hidden p-2 rounded-xl hover:bg-slate-100 transition">

                        <svg x-show="!open"
                            class="h-6 w-6 text-slate-700"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>

                        <svg x-show="open"
                            x-cloak
                            class="h-6 w-6 text-slate-700"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="open"
            x-transition
            x-cloak
            class="md:hidden border-t border-slate-100 p-4">

            <div class="space-y-2">
                <a href="/"
                    class="block px-4 py-3 rounded-xl hover:bg-rose-50 hover:text-rose-600 font-medium">
                    Home
                </a>

                <a href="/about"
                    class="block px-4 py-3 rounded-xl hover:bg-rose-50 hover:text-rose-600 font-medium">
                    About
                </a>

                <a href="/contact"
                    class="block px-4 py-3 rounded-xl hover:bg-rose-50 hover:text-rose-600 font-medium">
                    Contact
                </a>
            </div>
        </div>
    </div>
</nav>