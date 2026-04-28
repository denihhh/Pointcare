<x-layout title="My Appointments">
    <x-return/>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mt-8 mb-10 gap-y-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Appointment Portal</h1>
                <p class="text-slate-500 font-medium mt-1">Manage and track your clinical consultations</p>
            </div>

            <div class="flex items-center space-x-3 bg-rose-50 px-4 py-2 rounded-2xl border border-rose-100">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                </span>
                <span class="text-rose-700 text-xs font-black uppercase tracking-widest">
                    {{ now()->format('D, d M Y') }}
                </span>
            </div>
        </div>

        <div class="bg-white shadow-[0_20px_50px_rgba(0,0,0,0.04)] rounded-[2.5rem] border border-slate-100 overflow-hidden">

            <div class="p-8 sm:p-12">
                @if($appointments->isEmpty())
                    <div class="py-16 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-slate-50 rounded-full mb-6">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">No appointments scheduled</h3>
                        <p class="text-slate-500 mt-2 max-w-xs mx-auto text-sm">Your clinical schedule is currently clear. Ready to book your first consultation?</p>

                        <a href="/appointments/create" class="inline-flex mt-8 bg-rose-500 text-white px-8 py-4 rounded-2xl font-black shadow-lg shadow-rose-200 hover:bg-rose-600 transition-all hover:-translate-y-1">
                            Book First Appointment
                        </a>
                    </div>
                @else
                    <div class="mb-8 flex items-center justify-between">
                        <h3 class="text-lg font-black text-slate-800 uppercase tracking-tighter italic">Schedule Details</h3>
                        <a href="/appointments/create"
                           data-test="new-appointment-btn"
                           class="hidden sm:flex items-center bg-slate-900 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-rose-600 transition-all active:scale-95 shadow-lg shadow-slate-200">
                           <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                           New Appointment
                        </a>
                    </div>

                    <div class="overflow-hidden">
                        <x-table :appointments="$appointments" role="patient" />
                    </div>
                @endif
            </div>
        </div>

        <div class="sm:hidden fixed bottom-8 left-6 z-50">
            <a href="/appointments/create"
               class="flex items-center justify-center w-14 h-14 bg-rose-500 text-white rounded-full shadow-2xl shadow-rose-300 active:scale-90 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
            </a>
        </div>
    </div>
</x-layout>
