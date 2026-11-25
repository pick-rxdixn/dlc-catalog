<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'DLC Catalog')</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <header class="header">
        <div class="container navigation">

            <a href="/" class="logo">DLC Catalog</a>

            <nav>
                <a href="/">Каталог</a>

                @auth
                    <a href="/library">Моя библиотека</a>

                    <span>{{ Auth::user()->name }}</span>

                    <button id="logout-button">
                        Выйти
                    </button>
                @else
                    <a href="/login">Войти</a>
                    <a href="/register">Регистрация</a>
                @endauth
            </nav>

        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            DLC Catalog
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>

    @yield('scripts')

</body>
</html>