<x-layout.layout>

    <div class="py-12 px-6">
        @auth
                <x-layout.homepage :upcomingAppointment="$upcomingAppointment" />

        @else
            <div class="text-center py-20">
                <h1 class="text-5xl font-bold text-foreground mb-6">Smart Clinic Management</h1>
                <p class="text-gray-600 mb-8">Professional healthcare scheduling at your fingertips.</p>
                <div class="space-x-4">
                    <a href="/login" class="bg-primary text-white px-6 py-2 rounded-md">Login</a>
                    <a href="/register" class="border border-primary text-primary px-6 py-2 rounded-md">Register</a>
                </div>
            </div>
        @endauth
    </div>
    @guest
        <div class="flex justify-center space-x-4">
            <a href="/register" class="btn btn-primary">
                Get Started
            </a>


            <a href="/login" class="btn btn-secondary">
                Member Login
            </a>
        </div>
    @endguest

    @auth
        <div class="flex justify-center space-x-4 ">
            <a href="/dashboard"
                class="inline-block bg-primary text-white px-8 py-3 rounded-full font-bold hover:bg-red-500 transition shadow-lg">
                View Appointments
            </a>
        </div>
    @endauth


    <x-card />
</x-layout.layout>
