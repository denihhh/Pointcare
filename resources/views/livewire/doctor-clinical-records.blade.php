<div>

    {{-- Search Row --}}
    <div class="mb-6">
        <x-doctor.clinical-search />
    </div>

    {{-- Content --}}
    @if ($records->isEmpty())
        <x-doctor.clinical-empty-state
            icon-path="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"
            title="No records found"
            subtitle="Clinical records matching your filters will appear here." />
    @else
        <div class="space-y-4">
            @foreach ($records as $record)
                <x-doctor.appointment-card :appointment="$record" />
            @endforeach
        </div>

        {{-- Pagination --}}
        {{ $records->links('livewire::tailwind') }}
    @endif
</div>
