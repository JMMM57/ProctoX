<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'AulaData') }}</title>

        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <header class="navbar">
            <div class="logo">🚀 {{ config('app.name', 'AulaData') }}</div>
            <nav>
                <a href="{{ route('dashboard') }}">Inicio</a>
                <a href="{{ route('salones.index') }}" style="margin-left: 1.5rem;">Salones</a>
                
                @auth
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            Salir ({{ Auth::user()->name }})
                        </a>
                    </form>
                @endauth
            </nav>
        </header>

        <main class="container">
            {{ $slot }}
        </main>

        <footer>
            <p>&copy; {{ date('Y') }} - Gestión de Aulas | Versión: {{ env('APP_VERSION', '1.0.0') }}</p>
        </footer>

        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
