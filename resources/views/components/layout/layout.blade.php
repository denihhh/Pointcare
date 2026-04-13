@props(['title' => 'Smart Clinic'])
<!DOCTYPE html>
<html lang="en" class="h-full" data-theme="corporate">
<head >
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body class="bg-background text-foreground h-full pt-2">

    <div class="mx-auto min-h-screen flex flex-col">
        <x-layout.nav />
        <main class=" mt-8 grow">
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

    <x-layout.footer />

</body>

</html>
