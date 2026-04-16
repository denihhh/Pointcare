<x-layout>
    {{-- Parent container must use items-start --}}
    <div
        class="max-w-5xl mx-auto flex justify-between items-start px-12 py-6 bg-white/40 backdrop-blur-md rounded-2xl border border-white/60 shadow-sm">

        {{-- Left Side: Title and Description --}}
        <div class="flex flex-col pr-4"> {{-- Added padding-right so text doesn't hit the badge --}}
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
                Test
            </h1>
            <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                This is a very long description text that will wrap to multiple lines.
                Because the parent uses "items-start", the badge on the right will
                not move down as this text grows longer and longer.
            </p>
        </div>

        {{-- Right Side: Badge stays at the top --}}
        <div class="flex-shrink-0">
            <h2
                class="px-4 py-1.5 bg-primary/10 text-primary rounded-full text-[10px] font-bold uppercase tracking-widest border border-primary/10">
                desc
            </h2>
        </div>

    </div>
</x-layout>
