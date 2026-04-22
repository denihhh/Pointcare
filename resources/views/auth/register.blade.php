<x-layout.layout title="Register">

    <x-form title="Register an Account" description="Start your appointment today!">

        <form action="/register" method="POST" class="mt-8 space-y-6">
            @csrf

            <x-form.field name="name" label="Name" />
            <x-form.field name="email" label="Email" type="email" placeholder="Email@example.com" />
            <x-form.field name="password" label="Password" type="password" />

            <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-2xl shadow-lg shadow-rose-200 text-sm font-black text-white bg-rose-500 hover:bg-rose-600 transition-all hover:-translate-y-0.5 active:translate-y-0">
                Create Account
            </button>
        </form>

        <p class="text-center text-sm mt-8 text-slate-500">Already have an account ? <a href="/login"
                class="font-bold text-rose-600 hover:text-rose-700 transition-colors underline underline-offset-4 decoration-rose-100">
                Log in</a> now.</p>

    </x-form>
</x-layout.layout>
