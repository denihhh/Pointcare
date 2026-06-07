<x-layout.layout title="Register">
    <div class="min-h-screen flex items-center justify-center px-4 relative ">
        <div class="relative z-10 w-full max-w-md">
        <x-form title="Sign Up" description="Start your appointment today!">

            <form action="/register" method="POST" class="mt-8 space-y-6">
                @csrf

                <x-form.field name="name" label="Name" />
                <x-form.field name="email" label="Email" type="email" placeholder="Email@example.com" />
                <x-form.field name="password" label="Password" type="password" />

                <button type="submit"
                    class="w-full py-3 px-4 rounded-2xl bg-primary text-white font-black shadow-md hover:opacity-90 transition">
                    Create Account
                </button>
            </form>

            <p class="text-center text-sm mt-6 text-slate-500">Already have an account ? <a href="/login"
                    class="text-primary font-bold underline underline-offset-4">
                    Log in</a> now.</p>

        </x-form>
    </div>

    </div>
</x-layout.layout>
