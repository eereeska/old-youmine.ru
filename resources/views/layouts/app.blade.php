<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page_title ?? 'YouMine' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <nav class="content-nav text-center">
        <a href="{{ route('home') }}" class="{{ (request()->is('/')) ? 'active' : '' }}">Главная</a>
        <a href="{{ route('profile') }}" class="{{ (request()->is('profile')) ? 'active' : '' }}">Профиль</a>
        
        @if ($u->admin)
        <a href="{{ route('admin-stats') }}" class="{{ (request()->is('admin*')) ? 'active' : '' }}"">Админка</a>
        @endif
    </nav>
    @yield('content')
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>