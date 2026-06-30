<div x-show="step === 1" x-cloak x-transition:enter="transition ease-out duration-350" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
    <div class="text-center sm:text-left">
        <h2 class="text-xl font-black text-slate-900 tracking-tight">Choose Your Physician</h2>
        <p class="text-slate-450 text-xs mt-1">Select from our expert doctors to proceed with your booking.</p>
    </div>

    <!-- Search and Filter Bar -->
    <div class="flex flex-col md:flex-row gap-4 items-stretch md:items-center justify-between pb-2">
        <div class="relative flex-1">
            <input type="text" x-model="doctorSearch" placeholder="Search by name or specialization..."
                class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 outline-none focus:border-rose-500 focus:ring-4 focus:ring-rose-100 text-sm transition-all duration-200">
            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        
        <!-- Specialty Pills Slider -->
        <div class="flex items-center space-x-2 overflow-x-auto pb-1 scrollbar-thin md:max-w-xs">
            <button type="button" @click="selectedSpecialization = 'All'"
                class="px-4 py-2 rounded-xl text-xs font-black whitespace-nowrap transition-all duration-200"
                :class="selectedSpecialization === 'All' ? 'bg-rose-500 text-white shadow-xs' : 'bg-slate-50 border border-slate-150 text-slate-600 hover:bg-slate-100'">
                All Care
            </button>
            <template x-for="spec in getSpecializations()" :key="spec">
                <button type="button" @click="selectedSpecialization = spec"
                    class="px-4 py-2 rounded-xl text-xs font-black whitespace-nowrap transition-all duration-200"
                    :class="selectedSpecialization === spec ? 'bg-rose-500 text-white shadow-xs' : 'bg-slate-50 border border-slate-150 text-slate-600 hover:bg-slate-100'">
                    <span x-text="spec"></span>
                </button>
            </template>
        </div>
    </div>

    <!-- Doctors Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <template x-for="doctor in filteredDoctors()" :key="doctor.id">
            <div @click="selectDoctor(doctor)" 
                 class="p-5 rounded-2xl border transition-all duration-300 cursor-pointer flex flex-col justify-between hover:shadow-md group relative overflow-hidden"
                 :class="doctorId === doctor.id ? 'border-rose-500 bg-rose-50/20 ring-1 ring-rose-500' : 'border-slate-150 bg-white hover:-translate-y-0.5 hover:border-slate-300'">
                
                <!-- Selected Indicator -->
                <div x-show="doctorId === doctor.id" class="absolute top-0 right-0 bg-rose-500 text-white text-[9px] font-black uppercase tracking-widest px-3 py-1 rounded-bl-xl shadow-xs">
                    Selected
                </div>

                <div>
                    <!-- Doctor Header -->
                    <div class="flex items-start gap-4">
                        <!-- Dynamic Initials Avatar -->
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white font-extrabold text-lg shadow-sm shrink-0 bg-gradient-to-br"
                             :class="getDoctorGradient(doctor.id)">
                            <span x-text="getInitials(doctor.name)"></span>
                        </div>
                        
                        <div class="space-y-1">
                            <h3 class="text-sm sm:text-base font-black text-slate-900 group-hover:text-rose-600 transition-colors" x-text="'Dr. ' + cleanDoctorName(doctor.name)"></h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-rose-50 text-rose-600 border border-rose-100/50" x-text="doctor.doctor ? doctor.doctor.specialization : 'General Practitioner'"></span>
                        </div>
                    </div>

                    <!-- Bio summary -->
                    <p class="text-xs text-slate-500 mt-4 line-clamp-2" x-text="doctor.doctor ? doctor.doctor.bio : 'No profile description available.'"></p>
                </div>

                <!-- Card Footer info -->
                <div class="flex items-center justify-between border-t border-slate-100 mt-5 pt-3">
                    <div class="text-[10px] text-slate-400 uppercase font-black tracking-wider">
                        Consultation Fee
                    </div>
                    <div class="text-sm font-black text-slate-900" x-text="'RM ' + parseFloat(doctor.doctor ? doctor.doctor.consultation_fee : 60).toFixed(2)"></div>
                </div>
            </div>
        </template>
    </div>
    
    <!-- Empty Search State -->
    <div x-show="filteredDoctors().length === 0" x-cloak class="text-center py-12 bg-slate-50 border border-dashed border-slate-200 rounded-3xl">
        <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <h3 class="text-slate-700 font-bold text-sm">No Physicians Found</h3>
        <p class="text-slate-440 text-xs mt-1">Try resetting the specialization filter or typing a different name.</p>
    </div>

    <!-- Step Footer Navigation -->
    <div class="flex justify-end pt-4 border-t border-slate-100">
        <button type="button" @click="step = 2" :disabled="!doctorId"
            class="px-6 py-3 rounded-xl bg-slate-900 text-white font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
            Next Step
        </button>
    </div>
</div>
