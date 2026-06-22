<div x-data="{ show: false }"
     @scroll.window="show = (window.pageYOffset > 400) ? true : false"
     class="fixed bottom-8 right-8 z-60 print:hidden">


    <button x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-10"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-10"
            @click="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="bg-rose-500 hover:bg-rose-600 text-white p-4 rounded-2xl shadow-2xl hover:shadow-rose-500/50 transition-all group focus:outline-none"
            aria-label="Scroll to top"
            x-cloak>

        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-6 w-6 group-hover:-translate-y-1 transition-transform"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="3"
                  d="M5 15l7-7 7 7" />
        </svg>
    </button>
</div>
