@props(['name', 'label', 'icon', 'placeholder', 'rows' => 5, 'value' => ''])

<div class="space-y-3">
    <label class="flex items-center text-xs font-black uppercase tracking-[0.2em] text-slate-400 ml-1">
        <svg class="w-4 h-4 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            {!! $icon !!}
        </svg>
        {{ $label }}
    </label>

    <textarea
        name="{{ $name }}"
        rows="{{ $rows }}"
        class="w-full rounded-3xl p-5 border-slate-200 bg-white shadow-sm focus:border-rose-500 focus:ring-4 focus:ring-rose-100 outline-none transition-all duration-200 text-slate-700 font-medium @error($name) border-rose-500 @enderror"
        placeholder="{{ $placeholder }}">{{ old($name, $value) }}</textarea>

    @error($name)
        <p class="text-rose-500 text-[10px] font-black uppercase tracking-widest mt-1 ml-2">{{ $message }}</p>
    @enderror
</div>
