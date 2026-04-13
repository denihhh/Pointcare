@props(['label', 'name', 'type' => 'text'])

@php
    $errorClass = $errors->has($name) ? 'border-red-500' : 'border-gray-300';
@endphp

<div class="form-control w-full space-y-2 mb-4">
    <label for="{{ $name }}" class="label font-semibold">{{ $label }}</label>
    <input type="{{ $type }}"
           value="{{ $type !== 'password' ? old($name) : '' }}"
           class="input w-full border p-2 rounded {{ $errorClass }}"
           id="{{ $name }}"
           name="{{ $name }}"
           placeholder="{{ $label }}"
           {{ $attributes }}>

    @error($name)
        <p class="text-red-500 text-sm italic">{{ $message }}</p>
    @enderror
</div>
