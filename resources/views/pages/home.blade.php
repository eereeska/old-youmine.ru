@extends('layouts.app')
@section('content')
<main class="home">
    <div class="logo"></div>
    <h1>Скромный сервер Minecraft</h1>
    <nav class="links">
        <a href="https://vk.com/youmine" target="_blank">ВКонтакте</a>
        <a href="https://vk.com/youmine?w=page-199013527_54995323" target="_blank">Соглашение</a>
        <a href="https://vk.com/youmine?w=page-199013527_54995327" target="_blank">Правила</a>
        <a href="{{ route('profile') }}">Профиль</a>
    </nav>
</main>
@endsection