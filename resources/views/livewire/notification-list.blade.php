<div class="space-y-6" wire:poll.15s>
    {{-- Header Options --}}
    <div class="flex items-center justify-between border-b border-slate-100 pb-5">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Notification History</h1>
            <p class="text-xs text-slate-500 mt-1">Review all your system alerts and booking status changes chronologically.</p>
        </div>
        
        @if ($notifications->count() > 0 && Auth::user()->unreadNotifications()->count() > 0)
            <button wire:click="markAllAsRead"
                class="flex items-center gap-2 px-4 py-2 bg-slate-900 hover:bg-rose-500 text-white text-xs font-black tracking-wider uppercase rounded-xl transition shadow-xs focus:outline-none">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
                Mark all as read
            </button>
        @endif
    </div>

    {{-- Notification List Card Container --}}
    @if ($notifications->count() > 0)
        <div class="bg-white border border-rose-500/15 rounded-[2rem] shadow-xs overflow-hidden divide-y divide-slate-100">
            @foreach ($notifications as $notification)
                @php
                    $type = data_get($notification->data, 'type', 'general');
                    $isUnread = is_null($notification->read_at);
                @endphp
                <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition duration-200 hover:bg-slate-50/30 relative {{ $isUnread ? 'bg-rose-50/5' : '' }}">
                    
                    {{-- Left side details --}}
                    <div class="flex items-start gap-4">
                        {{-- Icon --}}
                        <div class="shrink-0 mt-0.5">
                            @if ($type === 'status_mutation')
                                @if (str_contains(strtolower(data_get($notification->data, 'title', '')), 'confirm'))
                                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center border border-emerald-100 shadow-3xs">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center border border-rose-100 shadow-3xs">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </div>
                                @endif
                            @elseif ($type === 'reminder')
                                <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center border border-amber-100 shadow-3xs">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            @elseif ($type === 'inbound_booking')
                                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center border border-indigo-100 shadow-3xs">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </div>
                            @elseif ($type === 'cancellation')
                                <div class="w-10 h-10 rounded-2xl bg-red-50 text-red-500 flex items-center justify-center border border-red-100 shadow-3xs">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                </div>
                            @else
                                <div class="w-10 h-10 rounded-2xl bg-slate-50 text-slate-500 flex items-center justify-center border border-slate-100 shadow-3xs">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Details --}}
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <h2 class="text-sm font-bold text-slate-900">
                                    {{ data_get($notification->data, 'title', 'Alert') }}
                                </h2>
                                @if ($isUnread)
                                    <span class="inline-block w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                                    <span class="text-[9px] font-black text-rose-500 uppercase tracking-widest bg-rose-50 px-2 py-0.5 rounded-md">
                                        new
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-650 max-w-xl leading-relaxed">
                                {{ data_get($notification->data, 'message', '') }}
                            </p>
                            <p class="text-[10px] text-slate-400 font-medium">
                                Received on {{ $notification->created_at->format('M d, Y \a\t h:i A') }} ({{ $notification->created_at->diffForHumans() }})
                            </p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 self-end sm:self-center shrink-0">
                        @if ($isUnread)
                            <button wire:click="markAsRead('{{ $notification->id }}')"
                                class="p-2.5 bg-slate-50 hover:bg-rose-50 hover:text-rose-600 border border-slate-200 hover:border-rose-100 text-slate-500 rounded-xl transition shadow-3xs flex items-center justify-center focus:outline-none"
                                title="Mark as Read">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        @endif

                        <button wire:click="deleteNotification('{{ $notification->id }}')"
                            class="p-2.5 bg-slate-50 hover:bg-rose-50 hover:text-rose-600 border border-slate-200 hover:border-rose-100 text-slate-400 hover:text-rose-500 rounded-xl transition shadow-3xs flex items-center justify-center focus:outline-none"
                            title="Delete Alert">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </button>
                    </div>

                </div>
            @endforeach
        </div>

        {{-- Pagination Links --}}
        <div class="pt-4">
            {{ $notifications->links() }}
        </div>
    @else
        {{-- Empty State --}}
        <div class="bg-white border border-slate-150 rounded-[2rem] p-16 text-center shadow-xs flex flex-col items-center justify-center">
            <div class="w-20 h-20 rounded-[2rem] bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 mb-6 shadow-inner">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
            </div>
            <h2 class="text-lg font-black text-slate-900 tracking-tight">No Alerts on Record</h2>
            <p class="text-sm text-slate-450 mt-2 max-w-sm mx-auto leading-relaxed">
                You do not have any historical notifications logged in your account right now. Check back later for real-time status updates!
            </p>
        </div>
    @endif
</div>
