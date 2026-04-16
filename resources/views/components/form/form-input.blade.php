@props(['label', 'name', 'type' => 'text'])

@php
    $errorClass = $errors->has($name) ? 'border-red-500' : 'border-gray-300';
@endphp

<div class=" form-control w-full mb-4">
    <label for="{{ $name }}" class="label font-semibold">{{ $label }}</label>
    <input type="{{ $type }}"
           value="{{ $type !== 'password' ? old($name) : '' }}"
           class="bg-input input w-full border border-gray-500 p-2 rounded {{ $errorClass }}"
           id="{{ $name }}"
           name="{{ $name }}"
           placeholder="{{ $label }}"
           {{ $attributes }}>

    @error($name)
        <p class="text-red-500 text-sm italic">{{ $message }}</p>
    @enderror
</div>
