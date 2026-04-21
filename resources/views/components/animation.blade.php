@props(['delay' => '0'])

<div x-data="{ show: false }"
     x-init="setTimeout(() => show = true, {{ $delay }})"
     x-show="show"
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 translate-y-4"
     x-transition:enter-end="opacity-100 translate-y-0"
     style="display: none;" {{-- Prevents a flash of content before Alpine loads --}}
     x-cloak
     {{ $attributes }}>
    {{ $slot }}
</div>
