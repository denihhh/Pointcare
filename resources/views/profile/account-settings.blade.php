<x-layout title="Account Settings">
    <x-return />

    @php
        $userAgent = request()->userAgent();
        $browser = 'Unknown Browser';
        $platform = 'Unknown OS';

        if (preg_match('/chrome|crios/i', $userAgent)) {
            $browser = 'Google Chrome';
        } elseif (preg_match('/firefox/i', $userAgent)) {
            $browser = 'Mozilla Firefox';
        } elseif (preg_match('/safari/i', $userAgent)) {
            $browser = 'Apple Safari';
        } elseif (preg_match('/edge/i', $userAgent)) {
            $browser = 'Microsoft Edge';
        }

        if (preg_match('/windows|win32/i', $userAgent)) {
            $platform = 'Windows';
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            $platform = 'macOS';
        } elseif (preg_match('/linux/i', $userAgent)) {
            $platform = 'Linux';
        } elseif (preg_match('/iphone|ipad/i', $userAgent)) {
            $platform = 'iOS';
        } elseif (preg_match('/android/i', $userAgent)) {
            $platform = 'Android';
        }
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        
        <x-animation>
            <div class="mt-4 mb-8">
                <div class="flex items-center space-x-3 mb-2">
                    <span class="bg-rose-100 text-rose-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">
                        System Configuration
                    </span>
                    <span class="text-slate-400 text-xs font-medium">Security Perimeter</span>
                </div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Account Settings</h1>
                <p class="text-slate-500 font-medium mt-1">Configure your identity credentials and audit session perimeters.</p>
            </div>
        </x-animation>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 items-start">
            
            {{-- Navigation Sidebar --}}
            <x-animation delay="100">
                <div class="bg-white rounded-[1.75rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.02)] p-6 space-y-2 sticky top-6">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-3 mb-4">Settings Menu</p>
                    
                    <a href="#identity" 
                        class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all group">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-rose-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        Account Identity
                    </a>

                    <a href="#security" 
                        class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all group">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-rose-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                        Security Credentials
                    </a>

                    <a href="#perimeter" 
                        class="flex items-center gap-3 px-3 py-3 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all group">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-rose-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.751A11.956 11.956 0 0 1 12 2.714Z" />
                        </svg>
                        Session Control
                    </a>
                </div>
            </x-animation>

            {{-- Forms Column --}}
            <div class="lg:col-span-2 space-y-6 sm:space-y-8">
                
                {{-- Form 1: Identity Parameters --}}
                <x-animation delay="150">
                    <div id="identity" class="scroll-mt-6 bg-white rounded-[1.75rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden">
                        <div class="px-6 sm:px-8 pt-6 sm:pt-8 pb-2">
                            <div class="flex items-center gap-3 mb-1">
                                <div class="w-9 h-9 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-slate-800">Account Identity</h2>
                                    <p class="text-xs text-slate-400 font-medium font-sans">Manage your authenticated contact pointers and address attributes.</p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('profile.account-settings.identity') }}" method="POST" class="px-6 sm:px-8 pb-6 sm:pb-8 mt-4 space-y-5">
                            @csrf
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                {{-- Email input --}}
                                <div class="space-y-1.5">
                                    <label for="identity_email" class="block text-sm font-black text-slate-700 tracking-tight ml-1">Email Address</label>
                                    <input type="email" id="identity_email" name="email" 
                                        value="{{ old('email', $user->email) }}" required
                                        class="w-full px-4 py-3 rounded-xl border transition-all duration-200 outline-none min-h-[44px]
                                            focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500
                                            {{ $errors->identity->has('email')
                                                ? 'border-red-500 bg-red-50 text-red-900'
                                                : 'border-slate-200 bg-slate-50/50 text-slate-900' }}">
                                    @error('email', 'identity')
                                        <div class="flex items-center space-x-1 ml-1 mt-1">
                                            <p class="text-red-500 text-[11px] font-bold italic uppercase tracking-wider leading-none">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>

                                {{-- Phone input --}}
                                <div class="space-y-1.5">
                                    <label for="identity_phone" class="block text-sm font-black text-slate-700 tracking-tight ml-1">Phone Number</label>
                                    <input type="tel" id="identity_phone" name="phone" 
                                        x-data="{ phone: '{{ old('phone', $user->phone) }}' }"
                                        x-model="phone"
                                        x-on:input="phone = $event.target.value.replace(/[^0-9\s\-+]/g, '')"
                                        placeholder="+60 12-345 6789"
                                        class="w-full px-4 py-3 rounded-xl border transition-all duration-200 outline-none min-h-[44px]
                                            focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500
                                            {{ $errors->identity->has('phone')
                                                ? 'border-red-500 bg-red-50 text-red-900'
                                                : 'border-slate-200 bg-slate-50/50 text-slate-900' }}">
                                    @error('phone', 'identity')
                                        <div class="flex items-center space-x-1 ml-1 mt-1">
                                            <p class="text-red-500 text-[11px] font-bold italic uppercase tracking-wider leading-none">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit" 
                                    class="inline-flex items-center justify-center min-h-[44px] px-6 py-2.5 bg-slate-900 text-white text-xs font-black rounded-xl shadow-sm hover:bg-slate-800 transition-all uppercase tracking-widest">
                                    Update Identity Parameters
                                </button>
                            </div>
                        </form>
                    </div>
                </x-animation>

                {{-- Form 2: Security Credentials --}}
                <x-animation delay="200">
                    <div id="security" class="scroll-mt-6 bg-white rounded-[1.75rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden">
                        <div class="px-6 sm:px-8 pt-6 sm:pt-8 pb-2">
                            <div class="flex items-center gap-3 mb-1">
                                <div class="w-9 h-9 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-slate-800">Security Credentials</h2>
                                    <p class="text-xs text-slate-400 font-medium">Modify your access phrases to maintain profile integrity.</p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('profile.account-settings.security') }}" method="POST" class="px-6 sm:px-8 pb-6 sm:pb-8 mt-4 space-y-5">
                            @csrf
                            
                            <div class="space-y-4">
                                {{-- Current Password --}}
                                <div class="space-y-1.5">
                                    <label for="security_current" class="block text-sm font-black text-slate-700 tracking-tight ml-1">Current Password</label>
                                    <input type="password" id="security_current" name="current_password" required placeholder="••••••••"
                                        class="w-full px-4 py-3 rounded-xl border transition-all duration-200 outline-none min-h-[44px]
                                            focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500
                                            {{ $errors->security->has('current_password')
                                                ? 'border-red-500 bg-red-50 text-red-900'
                                                : 'border-slate-200 bg-slate-50/50 text-slate-900' }}">
                                    @error('current_password', 'security')
                                        <div class="flex items-center space-x-1 ml-1 mt-1">
                                            <p class="text-red-500 text-[11px] font-bold italic uppercase tracking-wider leading-none">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    {{-- New Password --}}
                                    <div class="space-y-1.5">
                                        <label for="security_new" class="block text-sm font-black text-slate-700 tracking-tight ml-1">New Password</label>
                                        <input type="password" id="security_new" name="new_password" required placeholder="••••••••"
                                            class="w-full px-4 py-3 rounded-xl border transition-all duration-200 outline-none min-h-[44px]
                                                focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500
                                                {{ $errors->security->has('new_password')
                                                    ? 'border-red-500 bg-red-50 text-red-900'
                                                    : 'border-slate-200 bg-slate-50/50 text-slate-900' }}">
                                        @error('new_password', 'security')
                                            <div class="flex items-center space-x-1 ml-1 mt-1">
                                                <p class="text-red-500 text-[11px] font-bold italic uppercase tracking-wider leading-none">{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- Confirm New Password --}}
                                    <div class="space-y-1.5">
                                        <label for="security_confirm" class="block text-sm font-black text-slate-700 tracking-tight ml-1">Confirm New Password</label>
                                        <input type="password" id="security_confirm" name="new_password_confirmation" required placeholder="••••••••"
                                            class="w-full px-4 py-3 rounded-xl border transition-all duration-200 outline-none min-h-[44px]
                                                focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500
                                                border-slate-200 bg-slate-50/50 text-slate-900">
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit" 
                                    class="inline-flex items-center justify-center min-h-[44px] px-6 py-2.5 bg-rose-600 text-white text-xs font-black rounded-xl shadow-sm hover:bg-rose-700 transition-all uppercase tracking-widest">
                                    Rotate Authentication Key
                                </button>
                            </div>
                        </form>
                    </div>
                </x-animation>

                {{-- Form 3: Session Control --}}
                <x-animation delay="250">
                    <div id="perimeter" class="scroll-mt-6 bg-white rounded-[1.75rem] border border-slate-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden">
                        <div class="px-6 sm:px-8 pt-6 sm:pt-8 pb-2">
                            <div class="flex items-center gap-3 mb-1">
                                <div class="w-9 h-9 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.751A11.956 11.956 0 0 1 12 2.714Z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-slate-800">Account Control & Session Perimeter</h2>
                                    <p class="text-xs text-slate-400 font-medium">Verify your session audit footprint and ledger activation status.</p>
                                </div>
                            </div>
                        </div>

                        <div class="px-6 sm:px-8 pb-6 sm:pb-8 mt-6 space-y-8">
                            
                            {{-- Block A: Active Sessions --}}
                            <div class="space-y-4">
                                <h3 class="text-sm font-black text-slate-700 uppercase tracking-wider ml-1">Active Auditor Footprint</h3>
                                
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-white border border-slate-200/80 flex items-center justify-center text-slate-500 shadow-2xs">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                                        </svg>
                                    </div>
                                    <div class="space-y-0.5">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-black text-slate-800 uppercase tracking-wide">Current Device: {{ $browser }}</span>
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[8px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-600">Active Now</span>
                                        </div>
                                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-tight">Platform: {{ $platform }}</p>
                                        <p class="text-[9px] text-slate-400/80 truncate font-mono max-w-[280px] sm:max-w-md">{{ $userAgent }}</p>
                                    </div>
                                </div>

                                {{-- Session Revoking Disclosure --}}
                                <div x-data="{ show: {{ $errors->revoke->any() ? 'true' : 'false' }} }" class="ml-1">
                                    <button @click="show = !show" type="button" 
                                        class="inline-flex items-center text-xs font-black text-rose-500 hover:text-rose-600 uppercase tracking-widest transition duration-200">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                        </svg>
                                        Revoke Other Device Sessions
                                    </button>

                                    <div x-show="show" x-collapse x-cloak class="mt-3 bg-slate-50/50 border border-slate-100 rounded-2xl p-4 sm:p-5 max-w-md space-y-4">
                                        <p class="text-[11px] text-slate-500 font-medium leading-relaxed">
                                            Enter your current password to terminate all active sessions on other browsers and devices.
                                        </p>
                                        <form action="{{ route('profile.account-settings.revoke') }}" method="POST" class="space-y-4">
                                            @csrf
                                            <div class="space-y-1.5">
                                                <label for="revoke_password" class="block text-xs font-black text-slate-700 tracking-tight ml-1">Current Password</label>
                                                <input type="password" id="revoke_password" name="current_password" required placeholder="••••••••"
                                                    class="w-full px-4 py-2.5 rounded-xl border transition-all duration-200 outline-none text-sm
                                                        focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500
                                                        {{ $errors->revoke->has('current_password')
                                                            ? 'border-red-500 bg-red-50 text-red-900'
                                                            : 'border-slate-200 bg-white text-slate-900' }}">
                                                @error('current_password', 'revoke')
                                                    <div class="flex items-center space-x-1 ml-1 mt-1">
                                                        <p class="text-red-500 text-[11px] font-bold italic uppercase tracking-wider leading-none">{{ $message }}</p>
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="flex justify-end">
                                                <button type="submit" 
                                                    class="inline-flex items-center justify-center min-h-[38px] px-4 py-2 bg-slate-900 text-white text-[10px] font-black rounded-lg shadow-sm hover:bg-slate-800 transition-all uppercase tracking-widest">
                                                    Confirm Revocation
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-slate-100">

                            {{-- Block B: Danger Zone --}}
                            <div class="space-y-4">
                                <h3 class="text-sm font-black text-rose-500 uppercase tracking-wider ml-1">Danger Zone</h3>
                                
                                <div class="p-5 rounded-2xl bg-red-50/20 border border-red-100/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div class="space-y-1 max-w-xl">
                                        <h4 class="text-xs font-black text-red-700 uppercase tracking-wider">Deactivate Ledger Profile</h4>
                                        <p class="text-[11px] text-slate-500 font-medium leading-relaxed">
                                            Permanently erase your account information, clinical dashboard indices, and all upcoming/past sessions. This operation cannot be reversed.
                                        </p>
                                    </div>

                                    <div x-data="{ open: {{ $errors->deactivate->any() ? 'true' : 'false' }} }" class="shrink-0">
                                        <!-- Trigger -->
                                        <button @click="open = true" type="button" 
                                            class="w-full sm:w-auto inline-flex items-center justify-center min-h-[44px] px-5 py-2.5 bg-red-600 text-white text-xs font-black rounded-xl shadow-sm hover:bg-red-700 transition-all uppercase tracking-widest">
                                            Deactivate Account Ledger
                                        </button>

                                        <!-- Safe-state confirmation Modal -->
                                        <div x-show="open" x-transition.opacity.duration.300ms 
                                            class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4" x-cloak>
                                            
                                            <div @click.away="open = false" x-show="open" x-transition.scale.duration.300ms 
                                                class="bg-white rounded-3xl border border-slate-100 shadow-2xl p-6 sm:p-8 max-w-md w-full relative overflow-hidden text-left" x-cloak>
                                                
                                                <button @click="open = false" type="button" 
                                                    class="absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-50 transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                                    </svg>
                                                </button>

                                                <h3 class="text-lg font-black text-slate-900 tracking-tight leading-tight mb-2">Deactivate Account Ledger</h3>
                                                <p class="text-xs text-slate-500 mb-6 font-medium leading-relaxed">
                                                    Warning: Deactivating this profile permanently destroys all health record histories, consult files, and system privileges.
                                                </p>

                                                <form action="{{ route('profile.account-settings.deactivate') }}" method="POST" class="space-y-4">
                                                    @csrf
                                                    
                                                    <div class="space-y-2">
                                                        <label class="flex items-start gap-3 p-3 rounded-xl bg-red-50/50 border border-red-100 cursor-pointer select-none">
                                                            <input type="checkbox" name="confirm_deactivation" value="1" required 
                                                                class="mt-1 h-4 w-4 rounded border-red-300 text-red-600 focus:ring-red-500">
                                                            <span class="text-xs font-semibold text-red-700 leading-snug">
                                                                I understand that this will permanently delete my profile, and I explicitly confirm this deactivation.
                                                            </span>
                                                        </label>
                                                        @error('confirm_deactivation', 'deactivate')
                                                            <div class="flex items-center space-x-1 ml-1 mt-1">
                                                                <p class="text-red-500 text-[11px] font-bold italic uppercase tracking-wider leading-none">{{ $message }}</p>
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="flex justify-end gap-3 pt-2">
                                                        <button @click="open = false" type="button" 
                                                            class="px-4 py-2.5 text-xs font-bold text-slate-500 hover:text-slate-700 rounded-xl transition">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" 
                                                            class="inline-flex items-center justify-center min-h-[44px] px-6 py-2.5 bg-red-600 text-white text-xs font-black rounded-xl hover:bg-red-700 transition-all uppercase tracking-widest shadow-md">
                                                            Confirm Deactivation
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-animation>
            </div>
        </div>
    </div>
</x-layout>
