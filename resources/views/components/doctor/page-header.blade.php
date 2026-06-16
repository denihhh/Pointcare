@props(['badge', 'title', 'subtitle', 'badgeColor' => 'rose'])

<div class="mt-8 mb-10">
    <div class="flex items-center space-x-3 mb-2">
        <span
            class="bg-{{ $badgeColor }}-100 text-{{ $badgeColor }}-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">
            {{ $badge }}
        </span>
        <span
            class="text-slate-400 text-xs font-medium">{{ now('Asia/Kuala_Lumpur')->format('l, d F Y') }}</span>
    </div>
    <h1 class="text-4xl font-black text-slate-900 tracking-tight">{{ $title }}</h1>
    <p class="text-slate-500 font-medium mt-1">{{ $subtitle }}</p>
</div>
