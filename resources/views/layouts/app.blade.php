<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-DRGP4M8CF1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-DRGP4M8CF1');
    </script>                           
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>{{ $title ?? 'YouMine' }}</title>
	<meta name="description" content="Недооценённый сервер Minecraft">
	<meta name="keywords" content="minecraft,server,online,miltiplayer,vanilla,free,сервер,майнкрафт,онлайн,ванильный">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@0.21.0/dist/axios.min.js" integrity="sha256-OPn1YfcEh9W2pwF1iSS+yDk099tYj+plSrCS6Esa9NA=" crossorigin="anonymous"></script>
    <script>
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';
    </script>
</head>
<body>
    @yield('content')
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>