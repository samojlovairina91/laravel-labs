<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Мой сайт')</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f4f4f4;
            color: #222;
        }
        header {
            background: #2c3e50;
            padding: 15px 30px;
        }
        header nav a {
            color: #fff;
            text-decoration: none;
            margin-right: 20px;
            font-size: 16px;
        }
        header nav a:hover { text-decoration: underline; }
        header nav a.active { font-weight: bold; text-decoration: underline; }
        main {
            flex: 1;
            padding: 30px;
            max-width: 900px;
            margin: 0 auto;
            width: 100%;
        }
        footer {
            background: #2c3e50;
            color: #fff;
            padding: 15px 30px;
            text-align: center;
            font-size: 14px;
        }
        h1 { margin-bottom: 20px; }
        p { margin-bottom: 10px; line-height: 1.5; }
        ul { padding-left: 20px; }
        li { margin-bottom: 8px; }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="{{ route('home') }}"            class="{{ request()->routeIs('home') ? 'active' : '' }}">Главная</a>
            <a href="{{ route('about') }}"           class="{{ request()->routeIs('about') ? 'active' : '' }}">О нас</a>
            <a href="{{ route('contacts') }}"        class="{{ request()->routeIs('contacts') ? 'active' : '' }}">Контакты</a>
            <a href="{{ route('galery') }}"          class="{{ request()->routeIs('galery') ? 'active' : '' }}">Галерея</a>
            <a href="{{ route('signin') }}"          class="{{ request()->routeIs('signin') ? 'active' : '' }}">Регистрация</a>
            <a href="{{ route('articles.index') }}"  class="{{ request()->routeIs('articles.*') ? 'active' : '' }}">Новости (БД)</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        Самойлова Ирина Алексеевна, 251-3210
    </footer>
</body>
</html>