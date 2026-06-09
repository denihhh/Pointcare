<x-layout title="Pass Records - Health Ledger">

    <div x-data="{ 
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

        {{-- Record Details Modal Component --}}
        @if(!$appointments->isEmpty())
            <x-patient.records.modal />
        @endif
    </div>

</x-layout>