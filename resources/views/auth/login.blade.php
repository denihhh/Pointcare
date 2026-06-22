<x-layout.layout title="Login" :showFooter="false">
    
    {{-- Unified Layout Wrapper: Pushes down comfortably from the navbar --}}
    <div class="w-full flex flex-col items-center pt-16 md:pt-24 px-4 pb-12">
        <div class="w-full max-w-md">

            <x-form
                title="Login"
                description="Welcome back! Please enter your details."
            >
                <form action="/login" method="POST" class="space-y-6">
                    @csrf

                    <x-form.field name="email" label="Email" type="email" placeholder="email@example.com" />
                    <x-form.field name="password" label="Password" type="password" />

                    <button type="submit" dusk="login-button"
                        class="w-full py-3 px-4 rounded-2xl bg-primary text-white font-black shadow-md hover:opacity-90 transition">
                        Sign In
                    </button>
                </form>

                <p class="text-center text-sm mt-6 text-muted-foreground">
                    New here?
                    <a href="/register" class="text-primary font-bold underline underline-offset-4">
                        Create account
                    </a>
                </p>

            </x-form>

        </div>
    </div>

</x-layout.layout>