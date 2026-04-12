<nav class="border-b border-border px-6 ">
    <div class="max-w-7xl mx-auto flex items-center h-16">

        <!-- Logo Section -->
        <div class="flex-1 flex justify-start items-center"><a href="/">
            <img src="{{ asset('images/M_Logo.png') }}"
           alt="Smart Clinic Logo"
           class="h-8 w-auto md:h-10 object-contain " />
           </a>
        </div>

        <!-- Navigation Links -->
        <div class="flex-1 flex justify-center gap-x-8">
            <a href="/">Home</a>
            <a href="/about">About</a>
            <a href="/contact">Contact</a>
        </div>

        <!-- User Actions -->
        <div class="flex-1 flex justify-end gap-x-5 text-center">
            @auth
                <form method="POST" action="/logout">
                    @csrf
                    <button data-test="logout-button" type="submit" class="btn outline-1 bg-black hover:bg-green-600 hover:text-black  text-white" >
                        Logout
                    </button>
                </form>
            @endauth

            @guest
                <a href="/login" class="btn outline-1 bg-black hover:bg-green-600 hover:text-black  text-white" >Login</a>
                <a href="/register" class="btn outline-1 btn-secondary">Register</a>
            @endguest

        </div>
    </div>

</nav>
