<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Estilos -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-100">
    <!-- Barra de navegación -->
    <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('home') }}">
                            <x-application-mark class="block h-9 w-auto" />
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                            {{ __('Inicio') }}
                        </x-nav-link>
                        <x-nav-link href="">
                            {{ __('Productos') }}
                        </x-nav-link>
                        <x-nav-link href="" :active="request()->routeIs('contact')">
                            {{ __('Contacto') }}
                        </x-nav-link>
                    </div>
                </div>

                <!-- Authentication Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none">
                            {{ __('Mi cuenta') }}
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="#434343">
                                <path
                                    d="M480-120v-80h280v-560H480v-80h280q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H480Zm-80-160-55-58 102-102H120v-80h327L345-622l55-58 200 200-200 200Z" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg py-1">
                            @guest
                                <a href="{{ route('login') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    {{ __('Ingresar') }}
                                </a>
                                <a href="{{ route('register') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    {{ __('Registrarse') }}
                                </a>
                            @endguest

                            @auth
                                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                                    {{ __('Profile') }}
                                </x-responsive-nav-link>

                                <!-- Logout -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-responsive-nav-link>
                                </form>
                            @endauth
                        </div>
                    </div>
                    @livewire('cart')
                </div>
            </div>
        </div>
    </nav>



    <!-- Contenido principal -->
    <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
        {{ $slot }}
    </div>

    <!-- Scripts -->
    @livewireScripts
</body>

</html>
