@props([
    'title' => 'Smart Clinic'
])
<!DOCTYPE html>
<html lang="en" class="h-full" data-theme="corporate">
<head >
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="overflow-x-hidden bg-background text-foreground h-full pt-2 ">

    <div class="mx-auto min-h-screen flex flex-col">
        <x-layout.nav />
        <main class=" grow">
            {{$slot}}
        </main>
    </div>

    @session('success')
        <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 2000)"
        x-show="show"
        x-transition.opacity.duration.500ms
        class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow">
            {{ session('success') }}
        </div>
    @endsession

     <x-scroll/>
    <x-layout.footer />

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Success Message (Alert Session)
        @if(session('alert'))
            Swal.fire({
                icon: 'success',
                title: '<span class="text-slate-900 font-black uppercase tracking-widest text-lg">Success!</span>',
                text: @json(session('alert')),
                background: '#ffffff',
                confirmButtonText: 'CONTINUE',
                confirmButtonColor: '#f43f5e', // Rose-500
                customClass: {
                    popup: 'rounded-[2.5rem] border border-slate-100 shadow-2xl',
                    confirmButton: 'rounded-xl font-black px-8 py-3 text-xs tracking-widest uppercase',
                    title: 'pt-4',
                    htmlContainer: 'text-slate-500 font-medium'
                },
                buttonsStyling: true,
                showClass: {
                    popup: 'animate__animated animate__fadeInUp animate__faster'
                }
            });
        @endif

        // Error Message (Action Failed)
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                iconColor: '#f43f5e',
                title: '<span class="text-rose-600 font-black uppercase tracking-widest text-lg">Action Blocked</span>',
                text: @json(session('error')),
                background: '#fff1f2', // Very light Rose tint
                confirmButtonText: 'UNDERSTOOD',
                confirmButtonColor: '#0f172a', // Slate-900 (Looks serious for errors)
                customClass: {
                    popup: 'rounded-[2.5rem] border border-rose-100 shadow-2xl',
                    confirmButton: 'rounded-xl font-black px-8 py-3 text-xs tracking-widest uppercase',
                    title: 'pt-4',
                    htmlContainer: 'text-rose-900/70 font-medium'
                },
                buttonsStyling: true
            });
        @endif
    });
</script>

</body>

</html>
