<x-layout.layout title="Contact Us">

    {{-- Hero Section --}}
    <div class="w-full flex flex-col items-center pt-16 md:pt-24 px-4 text-center space-y-4">
        <span class="px-4 py-1.5 rounded-full text-xs font-black tracking-widest uppercase bg-rose-50 text-rose-600 border border-rose-100/80 animate__animated animate__fadeInDown">
            Contact Support
        </span>
        <h1 class="text-4xl md:text-5xl font-black text-foreground tracking-tight max-w-2xl">
            We are Here to <span class="text-primary">Support You</span>
        </h1>
        <p class="text-base text-muted-foreground max-w-xl font-medium leading-relaxed">
            Have questions about clinical scheduling, technical setups, or account credentials? Choose a contact method or send us a message directly.
        </p>
        <div class="w-24 h-1 bg-primary/20 rounded-full pt-2"></div>
    </div>

    {{-- Main Container --}}
    <div class="max-w-6xl mx-auto px-4 py-16 grid grid-cols-1 lg:grid-cols-12 gap-12">

        {{-- Left Column: Contact Cards --}}
        <div class="lg:col-span-5 space-y-6">
            
            {{-- Card 1: Clinical Desk --}}
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-xs hover:-translate-y-0.5 transition duration-300 space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-10.5h16.5M2.25 9h19.5M4.5 12h15m-15 3h15m-15 3h15" />
                    </svg>
                </div>
                <h3 class="text-lg font-black text-slate-800 uppercase tracking-wide">Clinical Support Desk</h3>
                <div class="space-y-2 text-sm text-slate-500 font-medium leading-relaxed">
                    <p class="flex items-center gap-2.5">
                        <span class="text-slate-400">📞</span> +60 3-1234 5678
                    </p>
                    <p class="flex items-center gap-2.5">
                        <span class="text-slate-400">✉️</span> clinical@pointcare.com
                    </p>
                    <p class="flex items-center gap-2.5">
                        <span class="text-slate-400">🕒</span> Mon - Fri: 8:00 AM - 5:00 PM
                    </p>
                </div>
            </div>

            {{-- Card 2: Tech Desk --}}
            <div class="bg-white border border-slate-100 rounded-3xl p-8 shadow-xs hover:-translate-y-0.5 transition duration-300 space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </div>
                <h3 class="text-lg font-black text-slate-800 uppercase tracking-wide">Technical Inquiries</h3>
                <div class="space-y-2 text-sm text-slate-500 font-medium leading-relaxed">
                    <p class="flex items-center gap-2.5">
                        <span class="text-slate-400">✉️</span> techsupport@pointcare.com
                    </p>
                    <p class="flex items-center gap-2.5">
                        <span class="text-slate-400">⚡</span> Response Time: Under 24 Hours
                    </p>
                </div>
            </div>

            {{-- Urgent Emergency Notice --}}
            <div class="bg-amber-50/50 border border-amber-100 rounded-3xl p-8 shadow-2xs space-y-4">
                <div class="flex items-center gap-2 text-amber-600 font-black text-sm uppercase tracking-wider">
                    <span>⚠️</span> Urgent Notice
                </div>
                <p class="text-xs text-amber-700 leading-relaxed font-medium">
                    If you are experiencing a medical emergency or require immediate clinical attention, please call **999** or proceed directly to your nearest emergency department.
                </p>
            </div>

        </div>

        {{-- Right Column: Interactive Form --}}
        <div class="lg:col-span-7">
            <div class="bg-white border border-slate-100 rounded-3xl p-8 md:p-10 shadow-xs">
                <h3 class="text-xl font-black text-slate-900 mb-2 tracking-tight">Send a Message</h3>
                <p class="text-xs text-slate-450 font-semibold mb-8 uppercase tracking-widest">We will get back to you shortly</p>

                <form action="/contact" method="POST" class="space-y-6">
                    @csrf

                    {{-- Name Input --}}
                    <x-form.field name="name" label="Your Name" placeholder="e.g. John Doe" required />

                    {{-- Email Input --}}
                    <x-form.field name="email" label="Email Address" type="email" placeholder="e.g. john@example.com" required />

                    {{-- Subject Selection --}}
                    <div class="space-y-1.5 w-full mb-5">
                        <label for="subject" class="block text-sm font-black text-slate-700 tracking-tight ml-1">
                            Inquiry Type
                        </label>
                        <select name="subject" id="subject" 
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 transition-all duration-200 outline-none focus:border-rose-500 focus:ring-4 focus:ring-rose-100 text-slate-900 text-sm font-semibold">
                            <option value="General Inquiries">General Inquiries</option>
                            <option value="Patient Booking Help">Patient Booking Help</option>
                            <option value="Medical Staff Credentials">Medical Staff Credentials</option>
                            <option value="Technical System Bugs">Technical System Bugs</option>
                        </select>
                        @error('subject')
                            <p class="text-red-500 text-[11px] font-bold italic uppercase tracking-wider mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Message Textarea --}}
                    <div class="space-y-1.5 w-full mb-5">
                        <label for="message" class="block text-sm font-black text-slate-700 tracking-tight ml-1">
                            Message
                        </label>
                        <textarea name="message" id="message" rows="5" placeholder="How can we assist you?" 
                                  class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 transition-all duration-200 outline-none focus:border-rose-500 focus:ring-4 focus:ring-rose-100 text-slate-900 text-sm font-semibold resize-none">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="flex items-center space-x-1 ml-1 mt-1">
                                <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                <p class="text-red-500 text-[11px] font-bold italic uppercase tracking-wider leading-none">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" 
                            class="w-full py-3.5 px-4 rounded-xl bg-primary text-white text-sm font-black shadow-md hover:bg-rose-600 transition-all duration-200 transform hover:-translate-y-0.5 tracking-wider uppercase">
                        Send Message
                    </button>
                </form>
            </div>
        </div>

    </div>

</x-layout.layout>
