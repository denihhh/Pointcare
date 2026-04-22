<x-layout.layout>

    <div class="py-12 px-6">
        @auth
            <x-layout.homepage
            :upcomingAppointment="$upcomingAppointment"
            :todayCount="$todayCount"
            :pendingCount="$pendingCount"
            />
        @else
            <div class="relative pt-16 pb-32">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="lg:grid lg:grid-cols-12 lg:gap-8">

                        <div
                            class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left flex flex-col justify-center">
                            <x-animation>
                                <span
                                    class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-bold bg-rose-100 text-rose-600 uppercase tracking-widest mb-4">
                                    PointCare
                                </span>
                                <h1 class="text-5xl font-black text-slate-900 leading-tight mb-6">
                                    Healthcare Management <br />
                                    <span class="text-rose-500">Simplified.</span>
                                </h1>
                                <p class="text-lg text-slate-500 mb-10 leading-relaxed">
                                    PointCare connects patients and doctors through a seamless, automated booking
                                    experience. Manage appointments, clinical records, and patient queues in one centralized
                                    dashboard.
                                </p>
                                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                                    <a href="/register"
                                        class="flex items-center justify-center px-8 py-4 text-base font-bold rounded-2xl text-white bg-slate-900 hover:bg-slate-800 shadow-xl transition-all hover:-translate-y-1">
                                        Get Started Free
                                    </a>
                                    <a href="/login"
                                        class="flex items-center justify-center px-8 py-4 text-base font-bold rounded-2xl text-white bg-rose-500 hover:bg-rose-600 border border-slate-200 transition-all">
                                        Member Login
                                    </a>
                                </div>
                            </x-animation>
                        </div>

                        <div class="mt-16 sm:mt-24 lg:mt-0 lg:col-span-6">
                            <x-animation delay="300">
                                <div class="relative mx-auto w-full max-w-md lg:max-w-none">
                                    <div
                                        class="absolute -top-10 -left-10 w-64 h-64 bg-rose-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse">
                                    </div>
                                    <div
                                        class="absolute -bottom-10 -right-10 w-64 h-64 bg-cyan-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse delay-700">
                                    </div>

                                    <div
                                        class="relative bg-white border border-slate-100 rounded-[2.5rem] shadow-2xl p-8 transform rotate-2 hover:rotate-0 transition-transform duration-500">
                                        <div class="flex items-center space-x-4 mb-6">
                                            <div
                                                class="w-12 h-12 bg-rose-500 rounded-xl flex items-center justify-center text-white font-bold">
                                                +</div>
                                            <div class="space-y-1">
                                                <div class="h-2 w-24 bg-slate-200 rounded"></div>
                                                <div class="h-2 w-16 bg-slate-100 rounded"></div>
                                            </div>
                                        </div>
                                        <div class="space-y-4">
                                            <div
                                                class="h-32 bg-slate-50 rounded-2xl border border-dashed border-slate-200 flex items-center justify-center">
                                                <span class="text-slate-300 font-bold italic">Dashboard Preview</span>
                                            </div>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div class="h-16 bg-cyan-50 rounded-xl"></div>
                                                <div class="h-16 bg-rose-50 rounded-xl"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </x-animation>
                        </div>
                    </div>
                </div>
            </div>
        @endauth
    </div>
</x-layout.layout>
