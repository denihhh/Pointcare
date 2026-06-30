@props([
    'patientCount' => 0, 
    'doctorCount' => 0, 
    'adminCount' => 0, 
    'appointmentCount' => 0, 
    'systemMetrics' => [], 
    'recentUsers' => collect()
])

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    
    <!-- Header diagnostics check status -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10 space-y-4 md:space-y-0 pb-6 border-b border-gray-200">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">System Infrastructure Overview</h1>
            <p class="text-slate-500 mt-1.5 font-medium text-sm">Real-time status check, server diagnostics, environment configs, and registry logs.</p>
        </div>

        <div class="flex items-center text-xs text-emerald-600 font-black bg-emerald-50 px-4 py-2.5 rounded-xl border border-emerald-100/50 shadow-2xs">
            <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full mr-2.5 animate-pulse"></span>
            ALL SYSTEMS OPERATIONAL
        </div>
    </div>

    <!-- Stats Ribbon -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-6 mb-10">
        <div class="bg-white border border-slate-100 p-6 rounded-3xl shadow-xs hover:-translate-y-0.5 transition duration-300">
            <p class="text-[9px] font-black text-slate-455 text-slate-450 tracking-widest mb-1.5 uppercase">Registered Patients</p>
            <p class="text-3xl font-black text-slate-900 leading-none">{{ $patientCount }}</p>
        </div>
        <div class="bg-white border border-slate-100 p-6 rounded-3xl shadow-xs hover:-translate-y-0.5 transition duration-300">
            <p class="text-[9px] font-black text-slate-455 text-slate-450 tracking-widest mb-1.5 uppercase">Medical Officers</p>
            <p class="text-3xl font-black text-slate-900 leading-none">{{ $doctorCount }}</p>
        </div>
        <div class="bg-white border border-slate-100 p-6 rounded-3xl shadow-xs hover:-translate-y-0.5 transition duration-300">
            <p class="text-[9px] font-black text-slate-455 text-slate-450 tracking-widest mb-1.5 uppercase">Administrative Staff</p>
            <p class="text-3xl font-black text-slate-900 leading-none">{{ $adminCount }}</p>
        </div>
        <div class="bg-white border border-slate-100 p-6 rounded-3xl shadow-xs hover:-translate-y-0.5 transition duration-300">
            <p class="text-[9px] font-black text-slate-455 text-slate-450 tracking-widest mb-1.5 uppercase">Total Booked Sessions</p>
            <p class="text-3xl font-black text-slate-900 leading-none">{{ $appointmentCount }}</p>
        </div>
    </div>

    <!-- Main diagnostics layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Server rack details -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white border border-slate-100 p-8 rounded-3xl shadow-xs">
                <h3 class="text-base font-black text-slate-800 mb-6 uppercase tracking-widest flex items-center gap-2">
                    Infrastructure Diagnostics
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs font-semibold">
                    <div class="p-4 bg-slate-50 border border-slate-100/50 rounded-2xl flex justify-between items-center">
                        <span class="text-slate-450 text-[10px] font-black uppercase tracking-wider">Laravel Core</span>
                        <span class="text-slate-800 font-extrabold bg-white border border-slate-100 px-2.5 py-1 rounded-lg">v{{ $systemMetrics['laravel_version'] }}</span>
                    </div>
                    <div class="p-4 bg-slate-50 border border-slate-100/50 rounded-2xl flex justify-between items-center">
                        <span class="text-slate-450 text-[10px] font-black uppercase tracking-wider">PHP Runtime</span>
                        <span class="text-slate-800 font-extrabold bg-white border border-slate-100 px-2.5 py-1 rounded-lg">v{{ $systemMetrics['php_version'] }}</span>
                    </div>
                    <div class="p-4 bg-slate-50 border border-slate-100/50 rounded-2xl flex justify-between items-center">
                        <span class="text-slate-455 text-slate-450 text-[10px] font-black uppercase tracking-wider">Environment</span>
                        <span class="text-rose-600 font-black bg-rose-50 border border-rose-100/50 px-2.5 py-1 rounded-lg">{{ $systemMetrics['environment'] }}</span>
                    </div>
                    <div class="p-4 bg-slate-50 border border-slate-100/50 rounded-2xl flex justify-between items-center">
                        <span class="text-slate-455 text-[10px] font-black uppercase tracking-wider">Database Driver</span>
                        <span class="text-slate-850 uppercase font-extrabold bg-white border border-slate-100 px-2.5 py-1 rounded-lg">{{ $systemMetrics['db_driver'] }}</span>
                    </div>
                    <div class="p-4 bg-slate-50 border border-slate-100/50 rounded-2xl flex justify-between items-center">
                        <span class="text-slate-450 text-[10px] font-black uppercase tracking-wider">Timezone Config</span>
                        <span class="text-slate-700 font-bold">{{ $systemMetrics['timezone'] }}</span>
                    </div>
                    <div class="p-4 bg-slate-50 border border-slate-100/50 rounded-2xl flex justify-between items-center">
                        <span class="text-slate-455 text-slate-450 text-[10px] font-black uppercase tracking-wider">Memory Allocation</span>
                        <span class="text-slate-700 font-bold">{{ $systemMetrics['memory_usage'] }}</span>
                    </div>
                </div>
                
                <div class="mt-6 p-4 bg-slate-900 rounded-2xl flex items-center justify-between text-white">
                    <div class="flex items-center gap-2">
                        <span class="text-amber-500">⚙️</span>
                        <span class="text-[10px] font-bold text-slate-400">DEBUG MODE STATUS</span>
                    </div>
                    <span class="text-[10px] font-black tracking-widest px-2.5 py-1 rounded-lg {{ $systemMetrics['debug_mode'] === 'ENABLED' ? 'bg-amber-500/20 text-amber-400' : 'bg-slate-800 text-slate-400' }}">
                        {{ $systemMetrics['debug_mode'] }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Registration timeline -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white border border-slate-100 p-6 rounded-3xl shadow-xs">
                <h3 class="font-black text-slate-900 mb-4 uppercase tracking-widest text-xs">New Registrations</h3>
                <div class="space-y-4">
                    @foreach ($recentUsers as $user)
                        <div class="flex items-center space-x-3.5 pb-3 border-b border-slate-50 last:border-0 last:pb-0">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-rose-400 to-rose-600 flex items-center justify-center text-white font-bold text-xs">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-bold text-slate-800 truncate leading-none mb-1">{{ $user->name }}</p>
                                <span class="text-[9px] font-semibold text-slate-450 block truncate leading-none">{{ $user->email }}</span>
                            </div>
                            <div>
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-600 text-[8px] font-black uppercase tracking-wider">{{ $user->role }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
