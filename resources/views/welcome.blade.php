<x-layout.layout>

    <x-layout.section-heading title="Modern Healthcare, Simplified">
        Experience a smarter way to manage your clinic visits.
    </x-layout.section-heading>

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
        <a href="/dashboard" class="btn btn-primary h-12 font-bold hover:bg-green-600 hover:text-black transition">
            Booking Now!
        </a>
    </div>
    @endauth


    <x-card/>
</x-layout.layout>
