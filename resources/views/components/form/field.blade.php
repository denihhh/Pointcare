@props(['label', 'name', 'type' => 'text', 'value' => '', 'placeholder' => ''])

@php
    $hasError = $errors->has($name);
    // Dynamic classes for better UI
    $baseClasses = "w-full px-4 py-3 rounded-xl border transition-all duration-200 outline-none focus:ring-4";
    $statusClasses = $hasError
        ? "border-red-500 bg-red-50 focus:ring-red-100 text-red-900"
        : "border-slate-200 bg-slate-50/50 focus:border-rose-500 focus:ring-rose-100 text-slate-900";
@endphp

<div class="space-y-1.5 w-full mb-5">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-black text-slate-700 tracking-tight ml-1">
            {{ $label }}
        </label>
    @endif

    <input type="{{ $type }}"
           {{-- Don't repopulate passwords for security --}}
           value="{{ $type !== 'password' ? old($name, $value) : '' }}"
           id="{{ $name }}"
           name="{{ $name }}"
           placeholder="{{ $placeholder ?: ($label ? 'Enter ' . strtolower($label) : '') }}"
           class="{{ $baseClasses }} {{ $statusClasses }}"
           {{ $attributes }}>

    @error($name)
        <div class="flex items-center space-x-1 ml-1 mt-1">
            <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            <p class="text-red-500 text-[11px] font-bold italic uppercase tracking-wider leading-none">{{ $message }}</p>
        </div>
    @enderror
</div>
