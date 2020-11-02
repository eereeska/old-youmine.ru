<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page_title ?? 'Панель управления' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/axios@0.21.0/dist/axios.min.js" integrity="sha256-OPn1YfcEh9W2pwF1iSS+yDk099tYj+plSrCS6Esa9NA=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha256-t9UJPrESBeG2ojKTIcFLPGF7nHi2vEc7f5A2KpH/UBU=" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="content-nav flex jcc gap-40 text-center">
        <a href="{{ route('profile') }}">На сайт</a>
        <a href="{{ route('admin-stats') }}" class="{{ (request()->fullUrl() == route('admin-stats')) ? 'active' : '' }}">Статистика</a>
        <a href="{{ route('admin-users') }}" class="{{ (request()->fullUrl() == route('admin-users')) ? 'active' : '' }}">Пользователи</a>
    </nav>
    @yield('content')
</body>
</html>