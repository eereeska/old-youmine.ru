@extends('layouts.app')
@section('content')
<div class="content profile">
    <div class="box banner">
        {{-- <div class="avatar"></div> --}}
        <div class="info">
            <h2 class="name">{{ $u->name }}</h2>
            <span class="group">{{ $u->admin ? 'Администратор' : ($u->moderator ? 'Модератор' : 'Игрок') }}</span>
            <a href="{{ route('logout') }}" class="logout">Выйти</a>
        </div>
    </div>
    <div class="box-group cols-2 stats">
        <div class="box subscription">
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
                        <a href="#">Купить на месяц<br><span class="coins">300 коинов</span></a>
                        @else
                        <a href="#">Продлить на месяц<br><span class="coins">300 коинов</span></a>
                        @endif
                    </div>
                    <div class="right">
                        <a href="#">Купить навсегда<br><span class="coins">1000 коинов</span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="box balance">
            <div class="visible">
                <h3>{{ $u->balance }} {{ trans_choice('коин|коина|коинов', $u->balance, [], 'ru') }}</h3>
                <p>Баланс</p>
            </div>
            <div class="hidden centered d-column pl-40 pr-40">
                <input name="balance-input" type="number" class="underline" placeholder="Введите сумму в рублях и нажмите Enter">
                <p class="mt-20">Поступит на баланс: <span id="balance-input-callback" class="coins">0 коинов</span></p>
                <script>
                    document.querySelector('input[name="balance-input"]').addEventListener('input', function(e) {
                        var val = parseInt(e.target.value);
                        var callback = document.getElementById('balance-input-callback');

                        if (!val) {
                            callback.textContent = 'Неверная сумма';
                        } else {
                            if (val < 10) {
                                callback.textContent = 'Не меньше 10';
                            } else if (val > 100000) {
                                callback.textContent = 'Не больше 100.000';
                            } else {
                                callback.textContent = val * 2 + ' коинов';
                            }
                        }
                    });
                </script>
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