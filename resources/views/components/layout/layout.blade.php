@props([
    'title' => 'Smart Clinic',
])
<!DOCTYPE html>
<html lang="en" class="h-full" data-theme="corporate">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="overflow-x-hidden bg-background text-foreground h-full">

    {{-- The main structural container switches depending on auth states --}}
    @auth
        {{-- Logged-In Layout: Sidebar Left, Content Right --}}
        <div class="min-h-screen flex flex-col lg:flex-row" x-data="{ sidebarOpen: false }">

            {{-- Responsive Sidebar Component Component --}}
            <x-layout.sidebar />

            {{-- Main Application Wrapper Window --}}
            <div class="flex-1 flex flex-col min-w-0 min-h-screen lg:pl-64">

                {{-- Mobile Top Sticky Bar (Only visible on small devices to open the sidebar) --}}
                <div
                    class="sticky top-0 z-40 flex items-center justify-between h-16 bg-white border-b border-rose-100 px-4 md:px-8 lg:hidden print:hidden">
                    
                    <a href="/" class=" flex items-center">
                        <div
                            class="w-9 h-9 rounded-xl bg-gradient-to-br from-rose-500 to-rose-600 flex items-center justify-center shadow-xs">
                            <x-logo.weblogo class="h-5 w-5 text-white" />
                        </div>
                        <div class="ml-3">
                            <p class="text-base font-black text-slate-900 tracking-tight">PointCare</p>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block -mt-1">
                                {{ auth()->user()->role === 'patient' ? 'Patient Portal' : 'Clinical Desk' }}
                            </span>
                        </div>
                    </a>
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="p-2 rounded-xl bg-slate-50 border border-slate-100 text-slate-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                {{-- Application Core Slot Window --}}
                <main class="flex-1 p-4 md:p-6 lg:p-10 ">
                    {{ $slot }}
                </main>

                <x-layout.footer />
            </div>
        </div>
    @else
        {{-- Guest Marketing Layout: Standard Top Navbar Architecture --}}
        <div class="mx-auto min-h-screen flex flex-col">
            <x-layout.nav />
            <main class="grow">
                {{ $slot }}
            </main>
            <x-layout.footer />
        </div>
    @endauth

    @session('success')
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show" x-transition.opacity.duration.500ms
            class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow z-50">
            {{ session('success') }}
        </div>
    @endsession

    <x-scroll />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('alert'))
                Swal.fire({
                    icon: 'success',
                    title: '<span class="text-slate-900 font-black uppercase tracking-widest text-lg">Success!</span>',
                    text: @json(session('alert')),
                    background: '#ffffff',
                    confirmButtonText: 'CONTINUE',
                    confirmButtonColor: '#f43f5e',
                    customClass: {
                        popup: 'rounded-[2.5rem] border border-slate-100 shadow-2xl',
                        confirmButton: 'rounded-xl font-black px-8 py-3 text-xs tracking-widest uppercase',
                    },
                    buttonsStyling: true,
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    iconColor: '#f43f5e',
                    title: '<span class="text-rose-600 font-black uppercase tracking-widest text-lg">Action Blocked</span>',
                    text: @json(session('error')),
                    background: '#fff1f2',
                    confirmButtonText: 'UNDERSTOOD',
                    confirmButtonColor: '#0f172a',
                    customClass: {
                        popup: 'rounded-[2.5rem] border border-rose-100 shadow-2xl',
                        confirmButton: 'rounded-xl font-black px-8 py-3 text-xs tracking-widest uppercase',
                    },
                    buttonsStyling: true
                });
            @endif
        });
    </script>
    @livewireScriptConfig
</body>

</html>
