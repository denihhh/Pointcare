@inject('appointmentService', App\Services\AppointmentService::class)
@php
    $returnTo = auth()->user()->role === 'doctor' ? 'doctor.clinical-records' : 'records';
@endphp

<x-layout title="Medical Record">
    <div class="print:hidden">
        <x-return :to="$returnTo" />
    </div>


    <style>
        @media print {
            /* Remove left padding offset on print to prevent clipping */
            .lg\:pl-64 {
                padding-left: 0 !important;
            }
            /* Hide sidebar, sticky mobile headers, buttons, footers */
            aside, nav, footer, button, .print\:hidden {
                display: none !important;
            }
            /* Page settings to maximize printable area and force single page */
            @page {
                size: portrait;
                margin: 12mm 15mm !important;
            }
            body {
                background: white !important;
                color: black !important;
                font-size: 12px !important;
                line-height: 1.35 !important;
            }
            main {
                padding: 0 !important;
                margin: 0 !important;
            }
            /* Force exact color printing for headers and blocks */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            /* Tighten up container sizes and margins */
            .max-w-4xl {
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
                page-break-inside: avoid;
                break-inside: avoid;
            }
            .mt-6 {
                margin-top: 0 !important;
            }
            .pb-20 {
                padding-bottom: 0 !important;
            }
            /* Card border style adjust */
            .shadow-\[0_20px_50px_rgba\(0\,0\,0\,0\.04\)\] {
                box-shadow: none !important;
                border: 1px solid #e2e8f0 !important;
                border-radius: 12px !important;
            }
            /* Reduce document header size and padding */
            .bg-slate-900 {
                background-color: #0f172a !important;
                color: white !important;
                padding: 1.75rem !important;
            }
            .text-3xl {
                font-size: 1.75rem !important;
                margin-top: 0.5rem !important;
            }
            .text-lg {
                font-size: 1.1rem !important;
            }
            /* Metadata Grid layout padding and gap compression */
            .p-8 {
                padding: 1.5rem !important;
            }
            .sm\:p-10 {
                padding: 1.5rem !important;
            }
            .grid {
                gap: 1.25rem !important;
            }
            /* Section layout compression */
            .space-y-10 > :not([hidden]) ~ :not([hidden]) {
                --tw-space-y-reverse: 0 !important;
                margin-top: 1.25rem !important;
                margin-bottom: 1.25rem !important;
            }
            .p-8.sm\:p-10.space-y-10 {
                padding: 1.5rem !important;
                gap: 1.25rem !important;
            }
            /* Horizontal dividers */
            hr {
                margin-top: 1.25rem !important;
                margin-bottom: 1.25rem !important;
                border-color: #f1f5f9 !important;
            }
            /* Prescription container compression */
            .bg-slate-900.text-white.rounded-2xl {
                padding: 1.25rem !important;
                margin-top: 1rem !important;
                background-color: #0f172a !important;
            }
            /* Verification seal container compression */
            .bg-emerald-50\/50 {
                padding: 1rem !important;
                background-color: #f0fdf4 !important;
                border-color: #d1fae5 !important;
            }
            /* Bottom footer block */
            .border-t.border-slate-100.bg-slate-50.p-6 {
                padding: 1rem !important;
                background-color: #f8fafc !important;
            }
        }
    </style>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-end mt-4 print:hidden">
        <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-xl shadow-xs transition duration-150 hover:-translate-y-0.5 active:translate-y-0 text-xs font-black uppercase tracking-widest cursor-pointer">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.82l-.24-2.1a.75.75 0 01.74-.83h9.56a.75.75 0 01.74.83l-.24 2.1m-10.56 0h10.56L18 19.5H6l-.72-5.68zM16.5 9V5.25A2.25 2.25 0 0014.25 3h-4.5A2.25 2.25 0 007.5 5.25V9M18 12a1 1 0 100-2 1 1 0 000 2z" />
            </svg>
            Print Consultation EHR
        </button>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 mt-6">
        {{-- Main Document Card --}}
        <div class="bg-white shadow-[0_20px_50px_rgba(0,0,0,0.04)] rounded-3xl border border-slate-100 overflow-hidden">
            
            {{-- Document Header --}}
            <div class="bg-slate-900 text-white p-8 sm:p-10 relative overflow-hidden">
                <div class="absolute -right-8 -top-8 w-40 h-40 bg-rose-500/10 rounded-full blur-2xl"></div>
                <div class="absolute -left-10 -bottom-10 w-36 h-36 bg-emerald-500/10 rounded-full blur-xl"></div>
                
                <div class="relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 z-10">
                    <div>
                        <span class="bg-rose-500/20 text-rose-300 border border-rose-500/30 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">
                            Electronic Health Record
                        </span>
                        <h1 class="text-3xl font-black tracking-tight mt-3 uppercase">Consultation Ledger</h1>
                        <p class="text-slate-400 text-xs font-bold mt-1">Ref ID: #{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="text-left sm:text-right shrink-0">
                        <p class="font-black text-white text-lg leading-snug">PointCare Smart Clinic</p>
                        <p class="text-xs text-slate-400 font-semibold">Ledger Verification Standard</p>
                        
                        <div class="mt-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-500/30 bg-emerald-500/10 text-emerald-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mr-1.5 animate-pulse"></span>
                                {{ $appointment->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Metadata Grid --}}
            <div class="border-b border-slate-100 bg-slate-50/50 p-8 sm:p-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    {{-- Patient Info --}}
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 font-black text-sm shrink-0">
                            Pt
                        </div>
                        <div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block">Patient</span>
                            <p class="font-bold text-slate-800 text-sm mt-0.5">{{ $appointment->patient->name }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $appointment->patient->email }}</p>
                        </div>
                    </div>

                    {{-- Doctor Info --}}
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-cyan-50 border border-cyan-100 flex items-center justify-center text-cyan-600 font-black text-sm shrink-0">
                            Dr
                        </div>
                        <div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block">Attending Doctor</span>
                            <p class="font-bold text-slate-800 text-sm mt-0.5">Dr. {{ preg_replace('/^dr\.?\s+/i', '', $appointment->doctor->name) }}</p>
                            <p class="text-xs text-slate-450 mt-0.5">{{ $appointment->doctor->doctor->specialization ?? 'General Medicine' }}</p>
                        </div>
                    </div>

                    {{-- Date Info --}}
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 font-black text-sm shrink-0">
                            Dt
                        </div>
                        <div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block">Consultation Date</span>
                            <p class="font-bold text-slate-800 text-sm mt-0.5">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('d F Y') }}</p>
                            <p class="text-xs text-slate-450 mt-0.5">Time: {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Clinical Content Sections --}}
            <div class="p-8 sm:p-10 space-y-10">
                
                {{-- Reason for Visit --}}
                <div class="relative pl-6 border-l-2 border-rose-300">
                    <h3 class="text-[10px] font-black text-rose-500 uppercase tracking-widest mb-1.5">Reason for Booking</h3>
                    <p class="text-slate-700 text-sm font-semibold leading-relaxed italic">
                        "{{ $appointment->reason ?? 'Routine consultation request.' }}"
                    </p>
                </div>

                <hr class="border-slate-100" />

                {{-- Patient Complaints & Symptoms --}}
                <div class="relative pl-6 border-l-2 border-cyan-300">
                    <h3 class="text-[10px] font-black text-cyan-600 uppercase tracking-widest mb-1.5">Clinical Presentation & Symptoms</h3>
                    <p class="text-slate-600 text-sm font-medium leading-relaxed">
                        {{ $appointment->symptoms ?? 'No specific symptoms or complaints logged by the attending staff.' }}
                    </p>
                </div>

                <hr class="border-slate-100" />

                {{-- Official Diagnosis --}}
                <div class="relative pl-6 border-l-2 border-amber-300">
                    <h3 class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-1.5">Attending Diagnosis</h3>
                    <p class="text-slate-600 text-sm font-medium leading-relaxed">
                        {{ $appointment->diagnosis ?? 'Routine Clinical Evaluation' }}
                    </p>
                </div>

                {{-- Prescription Block --}}
                <div class="bg-slate-900 text-white rounded-2xl p-6 sm:p-8 relative overflow-hidden mt-8 shadow-inner">
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/5 rounded-full"></div>
                    <div class="relative z-10">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Prescribed Plan & Medications</span>
                        <p class="text-sm font-bold text-slate-100 leading-relaxed">
                            {{ $appointment->prescription ?? 'No medication prescription required.' }}
                        </p>
                    </div>
                </div>

                

            </div>
            
            {{-- Document Footer --}}
            <div class="border-t border-slate-100 bg-slate-50 p-6 text-center">
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                    PointCare smart EHR ledger &bull; Generated on {{ now()->format('d M Y, h:i A') }}
                </p>
            </div>
        </div>
    </div>
</x-layout>
