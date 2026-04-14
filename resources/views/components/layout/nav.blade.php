<nav class="border-b border-border ph-6">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 2xl:px-0 h-16 flex items-center justify-between">
        <div class="mt-0">

           <a href="/" alt="Idea logo">
                <x-icons.logo />
           </a>
        </div>

        <div class="flex gap-x-5">
            @auth
                <a href="{{ route('profile.edit') }}">Edit Profile</a>
                <form method="POST" action="/logout">
                    @csrf


                    <button>Log Out</button>
                </form>
            @endauth
            @guest
                <a href="/login">Sign In</a>
                <a href="/register" class="btn">Register</a>
            @endguest
        </div>
    </div>
</nav>
