@props(['title', 'description'])

<div class="min-h-screen flex items-center justify-center bg-background px-4">

    <div class="w-full max-w-md">

        {{-- Card --}}
        <div class="bg-surface border border-border rounded-2xl shadow-sm p-8">
            <div class="text-center mb-8 space-y-2">

                <h2 class="text-2xl font-black text-text-primary tracking-tight">
                    {{ $title }}
                </h2>

                <div class="w-12 h-1 mx-auto bg-primary/20 rounded-full"></div>

            </div>
            {{ $slot }}

            {{-- Divider --}}
            <div class="mt-6 flex items-center gap-3">
                <div class="flex-1 h-px bg-border"></div>
                <span class="text-[10px] font-semibold text-text-secondary uppercase tracking-widest">
                    Secure Login
                </span>
                <div class="flex-1 h-px bg-border"></div>
            </div>

        </div>



    </div>
</div>
