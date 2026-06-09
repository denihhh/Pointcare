<div class="flex-1 flex justify-end gap-x-5 text-center">
    @auth
        <div class="flex items-center gap-x-5">
            <x-notification.notibar />
            <div data-test="profile-dropdown" x-data="{ open: false }" @click.away="open = false" class="relative">

                <button @click="open = !open" type="button"
                    class="flex items-center max-w-xs text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-primary/20 transition-all duration-300 hover:shadow-md p-1 pr-3 border border-rose-200">

                    {{-- User Avatar / Initials --}}
                    <div
                        class="h-8 w-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs overflow-hidden border border-primary/20">
                        @if (auth()->user()->profile_photo)
                            <img src="{{ auth()->user()->profile_photo }}" alt="Profile">
                        @else
                            {{ substr(auth()->user()->name, 0, 1) }}
                        @endif
                    </div>

                    {{-- User Name and Down Arrow --}}
                    <span class="hidden md:flex items-center text-gray-700 font-medium">

                        <svg class="w-4 h-4 ml-1 text-gray-400 transition-transform duration-200"
                            :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-xl bg-white py-1 shadow-lg focus:outline-none border border-gray-50 overflow-hidden"
                    style="display: none;">

                    <div class="px-4 py-3 border-b border-gray-50">
                        <p class="text-xs text-gray-400 uppercase tracking-widest font-bold">Account</p>
                        <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->email }}</p>
                    </div>

                    <a href="/profile"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors">
                        <svg class="w-4 h-4 mr-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        View Profile
                    </a>

                    <a href="/settings"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 mr-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Settings
                    </a>

                    <div class="border-t border-gray-50"></div>

                    <form method="POST" action="/logout">
                        @csrf
                        <button data-test="logout-button" type="submit"
                            class="flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endauth

    @guest
        <div class="flex items-center gap-x-1 sm:gap-x-3">
            <a href="/login"
                class="hidden sm:block text-sm font-bold text-slate-600 hover:text-rose-600 px-4 py-2 transition-colors">
                Login
            </a>

            <a href="/register"
                class="bg-primary hover:bg-rose-600 text-white text-[11px] sm:text-sm font-black px-4 sm:px-6 py-2 sm:py-2.5 rounded-lg sm:rounded-xl shadow-lg shadow-rose-200 transition-all hover:-translate-y-0.5 active:translate-y-0 whitespace-nowrap">
                Get Started
            </a>
        </div>
    @endguest
</div>
