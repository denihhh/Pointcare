<x-layout title="My Profile">
    <x-return />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">

        {{-- ═══════════════════════════════════════════════════════════════════ --}}
        {{--  GLOBAL USER IDENTITY CARD (Shared by Both Roles)                 --}}
        {{-- ═══════════════════════════════════════════════════════════════════ --}}
        <x-animation>
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden mb-8 sm:mb-10">
                {{-- Banner Accent Backdrop --}}
                <div class="h-40 sm:h-48 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 relative overflow-hidden">
                    {{-- Decorative Orbs --}}
                    <div class="absolute top-0 right-0 w-72 h-72 -mr-16 -mt-16 rounded-full opacity-[0.15]
                        {{ auth()->user()->role === 'patient' ? 'bg-rose-500' : 'bg-emerald-500' }}">
                    </div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 -ml-12 -mb-12 rounded-full opacity-[0.08]
                        {{ auth()->user()->role === 'patient' ? 'bg-cyan-400' : 'bg-rose-400' }}">
                    </div>
                    <div class="absolute top-0 left-1/2 w-96 h-96 -translate-x-1/2 -mt-64 rounded-full opacity-[0.04] bg-white"></div>
                    <div class="absolute top-4 left-6 sm:left-8">
                        <span class="bg-white/10 backdrop-blur-sm text-white/70 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">
                            PointCare Profile
                        </span>
                    </div>
                </div>

                {{-- Avatar + Identity Details --}}
                <div class="px-5 sm:px-8 pb-6 sm:pb-8 pt-4 sm:pt-6 relative">
                    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                        <div class="flex items-end gap-4 sm:gap-5">
                            {{-- Avatar Placeholder Wrapper --}}
                            <div class="relative w-16 h-16 sm:w-20 sm:h-20 shrink-0 z-10">
                                <div class="absolute -top-10 sm:-top-14 left-0 w-16 h-16 sm:w-20 sm:h-20 rounded-2xl flex items-center justify-center text-2xl sm:text-3xl font-black shadow-md border-4 border-white
                                    {{ auth()->user()->role === 'patient'
                                        ? 'bg-gradient-to-br from-rose-500 to-rose-600 text-white'
                                        : 'bg-gradient-to-br from-emerald-500 to-emerald-600 text-white' }}">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', auth()->user()->name)[1] ?? '', 0, 1)) }}
                                </div>
                            </div>

                            <div class="mb-1 sm:mb-2">
                                {{-- Full Name --}}
                                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight leading-tight">
                                    {{ auth()->user()->name }}
                                </h1>
                                <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                    {{-- Dynamic Role Badge --}}
                                    @if(auth()->user()->role === 'patient')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-rose-100 text-rose-600 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span>
                                            Patient Portal
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-100 text-emerald-600 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                            Clinical Specialist
                                        </span>
                                    @endif
                                    {{-- Member Since --}}
                                    <span class="text-xs text-slate-400 font-medium">
                                        Member since {{ auth()->user()->created_at->format('F Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Email Quick Info --}}
                        <div class="hidden sm:flex items-center gap-2 mb-1 sm:mb-2">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <span class="text-sm text-slate-500 font-medium">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </x-animation>

        {{-- ═══════════════════════════════════════════════════════════════════ --}}
        {{--  ROLE-SPECIFIC CONTENT SECTIONS                                   --}}
        {{-- ═══════════════════════════════════════════════════════════════════ --}}

        @if(auth()->user()->role === 'patient')
            {{-- ─────────────────────────────────────────────────────────────── --}}
            {{--  PATIENT LAYOUT                                                --}}
            {{-- ─────────────────────────────────────────────────────────────── --}}
            <div class="space-y-6">

                {{-- CONTENT SECTIONS: Vitals + Medical --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">

                    {{-- Section 1: Personal Vital Ledger --}}
                    <x-animation delay="100">
                        <div class="bg-white rounded-[1.75rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden">
                            <div class="px-6 sm:px-8 pt-6 sm:pt-8 pb-2">
                                <div class="flex items-center gap-3 mb-1">
                                    <div class="w-9 h-9 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-bold text-slate-800">Personal Vital Ledger</h2>
                                        <p class="text-xs text-slate-400 font-medium">Your core personal health identifiers</p>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('profile.patient-info') }}" method="POST" class="px-6 sm:px-8 pb-6 sm:pb-8">
                                @csrf

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1 mt-4">
                                    {{-- Date of Birth --}}
                                    <div class="space-y-1.5 mb-5">
                                        <label for="date_of_birth" class="block text-sm font-black text-slate-700 tracking-tight ml-1">Date of Birth</label>
                                        <input type="date" id="date_of_birth" name="date_of_birth"
                                            value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d') ?? '') }}"
                                            class="w-full px-4 py-3 rounded-xl border transition-all duration-200 outline-none focus:ring-4 min-h-[44px]
                                                {{ $errors->has('date_of_birth')
                                                    ? 'border-red-500 bg-red-50 focus:ring-red-100 text-red-900'
                                                    : 'border-slate-200 bg-slate-50/50 focus:border-rose-500 focus:ring-rose-100 text-slate-900' }}">
                                        @error('date_of_birth')
                                            <div class="flex items-center space-x-1 ml-1 mt-1">
                                                <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                                <p class="text-red-500 text-[11px] font-bold italic uppercase tracking-wider leading-none">{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- Gender --}}
                                    <div class="space-y-1.5 mb-5">
                                        <label for="gender" class="block text-sm font-black text-slate-700 tracking-tight ml-1">Gender</label>
                                        <select id="gender" name="gender"
                                            class="w-full px-4 py-3 rounded-xl border transition-all duration-200 outline-none focus:ring-4 min-h-[44px] appearance-none bg-no-repeat bg-[right_1rem_center] bg-[length:1rem]
                                                {{ $errors->has('gender')
                                                    ? 'border-red-500 bg-red-50 focus:ring-red-100 text-red-900'
                                                    : 'border-slate-200 bg-slate-50/50 focus:border-rose-500 focus:ring-rose-100 text-slate-900' }}"
                                            style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 24 24%27 stroke-width=%272%27 stroke=%27%2394a3b8%27%3e%3cpath stroke-linecap=%27round%27 stroke-linejoin=%27round%27 d=%27m19.5 8.25-7.5 7.5-7.5-7.5%27/%3e%3c/svg%3e')">
                                            <option value="" {{ old('gender', $user->gender) === null ? 'selected' : '' }}>Select gender</option>
                                            <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('gender', $user->gender) === 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('gender')
                                            <div class="flex items-center space-x-1 ml-1 mt-1">
                                                <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                                <p class="text-red-500 text-[11px] font-bold italic uppercase tracking-wider leading-none">{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- Emergency Contact Name --}}
                                    <x-form.field label="Emergency Contact Name" name="emergency_contact_name" :value="$user->emergency_contact_name" placeholder="Full name of emergency contact" />

                                    {{-- Emergency Contact Phone --}}
                                    <x-form.field label="Emergency Contact Phone" name="emergency_contact_phone" type="tel" :value="$user->emergency_contact_phone" placeholder="+60 12-345 6789" />
                                </div>

                                <div class="flex justify-end pt-2">
                                    <button type="submit"
                                        class="inline-flex items-center justify-center min-h-[44px] px-6 py-2.5 bg-slate-900 text-white text-xs font-black rounded-xl shadow-sm hover:bg-slate-800 transition-all uppercase tracking-widest">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        Save Vital Information
                                    </button>
                                </div>
                            </form>
                        </div>
                    </x-animation>

                    {{-- Section 2: Basic Medical Footprint --}}
                    <x-animation delay="200">
                        <div class="bg-white rounded-[1.75rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden">
                            <div class="px-6 sm:px-8 pt-6 sm:pt-8 pb-2">
                                <div class="flex items-center gap-3 mb-1">
                                    <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.25 2.25 0 0 1 13.5 2.25H15a2.25 2.25 0 0 1 2.122 1.5" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-bold text-slate-800">Medical Footprint</h2>
                                        <p class="text-xs text-slate-400 font-medium">Allergies, conditions, and clinical background</p>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('profile.patient-medical') }}" method="POST" class="px-6 sm:px-8 pb-6 sm:pb-8">
                                @csrf

                                <div class="space-y-5 mt-4">
                                    {{-- Known Allergies --}}
                                    <div class="space-y-1.5">
                                        <label for="known_allergies" class="block text-sm font-black text-slate-700 tracking-tight ml-1">Known Allergies</label>
                                        <textarea id="known_allergies" name="known_allergies" rows="3"
                                            placeholder="e.g., Penicillin, Latex, Peanuts — or type 'None known'"
                                            class="w-full px-4 py-3 rounded-xl border transition-all duration-200 outline-none focus:ring-4 resize-none min-h-[44px]
                                                {{ $errors->has('known_allergies')
                                                    ? 'border-red-500 bg-red-50 focus:ring-red-100 text-red-900'
                                                    : 'border-slate-200 bg-slate-50/50 focus:border-rose-500 focus:ring-rose-100 text-slate-900' }}">{{ old('known_allergies', $user->known_allergies) }}</textarea>
                                        @error('known_allergies')
                                            <div class="flex items-center space-x-1 ml-1 mt-1">
                                                <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                                <p class="text-red-500 text-[11px] font-bold italic uppercase tracking-wider leading-none">{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- Chronic Conditions --}}
                                    <div class="space-y-1.5">
                                        <label for="chronic_conditions" class="block text-sm font-black text-slate-700 tracking-tight ml-1">Chronic Conditions / Medical History</label>
                                        <textarea id="chronic_conditions" name="chronic_conditions" rows="4"
                                            placeholder="Document any ongoing conditions, past surgeries, or relevant medical history..."
                                            class="w-full px-4 py-3 rounded-xl border transition-all duration-200 outline-none focus:ring-4 resize-none min-h-[44px]
                                                {{ $errors->has('chronic_conditions')
                                                    ? 'border-red-500 bg-red-50 focus:ring-red-100 text-red-900'
                                                    : 'border-slate-200 bg-slate-50/50 focus:border-rose-500 focus:ring-rose-100 text-slate-900' }}">{{ old('chronic_conditions', $user->chronic_conditions) }}</textarea>
                                        @error('chronic_conditions')
                                            <div class="flex items-center space-x-1 ml-1 mt-1">
                                                <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                                <p class="text-red-500 text-[11px] font-bold italic uppercase tracking-wider leading-none">{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex justify-end pt-4">
                                    <button type="submit"
                                        class="inline-flex items-center justify-center min-h-[44px] px-6 py-2.5 bg-slate-900 text-white text-xs font-black rounded-xl shadow-sm hover:bg-slate-800 transition-all uppercase tracking-widest">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        Save Medical Data
                                    </button>
                                </div>
                            </form>
                        </div>
                    </x-animation>
                </div>

                {{-- Data Privacy Info Banner --}}
                <x-animation delay="250">
                    <div class="bg-slate-900 rounded-2xl p-5 relative overflow-hidden">
                        <div class="relative z-10 flex items-start space-x-3">
                            <div class="shrink-0 w-9 h-9 rounded-xl bg-slate-800 flex items-center justify-center text-rose-400">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-white text-xs font-bold mb-0.5">Data Privacy</p>
                                <p class="text-slate-400 text-[11px] font-medium leading-relaxed">Your medical information is encrypted and stored securely. Only authorized healthcare professionals can access your records.</p>
                            </div>
                        </div>
                        <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-rose-500/10 rounded-full"></div>
                        <div class="absolute -top-6 -left-6 w-16 h-16 bg-white/[0.03] rounded-full"></div>
                    </div>
                </x-animation>
            </div>


        @elseif(auth()->user()->role === 'doctor')
            {{-- ─────────────────────────────────────────────────────────────── --}}
            {{--  DOCTOR LAYOUT                                                 --}}
            {{-- ─────────────────────────────────────────────────────────────── --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">

                {{-- LEFT COLUMN: Credentials + Consultation Settings --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Section 1: Clinical Credentials Block --}}
                    <x-animation delay="100">
                        <div class="bg-white rounded-[1.75rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden">
                            <div class="px-6 sm:px-8 pt-6 sm:pt-8 pb-2">
                                <div class="flex items-center gap-3 mb-1">
                                    <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-bold text-slate-800">Clinical Credentials</h2>
                                        <p class="text-xs text-slate-400 font-medium">Your professional registration details</p>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('profile.doctor-credentials') }}" method="POST" class="px-6 sm:px-8 pb-6 sm:pb-8">
                                @csrf

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1 mt-4">
                                    {{-- Medical License Number (MMC ID) --}}
                                    <x-form.field label="Medical License Number (MMC ID)" name="license_number" :value="$user->doctor?->license_number ?? ''" placeholder="e.g., MMC-12345" />

                                    {{-- Specialized Clinical Department --}}
                                    <div class="space-y-1.5 mb-5">
                                        <label for="specialization" class="block text-sm font-black text-slate-700 tracking-tight ml-1">Clinical Department</label>
                                        <select id="specialization" name="specialization"
                                            class="w-full px-4 py-3 rounded-xl border transition-all duration-200 outline-none focus:ring-4 min-h-[44px] appearance-none bg-no-repeat bg-[right_1rem_center] bg-[length:1rem]
                                                {{ $errors->has('specialization')
                                                    ? 'border-red-500 bg-red-50 focus:ring-red-100 text-red-900'
                                                    : 'border-slate-200 bg-slate-50/50 focus:border-rose-500 focus:ring-rose-100 text-slate-900' }}"
                                            style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 24 24%27 stroke-width=%272%27 stroke=%27%2394a3b8%27%3e%3cpath stroke-linecap=%27round%27 stroke-linejoin=%27round%27 d=%27m19.5 8.25-7.5 7.5-7.5-7.5%27/%3e%3c/svg%3e')">
                                            @php $currentSpec = old('specialization', $user->doctor?->specialization ?? ''); @endphp
                                            <option value="" {{ $currentSpec === '' ? 'selected' : '' }}>Select department</option>
                                            @foreach(['General Medicine', 'Cardiology', 'Dermatology', 'Paediatrics', 'Orthopaedics', 'Neurology', 'Psychiatry', 'Gynaecology', 'Urology', 'ENT', 'Ophthalmology', 'Dental', 'Physiotherapy', 'Other'] as $dept)
                                                <option value="{{ $dept }}" {{ $currentSpec === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                                            @endforeach
                                        </select>
                                        @error('specialization')
                                            <div class="flex items-center space-x-1 ml-1 mt-1">
                                                <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                                <p class="text-red-500 text-[11px] font-bold italic uppercase tracking-wider leading-none">{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- Year of Commencement --}}
                                    <x-form.field label="Year of Commencement" name="year_of_commencement" type="number" :value="$user->doctor?->year_of_commencement ?? ''" placeholder="e.g., 2015" />

                                    {{-- Consultation Fee --}}
                                    <x-form.field label="Consultation Fee (RM)" name="consultation_fee" type="number" :value="$user->doctor?->consultation_fee ?? '0.00'" placeholder="e.g., 80.00" />
                                </div>

                                <div class="flex justify-end pt-2">
                                    <button type="submit"
                                        class="inline-flex items-center justify-center min-h-[44px] px-6 py-2.5 bg-slate-900 text-white text-xs font-black rounded-xl shadow-sm hover:bg-slate-800 transition-all uppercase tracking-widest">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        Save Credentials
                                    </button>
                                </div>
                            </form>
                        </div>
                    </x-animation>

                    {{-- Section 2: Consultation Settings --}}
                    <x-animation delay="200">
                        <div class="bg-white rounded-[1.75rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden">
                            <div class="px-6 sm:px-8 pt-6 sm:pt-8 pb-2">
                                <div class="flex items-center gap-3 mb-1">
                                    <div class="w-9 h-9 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-bold text-slate-800">Consultation Settings</h2>
                                        <p class="text-xs text-slate-400 font-medium">Bio and location visible to patients</p>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('profile.doctor-consultation') }}" method="POST" class="px-6 sm:px-8 pb-6 sm:pb-8">
                                @csrf

                                <div class="space-y-5 mt-4">
                                    {{-- Professional Bio / Statement --}}
                                    <div class="space-y-1.5">
                                        <label for="bio" class="block text-sm font-black text-slate-700 tracking-tight ml-1">Professional Bio / Statement</label>
                                        <p class="text-[11px] text-slate-400 font-medium ml-1 -mt-0.5 mb-2">This statement will be displayed to patients during the booking flow.</p>
                                        <textarea id="bio" name="bio" rows="5"
                                            placeholder="Introduce yourself to your patients — your expertise, approach to care, and clinical philosophy..."
                                            class="w-full px-4 py-3 rounded-xl border transition-all duration-200 outline-none focus:ring-4 resize-none min-h-[44px]
                                                {{ $errors->has('bio')
                                                    ? 'border-red-500 bg-red-50 focus:ring-red-100 text-red-900'
                                                    : 'border-slate-200 bg-slate-50/50 focus:border-rose-500 focus:ring-rose-100 text-slate-900' }}">{{ old('bio', $user->doctor?->bio ?? '') }}</textarea>
                                        @error('bio')
                                            <div class="flex items-center space-x-1 ml-1 mt-1">
                                                <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                                <p class="text-red-500 text-[11px] font-bold italic uppercase tracking-wider leading-none">{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- Room / Clinic Location --}}
                                    <x-form.field label="Room / Clinic Consultation Block" name="consultation_location" :value="old('consultation_location', '')" placeholder="e.g., Block A, Room 302 — Level 3" />
                                </div>

                                <div class="flex justify-end pt-2">
                                    <button type="submit"
                                        class="inline-flex items-center justify-center min-h-[44px] px-6 py-2.5 bg-slate-900 text-white text-xs font-black rounded-xl shadow-sm hover:bg-slate-800 transition-all uppercase tracking-widest">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        Save Consultation Settings
                                    </button>
                                </div>
                            </form>
                        </div>
                    </x-animation>
                </div>

                {{-- RIGHT COLUMN: Availability + Tip --}}
                <div class="space-y-6">

                    {{-- Availability Parameters Summary --}}
                    <x-animation delay="250">
                        <div class="bg-white rounded-[1.75rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden">
                            <div class="px-6 pt-6 pb-4">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-9 h-9 rounded-xl bg-cyan-50 flex items-center justify-center text-cyan-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-bold text-slate-800">Availability</h2>
                                        <p class="text-xs text-slate-400 font-medium">Your active shift boundaries</p>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    {{-- Monday - Friday --}}
                                    <div class="flex items-center justify-between py-2.5 px-3 rounded-xl bg-slate-50/80 border border-slate-100">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                            <span class="text-sm font-bold text-slate-700">Mon – Fri</span>
                                        </div>
                                        <span class="text-xs font-bold text-slate-500 bg-white px-2.5 py-1 rounded-lg border border-slate-100">09:00 AM – 05:00 PM</span>
                                    </div>

                                    {{-- Saturday --}}
                                    <div class="flex items-center justify-between py-2.5 px-3 rounded-xl bg-slate-50/80 border border-slate-100">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-2 h-2 rounded-full bg-amber-400"></div>
                                            <span class="text-sm font-bold text-slate-700">Saturday</span>
                                        </div>
                                        <span class="text-xs font-bold text-slate-500 bg-white px-2.5 py-1 rounded-lg border border-slate-100">09:00 AM – 01:00 PM</span>
                                    </div>

                                    {{-- Sunday --}}
                                    <div class="flex items-center justify-between py-2.5 px-3 rounded-xl bg-slate-50/80 border border-slate-100">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-2 h-2 rounded-full bg-rose-400"></div>
                                            <span class="text-sm font-bold text-slate-700">Sunday</span>
                                        </div>
                                        <span class="text-xs font-bold text-slate-400 italic">Off Duty</span>
                                    </div>
                                </div>

                                <a href="/schedule"
                                    class="mt-4 w-full inline-flex items-center justify-center min-h-[44px] px-4 py-2.5 bg-emerald-600 text-white text-xs font-black rounded-xl shadow-sm hover:bg-emerald-700 transition-all uppercase tracking-widest">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                    </svg>
                                    Manage Full Schedule
                                </a>
                            </div>
                        </div>
                    </x-animation>

                    {{-- Clinical Tip --}}
                    <x-animation delay="300">
                        <div class="bg-slate-900 rounded-2xl p-5 relative overflow-hidden">
                            <div class="relative z-10 flex items-start space-x-3">
                                <div class="shrink-0 w-9 h-9 rounded-xl bg-slate-800 flex items-center justify-center text-emerald-400">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-white text-xs font-bold mb-0.5">Profile Completeness</p>
                                    <p class="text-slate-400 text-[11px] font-medium leading-relaxed">A complete professional bio and updated credentials help patients trust and choose you for their healthcare needs.</p>
                                </div>
                            </div>
                            <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-emerald-500/10 rounded-full"></div>
                            <div class="absolute -top-6 -left-6 w-16 h-16 bg-white/[0.03] rounded-full"></div>
                        </div>
                    </x-animation>
                </div>
            </div>
        @endif

    </div>
</x-layout>
