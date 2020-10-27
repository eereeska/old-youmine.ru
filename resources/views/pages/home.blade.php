<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YouMine</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="home">
        <div class="logo"></div>
        <h1 class="title">YouMine ❘ Приватный сервер Minecraft</h1>
        <nav class="links">
            <a href="https://vk.com/youmine" target="_blank">ВКонтакте</a>
            <a href="https://vk.com/youmine?w=page-199013527_54995323" target="_blank">Соглашение</a>
            <a href="https://vk.com/youmine?w=page-199013527_54995327" target="_blank">Правила</a>
            <a href="{{ route('profile') }}">Профиль</a>
        </nav>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>