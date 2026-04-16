{{-- <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round"
                     d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />

            </svg> --}}
<div x-data="{ open: false }" @click.away="open = false" class="relative flex justify-center">

    <button @click="open = !open" type="button"
        class="relative p-2 text-gray-500 hover:text-primary transition-all duration-300 rounded-full hover:bg-gray-100 focus:outline-none">

        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>

        <span class="absolute top-2 right-2 flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
        </span>
    </button>

    <div x-show="open" style="display: none;"
        class="absolute right-0 mt-12 w-80 z-50 overflow-hidden bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/60 ring-1 ring-black/5">
        <div class="p-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-sm font-bold text-gray-900">Notifications</h3>
            <span class="text-[10px] bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-bold uppercase">
                2 New
            </span>
        </div>

        <div class="max-h-96 overflow-y-auto">
            <div class="p-4 hover:bg-white/50 transition-colors border-b border-gray-50">
                <p class="text-sm text-gray-800">
                    Your appointment with <strong>Dr. Danish</strong> has been confirmed.
                </p>
                <span class="text-[10px] text-gray-400 mt-1 block">2 minutes ago</span>
            </div>

            <div class="p-4 hover:bg-white/50 transition-colors border-b border-gray-50">
                <p class="text-sm text-gray-800">
                    New message from the clinical administration.
                </p>
                <span class="text-[10px] text-gray-400 mt-1 block">1 hour ago</span>
            </div>
        </div>

        <a href="/notifications" class="block py-3 text-center text-xs font-bold text-red-500 hover:bg-red-50 transition-colors border-t border-gray-100">
            View All Notifications
        </a>
    </div>
</div>
