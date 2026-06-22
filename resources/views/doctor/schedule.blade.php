<x-layout title="Doctor Schedule">
    <x-return />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        
        {{-- Header Section --}}
        <div class="mt-8 mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <span class="bg-rose-100 text-rose-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">
                        Schedule Management
                    </span>
                    <span class="text-slate-400 text-xs font-medium">{{ now('Asia/Kuala_Lumpur')->format('l, d F Y') }}</span>
                </div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Calendar & Schedule</h1>
                <p class="text-slate-500 font-medium mt-1">Track your bookings and organize your consultation days.</p>
            </div>
            
            {{-- Month Navigation Controls --}}
            <div class="flex items-center space-x-4 bg-white border border-slate-100 p-2 rounded-2xl shadow-xs">
                <a href="?month={{ $prevMonthStr }}{{ request('date') ? '&date='.request('date') : '' }}" 
                   class="p-2 rounded-xl text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition"
                   title="Previous Month">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <span class="text-sm font-black text-slate-800 tracking-wide uppercase px-2 min-w-[120px] text-center">
                    {{ $currentMonth->format('F Y') }}
                </span>
                <a href="?month={{ $nextMonthStr }}{{ request('date') ? '&date='.request('date') : '' }}" 
                   class="p-2 rounded-xl text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition"
                   title="Next Month">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        {{-- Main Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            {{-- Left: Calendar View --}}
            <div class="lg:col-span-2 bg-white shadow-[0_20px_50px_rgba(0,0,0,0.03)] rounded-[2.5rem] border border-slate-100 p-6 sm:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-black text-slate-900 tracking-tight">Monthly Planner</h2>
                    <div class="flex items-center space-x-2 text-xs text-slate-400 font-medium">
                        <span class="w-2.5 h-2.5 bg-rose-500 rounded-full"></span>
                        <span>Has Appointments</span>
                    </div>
                </div>

                {{-- Weekdays Header --}}
                <div class="grid grid-cols-7 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-3">
                    <div>Sun</div>
                    <div>Mon</div>
                    <div>Tue</div>
                    <div>Wed</div>
                    <div>Thu</div>
                    <div>Fri</div>
                    <div>Sat</div>
                </div>

                {{-- Calendar Days Grid --}}
                <div class="grid grid-cols-7 gap-2 mt-4">
                    @foreach ($daysGrid as $day)
                        @php
                            $isSelected = $selectedDate && $selectedDate->format('Y-m-d') === $day['date_str'];
                            $hasAppointments = $day['appointments_count'] > 0;
                            
                            // Styling Logic
                            $dayClasses = 'relative h-14 sm:h-20 flex flex-col justify-between p-2 rounded-2xl transition-all duration-200 select-none ';
                            if ($isSelected) {
                                $dayClasses .= 'bg-rose-500 text-white shadow-md shadow-rose-200';
                            } elseif ($day['is_today']) {
                                $dayClasses .= 'bg-rose-50 border border-rose-200 text-rose-600 font-bold';
                            } elseif (!$day['is_current_month']) {
                                $dayClasses .= 'text-slate-300 bg-slate-50/50 cursor-pointer hover:bg-slate-50';
                            } else {
                                $dayClasses .= 'text-slate-700 bg-white hover:bg-rose-50/50 hover:text-rose-600 cursor-pointer';
                            }
                        @endphp
                        
                        <a href="?month={{ $currentMonth->format('Y-m') }}&date={{ $day['date_str'] }}" class="{{ $dayClasses }}">
                            <span class="text-xs sm:text-sm font-bold">{{ $day['day_num'] }}</span>
                            
                            {{-- Appointment Indicators --}}
                            @if ($hasAppointments)
                                <div class="flex justify-center items-center gap-1 mt-auto">
                                    @if ($isSelected)
                                        <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                                    @else
                                        <span class="w-1.5 h-1.5 bg-rose-500 rounded-full animate-pulse"></span>
                                    @endif
                                    @if ($day['appointments_count'] > 1)
                                        <span class="text-[9px] font-bold leading-none {{ $isSelected ? 'text-rose-100' : 'text-slate-400' }}">
                                            +{{ $day['appointments_count'] - 1 }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Right: Status & Quick Info --}}
            <div class="space-y-6">
                {{-- Legend & Summary Stats Card --}}
                <div class="bg-white shadow-[0_20px_50px_rgba(0,0,0,0.03)] rounded-[2.5rem] border border-slate-100 p-6 sm:p-8">
                    <h3 class="text-base font-black text-slate-900 tracking-tight mb-4">Month Summary</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2.5 border-b border-slate-50">
                            <span class="text-xs text-slate-500 font-medium">Total Bookings</span>
                            <span class="text-sm font-black text-slate-800">
                                {{ $filteredAppointments->count() }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-2.5 border-b border-slate-50">
                            <span class="text-xs text-slate-500 font-medium">Pending Approvals</span>
                            <span class="text-sm font-black text-amber-600">
                                {{ $filteredAppointments->where('status', 'pending')->count() }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-2.5">
                            <span class="text-xs text-slate-500 font-medium">Confirmed / Complete</span>
                            <span class="text-sm font-black text-emerald-600">
                                {{ $filteredAppointments->whereIn('status', ['confirmed', 'completed'])->count() }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Interactive Tips --}}
                <div class="bg-slate-900 text-white rounded-[2.5rem] p-6 shadow-xl">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-8 h-8 bg-slate-800 text-rose-500 flex items-center justify-center rounded-xl">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-black uppercase tracking-widest text-slate-200">Planner Tips</h4>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Click on any day in the monthly planner grid to filter the list below to that date. To clear the filter and view the full month's list, click the "Clear Filter" button in the list section.
                    </p>
                </div>
            </div>
        </div>

        {{-- Bottom Section: Appointments List --}}
        <div class="mt-8 bg-white shadow-[0_20px_50px_rgba(0,0,0,0.03)] rounded-[2.5rem] border border-slate-100 overflow-hidden">
            <div class="p-6 sm:p-10 border-b border-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight">
                        @if ($selectedDate)
                            Appointments for {{ $selectedDate->format('d F Y') }}
                        @else
                            All Appointments ({{ $currentMonth->format('F Y') }})
                        @endif
                    </h2>
                    <p class="text-slate-500 text-xs font-medium mt-1">
                        Showing {{ $filteredAppointments->count() }} patient consultation bookings.
                    </p>
                </div>
                
                @if ($selectedDate)
                    <a href="?month={{ $currentMonth->format('Y-m') }}" 
                       class="px-4 py-2 border border-rose-100 text-rose-600 hover:bg-rose-50 text-xs font-bold uppercase tracking-wider rounded-xl transition-all self-start sm:self-center">
                        Clear Filter
                    </a>
                @endif
            </div>
            
            <div class="p-6 sm:p-10">
                @if ($filteredAppointments->isEmpty())
                    <div class="py-16 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-slate-50 rounded-full mb-4">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800">No scheduled appointments</h3>
                        <p class="text-slate-400 text-sm mt-1">There are no consultations scheduled for this period.</p>
                    </div>
                @else
                    <x-table :appointments="$filteredAppointments" role="doctor" />
                @endif
            </div>
        </div>

    </div>
</x-layout>
