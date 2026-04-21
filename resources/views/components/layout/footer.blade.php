<footer class="w-full bg-white border-t border-slate-200 mt-20">
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">

            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                        <x-logo.weblogo class="h-8 w-auto md:h-12 text-red-600" />
                    </div>
                    <span class="text-2xl font-black text-slate-900 tracking-tight">PointCare</span>
                </div>
                <p class="text-slate-500 max-w-sm leading-relaxed text-sm">
                    Empowering patients and practitioners with seamless clinical scheduling and healthcare management. Dedicated to providing better accessibility for all.
                </p>
            </div>

            <div>
                <h4 class="text-sm font-bold text-slate-900 uppercase tracking-widest mb-6">System</h4>
                <ul class="space-y-4">
                    <li><a href="/dashboard" class="text-slate-500 hover:text-rose-500 transition-colors text-sm">Dashboard</a></li>
                    <li><a href="/appointments/create" class="text-slate-500 hover:text-rose-500 transition-colors text-sm">Book Appointment</a></li>
                    <li><a href="#" class="text-slate-500 hover:text-rose-500 transition-colors text-sm">Our Doctors</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-bold text-slate-900 uppercase tracking-widest mb-6">Support</h4>
                <ul class="space-y-4 text-sm text-slate-500">
                    <li class="flex items-center">
                        <span class="mr-2">📞</span> +60 3-1234 5678
                    </li>
                    <li class="flex items-center">
                        <span class="mr-2">📍</span> IIUM, Kuala Lumpur
                    </li>
                    <li><a href="#" class="hover:text-rose-500 transition-colors">Privacy Policy</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-slate-100 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-slate-400 text-xs">
                &copy; {{ date('Y') }} PointCare Clinical System. All rights reserved.
            </p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <span class="text-xs font-bold text-slate-300 uppercase tracking-tighter">Powered by Laravel & Herd</span>
            </div>
        </div>
    </div>
</footer>
