<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page_title ?? 'Панель управления' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha256-t9UJPrESBeG2ojKTIcFLPGF7nHi2vEc7f5A2KpH/UBU=" crossorigin="anonymous"></script>
    {{-- <script src="{{ asset('js/admin.js') }}"></script> --}}
</head>
<body>
    <nav class="content-nav flex jcc gap-40 text-center">
        <a href="{{ route('profile') }}">На сайт</a>
        <a href="{{ route('admin-stats') }}" class="{{ (request()->is('admin')) ? 'active' : '' }}">Статистика</a>
        <a href="{{ route('admin-users-unconfirmed') }}" class="{{ (request()->is('admin/users/unconfirmed')) ? 'active' : '' }}">Заявки</a>
    </nav>
    @yield('content')
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>