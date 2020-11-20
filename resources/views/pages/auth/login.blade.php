@extends('layouts.app')
@section('content')
<main class="login">
    <form action="{{ route('login') }}" method="POST">
        <h2>Авторизация</h2>
        @if($errors->any())
        <p class="alert red mb-30">{{ $errors->first() }}</p>
        @endif
        {{ csrf_field() }}
        <input type="text" name="name" placeholder="Логин" value="{{ old('name') }}">
        <input type="password" name="password" placeholder="Пароль">
        <button type="submit" class="button lg">Войти</button>
    </form>
</main>
@endsection