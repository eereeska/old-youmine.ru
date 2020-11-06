<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page_title ?? 'YouMine' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/axios@0.21.0/dist/axios.min.js" integrity="sha256-OPn1YfcEh9W2pwF1iSS+yDk099tYj+plSrCS6Esa9NA=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';
    </script>
</head>
<body>
    <nav class="content-nav flex jcc gap-40 text-center">
        <a href="{{ route('home') }}" class="{{ (request()->is('/')) ? 'active' : '' }}">Главная</a>
        <a href="{{ route('profile') }}" class="{{ (request()->is('profile')) ? 'active' : '' }}">Профиль</a>
        
        @if ($u->admin)
        <a href="{{ route('admin-stats') }}">Админка</a>
        @endif

        <a href="{{ route('logout') }}">Выйти</a>
    </nav>
    @if ($errors->any())
    <div class="alert red">{{ $errors->first() }}</div>
    @endif
    @yield('content')
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>