@props(['title', 'description'])

{{-- Card Container --}}
<div class="bg-card border border-border rounded-3xl shadow-md p-8 backdrop-blur-sm bg-white/90">
    <div class="text-center mb-8 space-y-2">

        <h2 class="text-2xl font-black text-foreground tracking-tight">
            {{ $title }}
        </h2>

        @if(isset($description) && $description)
            <p class="text-sm text-muted-foreground">
                {{ $description }}
            </p>
        @endif

        <div class="w-12 h-1 mx-auto bg-primary/20 rounded-full"></div>

    </div>
    
    {{ $slot }}

    {{-- Divider --}}
    <div class="mt-6 flex items-center gap-3">
        <div class="flex-1 h-px bg-border"></div>
        <span class="text-[10px] font-semibold text-muted-foreground uppercase tracking-widest">
            Secure Access
        </span>
        <div class="flex-1 h-px bg-border"></div>
    </div>
</div>