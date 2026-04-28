@props(['to' => 'home'])

<div class="w-full bg-transparent">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
        <a href="{{ route($to) }}" class="inline-flex items-center group relative">
            <div class="absolute -inset-y-2 -inset-x-4 scale-95 bg-rose-50 rounded-full opacity-0 group-hover:opacity-100 group-hover:scale-100 transition-all duration-200"></div>

            <div class="relative flex items-center text-slate-500 group-hover:text-rose-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="text-[10px] font-black uppercase tracking-widest">Return to {{ str_replace('.', ' ', $to) }}</span>
            </div>
        </a>
    </div>
</div>
