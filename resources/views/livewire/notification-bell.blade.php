<div class="inline-block text-left" x-data="{ open: false }" @click.outside="open = false" wire:poll.15s>
    {{-- Bell Button --}}
    <button @click="open = !open"
        class="relative p-2.5 text-slate-500 hover:text-rose-600 hover:bg-rose-50/80 rounded-2xl transition-all duration-300 hover:scale-105 active:scale-95 flex items-center justify-center focus:outline-none"
        title="View Notifications">
        <svg class="h-5.5 w-5.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>

        @if ($unreadCount > 0)
            <span class="absolute top-2 right-2 flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
            </span>
        @endif
    </button>

    {{-- Dropdown Canvas Drawer --}}
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-1 scale-95"
        class="absolute left-4 top-[76px] w-[280px] sm:w-80 md:w-96 origin-top-left rounded-3xl bg-white shadow-2xl ring-1 ring-slate-900/5 focus:outline-none z-50 overflow-hidden border border-slate-100">
        
        {{-- Header --}}
        <div class="px-5 py-4 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <h3 class="text-sm font-black text-slate-900 tracking-tight">Recent Notifications</h3>
                @if ($unreadCount > 0)
                    <span class="bg-rose-100 text-rose-600 text-[10px] font-black px-2 py-0.5 rounded-full">
                        {{ $unreadCount }} new
                    </span>
                @endif
            </div>
            @if ($unreadCount > 0)
                <button wire:click="markAllAsRead"
                    class="text-[10px] font-black text-rose-500 hover:text-rose-600 tracking-wider uppercase transition-colors focus:outline-none">
                    Mark all as read
                </button>
            @endif
        </div>

        {{-- Alerts List --}}
        <div class="max-h-96 overflow-y-auto divide-y divide-slate-100">
            @forelse ($notifications as $notification)
                <div class="p-4 flex gap-3.5 hover:bg-slate-50/50 transition duration-200 relative {{ is_null($notification->read_at) ? 'bg-rose-50/10' : '' }}"
                    @if (is_null($notification->read_at)) wire:click="markAsRead('{{ $notification->id }}')" style="cursor: pointer;" @endif>
                    
                    {{-- Left side: Icon --}}
                    <div class="shrink-0">
                        @php
                            $type = data_get($notification->data, 'type', 'general');
                            $isUnread = is_null($notification->read_at);
                        @endphp
                        
                        @if ($type === 'status_mutation')
                            @if (str_contains(strtolower(data_get($notification->data, 'title', '')), 'confirm'))
                                {{-- Approved Icon --}}
                                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center border border-emerald-100 shadow-3xs">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                            @else
                                {{-- Rejected Icon --}}
                                <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center border border-rose-100 shadow-3xs">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            @endif
                        @elseif ($type === 'reminder')
                            {{-- Reminder Icon --}}
                            <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center border border-amber-100 shadow-3xs">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        @elseif ($type === 'inbound_booking')
                            {{-- Inbound Booking Icon --}}
                            <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center border border-indigo-100 shadow-3xs">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </div>
                        @elseif ($type === 'cancellation')
                            {{-- Cancellation Icon --}}
                            <div class="w-9 h-9 rounded-xl bg-red-50 text-red-500 flex items-center justify-center border border-red-100 shadow-3xs">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                            </div>
                        @else
                            {{-- General Icon --}}
                            <div class="w-9 h-9 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center border border-slate-100 shadow-3xs">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Right side: Content --}}
                    <div class="flex-1 min-w-0 pr-4">
                        <div class="flex items-start justify-between gap-1.5">
                            <span class="text-xs font-black text-slate-900 truncate">
                                {{ data_get($notification->data, 'title', 'Notification') }}
                            </span>
                            <span class="text-[9px] font-bold text-slate-400 shrink-0 mt-0.5">
                                {{ $notification->created_at->diffForHumans(null, true) }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed mt-1">
                            {{ data_get($notification->data, 'message', '') }}
                        </p>
                    </div>

                    {{-- Unread Dot --}}
                    @if ($isUnread)
                        <span class="absolute top-4 right-4 h-1.5 w-1.5 rounded-full bg-rose-500 shadow-sm animate-pulse"></span>
                    @endif
                </div>
            @empty
                <div class="px-5 py-10 text-center flex flex-col items-center justify-center">
                    <div class="w-12 h-12 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 mb-3.5 shadow-inner">
                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                    </div>
                    <p class="text-xs font-black text-slate-800 tracking-tight">All caught up!</p>
                    <p class="text-[10px] text-slate-400 mt-1">You have no active alerts in your queue.</p>
                </div>
            @endforelse
        </div>

        {{-- Footer --}}
        <div class="px-5 py-3.5 bg-slate-50/50 border-t border-slate-100 text-center">
            <a href="/notifications" @click="open = false"
                class="text-[10px] font-black text-slate-700 hover:text-rose-500 tracking-wider uppercase transition-colors">
                View Historical Log
            </a>
        </div>
    </div>
</div>
