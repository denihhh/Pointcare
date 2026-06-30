<div class="mb-10 mt-2">
    <div class="flex items-center justify-between relative">
        <!-- Step 1 -->
        <button type="button" @click="step = 1"
            class="flex flex-col items-center space-y-1.5 focus:outline-none z-10">
            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300"
                 :class="step === 1 ? 'bg-rose-500 text-white shadow-lg shadow-rose-200 ring-4 ring-rose-105' : (step > 1 ? 'bg-rose-105 text-rose-600' : 'bg-slate-50 text-slate-400 border border-slate-200')">
                <template x-if="step > 1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </template>
                <template x-if="step <= 1"><span>1</span></template>
            </div>
            <span class="text-[10px] font-black uppercase tracking-wider" :class="step >= 1 ? 'text-slate-800' : 'text-slate-400'">Doctor</span>
        </button>

        <!-- Connector 1-2 -->
        <div class="absolute left-0 right-0 top-5 h-0.5 bg-slate-100 -z-0">
            <div class="h-full bg-rose-500 transition-all duration-500" :style="'width: ' + (step > 1 ? '33.33%' : '0%')"></div>
        </div>

        <!-- Step 2 -->
        <button type="button" @click="if(doctorId) step = 2" :disabled="!doctorId"
            class="flex flex-col items-center space-y-1.5 focus:outline-none z-10 disabled:opacity-50">
            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300"
                 :class="step === 2 ? 'bg-rose-500 text-white shadow-lg shadow-rose-200 ring-4 ring-rose-105' : (step > 2 ? 'bg-rose-105 text-rose-600' : 'bg-slate-50 text-slate-400 border border-slate-200')">
                <template x-if="step > 2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </template>
                <template x-if="step <= 2"><span>2</span></template>
            </div>
            <span class="text-[10px] font-black uppercase tracking-wider" :class="step >= 2 ? 'text-slate-800' : 'text-slate-400'">Date & Reason</span>
        </button>

        <!-- Connector 2-3 -->
        <div class="absolute left-0 right-0 top-5 h-0.5 bg-slate-100 -z-0">
            <div class="h-full bg-rose-500 transition-all duration-500" :style="'width: ' + (step > 2 ? '66.66%' : '0%')"></div>
        </div>

        <!-- Step 3 -->
        <button type="button" @click="if(doctorId && selectedDate) step = 3" :disabled="!doctorId || !selectedDate"
            class="flex flex-col items-center space-y-1.5 focus:outline-none z-10 disabled:opacity-50">
            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300"
                 :class="step === 3 ? 'bg-rose-500 text-white shadow-lg shadow-rose-200 ring-4 ring-rose-105' : (step > 3 ? 'bg-rose-105 text-rose-600' : 'bg-slate-50 text-slate-400 border border-slate-200')">
                <template x-if="step > 3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </template>
                <template x-if="step <= 3"><span>3</span></template>
            </div>
            <span class="text-[10px] font-black uppercase tracking-wider" :class="step >= 3 ? 'text-slate-800' : 'text-slate-400'">Time</span>
        </button>

        <!-- Connector 3-4 -->
        <div class="absolute left-0 right-0 top-5 h-0.5 bg-slate-100 -z-0">
            <div class="h-full bg-rose-500 transition-all duration-500" :style="'width: ' + (step > 3 ? '100%' : '0%')"></div>
        </div>

        <!-- Step 4 -->
        <button type="button" @click="if(doctorId && selectedDate && selectedTime) step = 4" :disabled="!doctorId || !selectedDate || !selectedTime"
            class="flex flex-col items-center space-y-1.5 focus:outline-none z-10 disabled:opacity-50">
            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300"
                 :class="step === 4 ? 'bg-rose-500 text-white shadow-lg shadow-rose-200 ring-4 ring-rose-105' : 'bg-slate-50 text-slate-400 border border-slate-200'">
                <span>4</span>
            </div>
            <span class="text-[10px] font-black uppercase tracking-wider" :class="step === 4 ? 'text-slate-800' : 'text-slate-400'">Review</span>
        </button>
    </div>
</div>
