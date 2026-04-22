@props(['label', 'name', 'type' => 'text', 'value' => '']) {{-- 1. Added value prop --}}
{{-- form utk appointment, try update nanti atau combine skali dgn field.blade.php --}}
@php
    $errorClass = $errors->has($name) ? 'border-red-500' : 'border-gray-300';
@endphp

<div class="form-control w-full mb-4">
    {{-- 2. Only show label if it's not empty --}}
    @if($label)
        <label for="{{ $name }}" class="label font-semibold">{{ $label }}</label>
    @endif

    <input type="{{ $type }}"
           {{-- 3. Prioritize old input, then the passed value, then empty --}}
           value="{{ $type !== 'password' ? old($name, $value) : '' }}"
           class="bg-background input w-full border border-gray-300 p-2 rounded {{ $errorClass }}"
           id="{{ $name }}"
           name="{{ $name }}"
           placeholder="{{ $label ?: 'Enter ' . $name }}" {{-- 4. Fallback placeholder --}}
           {{ $attributes }}>

    @error($name)
        <p class="text-red-500 text-sm italic">{{ $message }}</p>
    @enderror
</div>
