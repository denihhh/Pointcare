@props(['title', 'description'])

<div class="-mt-8 min-h-screen bg-rose-50/30 flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden">
    <div class="absolute top-24 left-24 w-96 h-96 bg-rose-200/50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-pulse"></div>
    <div class="absolute bottom-24 right-24 w-96 h-96 bg-indigo-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-pulse delay-700"></div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10">
        <div class="items-center space-x-6 mb-8 px-4 sm:px-0">
            <div class="text-center">
                <h2 class="text-3xl font-black text-slate-900 tracking-tight leading-tight">
                    {{ $title }}
                </h2>
                <p class="mt-1 text-sm text-slate-500 font-medium">
                    {{ $description }}
                </p>
            </div>
        </div>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-xl relative z-10 px-4">
        <div class="bg-white py-10 px-6 shadow-[0_20px_50px_rgba(244,63,94,0.1)] sm:rounded-[2.5rem] sm:px-12 border border-rose-100/50">
            {{ $slot }}

            <div class="mt-8">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-100"></div>
                    </div>
                    <div class="relative flex justify-center text-[10px]">
                        <span class="px-4 bg-white text-slate-400 font-black uppercase tracking-widest">PointCare Secure</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-center space-x-8">
            <div class="flex items-center text-slate-400">
                <svg class="w-4 h-4 mr-1.5 text-rose-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span class="text-[10px] font-bold uppercase tracking-tighter">SSL Verified</span>
            </div>
            <div class="flex items-center text-slate-400">
                <svg class="w-4 h-4 mr-1.5 text-rose-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <span class="text-[10px] font-bold uppercase tracking-tighter">Encrypted</span>
            </div>
        </div>
    </div>
</div>
