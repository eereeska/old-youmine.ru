@extends('layouts.admin')
@section('content')
<div class="content">
    <a href="https://vk.com/id{{ $user->vk_id }}" target="_blank"><h3>#{{ $user->id }} | {{ $user->vk_first_name }} {{ $user->vk_last_name }} | {{ $user->name }}</h3></a>

    @if($errors->any())
    <p class="alert red mb-40">{{ $errors->first() }}</p>
    @endif
    
    <form id="edit-form" action="{{ route('admin-users-edit', ['id' => $user->id])}}" method="POST">
        <input type="text" name="id" value="{{ $user->id }}" hidden>
        <input type="text" name="original" value="{{ json_encode($user) }}" hidden>
        {{ csrf_field() }}

        <p>Никнейм</p>
        <input type="text" name="name" placeholder="{{ $user->name }}" value="{{ $user->name }}" autocomplete="off" class="v1 underline mb-20">

        <p>Баланс</p>
        <input type="number" name="balance" placeholder="{{ $user->balance }}" value="{{ $user->balance }}" autocomplete="off" class="v1 underline mb-20">

        <p>Администратор</p>
        <select name="admin" id="admin" class="mb-20">
            <option value="yes" @if ($user->admin) selected @endif>Да</option>
            <option value="no" @if (!$user->admin) selected @endif>Нет</option>
        </select>

        <p>Модератор</p>
        <select name="moderator" id="moderator" class="mb-20">
            <option value="yes" @if ($user->moderator) selected @endif>Да</option>
            <option value="no" @if (!$user->moderator) selected @endif>Нет</option>
        </select>

        <p>Подписка</p>
        <select name="sub_expire_at" id="lifetime_sub" class="mb-20">
            @if (is_null($user->sub_expire_at))
            <option value="null" selected>Бессрочная</option>
            <option value="{{ now() }}">Отсутствует</option>
            @elseif ($user->sub_expire_at->gt(now()))
            <option value="{{ $user->sub_expire_at }}" selected>До {{ $user->sub_expire_at->format('H:i:s d.m.Y') }}</option>
            <option value="null">Бессрочная</option>
            <option value="{{ now() }}">Отсутствует</option>
            @else
            <option value="null">Бессрочная</option>
            <option value="{{ now() }}" selected>Отсутствует</option>
            @endif
        </select>

        <div class="button green" onclick="$('#edit-form').trigger('submit')">Сохранить</div>
    </form>
</div>
@endsection