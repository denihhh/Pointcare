<x-layout title="Clinical Records">
    <x-return />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">

        <x-doctor.page-header
            badge="Clinical App"
            title="Clinical Records"
            subtitle="Browse diagnoses, prescriptions, and consultation notes across all your patients." />

        {{-- Records Card --}}
        <div
            class="bg-white shadow-[0_20px_50px_rgba(0,0,0,0.03)] rounded-[2.5rem] border border-slate-100 overflow-hidden">
            <div class="p-6 sm:p-10">
                <livewire:doctor-clinical-records />
            </div>
        </div>

    </div>
</x-layout>
