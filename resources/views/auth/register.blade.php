<x-layout.layout title="Register" >

    <x-form title="Register an Account" description="Start your appointment today!">

            <form action="/register" method="POST" class="mt-8 space-y-6">
                @csrf

                <x-form.field name="name" label="Name" />
                <x-form.field name="email" label="Email" type="email" />
                <x-form.field name="password" label="Password" type="password" />

                <button type="submit" class="btn btn-neutral mt-2 h-10 w-full shadow hover:shadow-lg transition">Create Account</button>

            </form>

                <p class="text-center text-sm mt-2">Already have an account ? <a href="/login" class="text-blue-500 hover:underline">Log in</a> now.</p>

    </x-form>
</x-layout.layout>
