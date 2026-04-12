<x-layout.layout title="Login" >

    <x-form title="Log in to Your Account" description="Welcome back! Please enter your details.">

            <form action="/login" method="POST" class="mt-10 space-y-6">
                @csrf

                <x-form.field name="email" label="Email" type="email" />
                <x-form.field name="password" label="Password" type="password" />

                <button data-test="login-button" type="submit" class="btn btn-neutral mt-2 h-10 w-full shadow hover:shadow-lg transition">Sign In</button>

            </form>
            <p class="text-center text-sm mt-2">New to our platform ? <a href="/register" class="text-blue-300 hover:underline">Register</a> now.</p>


    </x-form>
</x-layout.layout>
