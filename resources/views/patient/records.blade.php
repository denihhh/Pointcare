<x-layout title="Pass Records - Health Ledger">
    <x-return />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20"
         x-data="{ 
             selectedRecord: null, 
             search: '',
             records: @js($appointments),
             modalOpen: false
         }">

        <div class="space-y-8 animate__animated animate__fadeIn animate__faster">
            {{-- Header Section Component --}}
            <x-patient.records.header 
                title="Health Ledger" 
                subtitle="Verify and audit your completed historical clinical consultations." 
            />

            {{-- Card container --}}
            <div class="bg-white shadow-[0_20px_50px_rgba(0,0,0,0.04)] rounded-2xl border border-slate-100 overflow-hidden">
                <div class="p-8 sm:p-8">
                    {{-- Conditional Layout rendering --}}
                    @if($appointments->isEmpty())
                        <x-patient.records.empty-state />
                    @else
                        {{-- Desktop Historical Ledger Table Component --}}
                        <x-patient.records.table :appointments="$appointments" />

                        {{-- Mobile Stacked Card List Component --}}
                        <x-patient.records.mobile-list :appointments="$appointments" />
                    @endif
                </div>
            </div>
        </div>

        {{-- Record Details Modal Component --}}
        @if(!$appointments->isEmpty())
            <x-patient.records.modal />
        @endif
    </div>

</x-layout>