<nav class="bg-[#302e2e] text-white p-4 shadow-md">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <!-- Logo -->
        <div class="text-lg font-bold">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logos/Tienda_PC_Logo_500x500.png') }}" alt="Logo" class="h-14">
            </a>
        </div>

        <!-- Links de Navegación -->
        <div class="flex space-x-4">
            <a href="{{ route('home') }}" class="hover:text-gray-300">Home</a>
            <a href="{{ route('dashboard') }}" class="hover:text-gray-300">Dashboard</a>
        </div>

        <!-- Login / Register o Usuario Logueado -->
        <div class="flex space-x-4">
            @auth
                <span>{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="hover:text-gray-300">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:text-gray-300">Login</a>
                <a href="{{ route('register') }}" class="hover:text-gray-300">Register</a>
            @endauth
        </div>
    </div>
</nav>
