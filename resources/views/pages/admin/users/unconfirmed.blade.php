@extends('layouts.admin')
@section('content')
<div class="content admin-stats">
    <input id="search-query" type="text" placeholder="Введите ID, ссылку, имя или фамилию пользователя и нажмите Enter" autocomplete="off" class="mb-40" data-action="search-users-unconfirmed">
    <table id="search-table">
        <thead>
            <tr>
                <th class="text-left">ВКонтакте</th>
                <th class="text-center">Дата регистрации</th>
                <th class="text-right">Действия</th>
            </tr>
        </thead>
        <tbody id="search-result"></tbody>
    </table>
</div>
@endsection