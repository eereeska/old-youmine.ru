@extends('layouts.app')
@section('content')
<div class="content profile">
    @if (!$u->name)
    <div class="box noname p-40 mb-40">
        <h2 class="mb-20">Никнейм не установлен</h2>
        <p>Войдите на сервер, чтобы<br>установить его</p>
    </div>
    @else
    <div class="box banner flex aic p-40">
        <div id="skin-upload" class="avatar" style="background-image: url({{ url('avatars/' . $u->skin_id . '.png') }})"></div>
        <input id="skin-upload-input" type="file" name="skin" accept="image/x-png" style="display: none;" hidden />
        <div class="info">
            <h2 class="mb-10">{{ $u->name ?? 'Ноунейм' }}</h2>
            <p>{{ $u->admin ? 'Администратор' : ($u->moderator ? 'Модератор' : 'Игрок') }}</p>
        </div>
    </div>
    @endif
    <div class="grid cols-2 gap-40 stats mt-40">
        <div class="box subscription p-40">
            @if (($u->admin or $u->moderator) or is_null($u->sub_expire_at))
            <h3>Пожизненная</h3>
            <p>Подписка</p>
            @else
            <div class="visible">
                @if ($u->admin or $u->moderator)
                <h3>Пожизненная</h3>
                @elseif (now()->lt($u->sub_expire_at))
                <h3>До {{ $u->sub_expire_at->format('d-m-Y') }}</h3>
                @else
                <h3>Отсутствует</h3>
                @endif
                <p>Подписка</p>
            </div>
            <div class="hidden">
                <div class="choice cols-2 text-center">
                    <div class="left">
                        @if (now()->gte($u->sub_expire_at))
                        <a href="{{ route('profile-buy-sub-month') }}" data-action="request" data-request-callback="alert">Купить на месяц<br><span class="coins">200 коинов</span></a>
                        @else
                        <a href="{{ route('profile-buy-sub-month') }}" data-action="request" data-request-callback="alert">Продлить на месяц<br><span class="coins">200 коинов</span></a>
                        @endif
                    </div>
                    <div class="right">
                        <a href="{{ route('profile-buy-sub-lifetime') }}" data-action="request" data-request-callback="alert">Купить навсегда<br><span class="coins">1000 коинов</span></a>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="box balance p-40">
            <div class="visible">
                <h3>{{ $u->balance }} {{ trans_choice('коин|коина|коинов', $u->balance, [], 'ru') }}</h3>
                <p>Баланс</p>
            </div>
            <div class="hidden centered d-column pl-40 pr-40">
                <input id="deposit-input" name="balance-input" type="number" class="underline" placeholder="Введите сумму в рублях и нажмите Enter" data-redirect="{{ route('deposit') }}">
                <span id="deposit-coins-sum" class="coins mt-20">1 рубль = 2 коина</span>
            </div>
        </div>
    </div>
    <div class="box mt-40">
        <div class="toggle{{ $serverAccessActive ? ' active' : ''}}" data-action="toggle" data-toggle-type="request" data-toggle-target="serverAccess">
            <h3>Доступ на сервер</h3>
            <p>Сбрасывается при смене IP</p>
        </div>
    </div>
</div>
@endsection