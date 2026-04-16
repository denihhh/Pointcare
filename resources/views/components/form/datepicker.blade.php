@props(['label', 'name'])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-black mb-1">{{ $label }}</label>

    <div class="relative">
        <input type="text" id="{{ $name }}" name="{{ $name }}" placeholder="Select Date & Time" readonly
            class="datepicker w-full border border-gray-500 p-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-input">
        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
    </div>
    @error($name)
        <p class="text-red-500 text-sm italic">{{ $message }}</p>
    @enderror
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#{{ $name }}", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today", // Security flex: users can't book the past
            time_24hr: true,

        });
    });
</script>
