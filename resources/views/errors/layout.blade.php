<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>@yield('title')</title>
	<meta name="description" content="Недооценённый сервер Minecraft">
	<meta name="keywords" content="minecraft,server,online,miltiplayer,vanilla,free,сервер,майнкрафт,онлайн,ванильный">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <main class="error">
        <div class="content">
            <h1 class="code">@yield('code')</h1>
            <h2 class="message">@yield('message')</h2>
            <a href="{{ route('home') }}" class="button md mt-60">На главную</a>
        </div>
    </main>
</body>
</html>