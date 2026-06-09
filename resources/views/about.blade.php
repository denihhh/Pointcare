<x-layout.layout title="About Us">

    {{-- Hero Section --}}
    <div class="w-full flex flex-col items-center pt-16 md:pt-24 px-4 text-center space-y-4">
        <span class="px-4 py-1.5 rounded-full text-xs font-black tracking-widest uppercase bg-rose-50 text-rose-600 border border-rose-100/80">
            About PointCare
        </span>
        <h1 class="text-4xl md:text-5xl font-black text-foreground tracking-tight max-w-2xl">
            Redefining Healthcare Through <span class="text-primary">Smart Automation</span>
        </h1>
        <p class="text-base text-muted-foreground max-w-xl font-medium leading-relaxed">
            PointCare is a next-generation clinical management ecosystem engineered to bridge the gap between healthcare practitioners and patient accessibility.
        </p>
        <div class="w-24 h-1 bg-primary/20 rounded-full pt-2"></div>
    </div>

    {{-- Content Core / Pillars --}}
    <div class="max-w-5xl mx-auto px-4 py-16 grid grid-cols-1 md:grid-cols-3 gap-8">
        
        {{-- Card 1: Patient-Centric Design --}}
        <div class="bg-card border border-border rounded-3xl p-8 shadow-sm space-y-4 bg-white">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
            </div>
            <h3 class="text-xl font-black text-foreground">Seamless Booking</h3>
            <p class="text-sm text-muted-foreground leading-relaxed">
                Eliminating scheduling overhead with dynamic, real-time time-slot allocation logic to optimize patient-doctor distribution without temporal overlapping.
            </p>
        </div>

        {{-- Card 2: Clinical Workflow --}}
        <div class="bg-card border border-border rounded-3xl p-8 shadow-sm space-y-4 bg-white">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                </svg>
            </div>
            <h3 class="text-xl font-black text-foreground">Data-Centric UI</h3>
            <p class="text-sm text-muted-foreground leading-relaxed">
                Empowering medical staff with high-level KPI dashboards. Instantly track daily consultation volumes and manage clinical workflows from a consolidated pane.
            </p>
        </div>

        {{-- Card 3: Enterprise Integrity --}}
        <div class="bg-card border border-border rounded-3xl p-8 shadow-sm space-y-4 bg-white">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.25 2.25 0 0 1 10.5 2.25h4.5a2.25 2.25 0 0 1 2.25 2.25m-10.5 0c-1.13 0-2.049.917-2.117 2.044a48.253 48.253 0 0 0-1.123.08M3.75 6.108c0-1.135.845-2.098 1.976-2.192a48.424 48.424 0 0 1 1.123-.08" />
                </svg>
            </div>
            <h3 class="text-xl font-black text-foreground">Immutable Auditing</h3>
            <p class="text-sm text-muted-foreground leading-relaxed">
                Utilizing state-based logical record processing to preserve comprehensive, clinical validation trails ensuring total data fidelity and compliance.
            </p>
        </div>

    </div>

    {{-- Technical Framework & Hardening Spotlight --}}
    <div class="w-full bg-slate-50 border-y border-slate-100 py-16 my-8">
        <div class="max-w-4xl mx-auto px-4 text-center space-y-6">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Technical Infrastructure Hardening</h2>
            <p class="text-sm text-slate-500 max-w-2xl mx-auto leading-relaxed font-medium">
                Engineered with security as a primary design parameter. PointCare incorporates advanced application-layer perimeters to enforce the protection of sensitive medical data assets.
            </p>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-left pt-6">
                <div class="p-4 bg-white border border-slate-200/60 rounded-2xl shadow-2xs">
                    <span class="text-xs font-black text-primary tracking-wider block mb-1">RBAC</span>
                    <span class="text-xs font-bold text-slate-700">Role-Based Access Logic</span>
                </div>
                <div class="p-4 bg-white border border-slate-200/60 rounded-2xl shadow-2xs">
                    <span class="text-xs font-black text-primary tracking-wider block mb-1">IDOR DEFENSE</span>
                    <span class="text-xs font-bold text-slate-700">Strict Resource Ownership</span>
                </div>
                <div class="p-4 bg-white border border-slate-200/60 rounded-2xl shadow-2xs">
                    <span class="text-xs font-black text-primary tracking-wider block mb-1">STATE LOGS</span>
                    <span class="text-xs font-bold text-slate-700">Automated Audit Observers</span>
                </div>
                <div class="p-4 bg-white border border-slate-200/60 rounded-2xl shadow-2xs">
                    <span class="text-xs font-black text-primary tracking-wider block mb-1">LIVEWIRE SPA</span>
                    <span class="text-xs font-bold text-slate-700">Reactive Component Isolation</span>
                </div>
            </div>
        </div>
    </div>

</x-layout.layout>