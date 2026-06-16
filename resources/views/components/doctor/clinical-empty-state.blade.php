@props(['title', 'subtitle', 'iconPath'])

<div class="py-20 text-center">
    <div class="inline-flex items-center justify-center w-16 h-16 bg-slate-50 rounded-full mb-4">
        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}" />
        </svg>
    </div>
    <h3 class="text-lg font-bold text-slate-800">{{ $title }}</h3>
    <p class="text-slate-400 text-sm mt-1">{{ $subtitle }}</p>
</div>
