<nav x-data="{ open: false }" class="border-b border-border px-6 ">
    <div class="max-w-7xl mx-auto flex items-center justify-between h-16">

        <!-- Logo Section -->
        <div class="flex items-center">
            <a href="/" class="flex items-center group">
                <x-logo.weblogo class="h-8 w-auto md:h-10 text-rose-600 transition-transform group-hover:scale-105" />
                <p class="ml-2 text-xl font-black text-slate-800 tracking-tight">PointCare</p>
            </a>
        </div>

        <!-- Navigation Links -->
        <div class="hidden md:flex items-center gap-x-8">
            <a href="/" class="text-sm font-semibold text-slate-600 hover:text-rose-500 transition-colors">Home</a>
            <a href="/about" class="text-sm font-semibold text-slate-600 hover:text-rose-500 transition-colors">About</a>
            <a href="/contact" class="text-sm font-semibold text-slate-600 hover:text-rose-500 transition-colors">Contact</a>
        </div>

        <!-- User Actions -->
        <div class="flex items-center space-x-4">
            <x-layout.profilenav />

            <button @click="open = !open" class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 transition-colors">
                <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         @click.away="open = false"
         class="md:hidden border-t border-slate-100 py-4 space-y-2"
         x-cloak>
        <a href="/" class="block px-4 py-2 text-base font-medium text-slate-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg">Home</a>
        <a href="/about" class="block px-4 py-2 text-base font-medium text-slate-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg">About</a>
        <a href="/contact" class="block px-4 py-2 text-base font-medium text-slate-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg">Contact</a>
    </div>

</nav>


