@extends('layouts.app')
@section('content')
<main class="profile">
	<div class="preview box flex fw-w aic jcsb g-30">
		<div class="flex aic">
			<div id="upload-skin" class="avatar" style="background-image: url({{ asset('avatars/' . $u->skin_id . '.png') }})"></div>
			<input type="file" name="skin" id="upload-skin-input" accept="image/png" style="display: none" hidden>
			<div class="info">
				<h3>{{ $u->name }}</h3>
				<p>Игрок</p>
			</div>
		</div>
		<div class="flex">
			<a href="{{ route('logout') }}" class="button md">Выйти</a>
		</div>
	</div>
	<div class="balance box flex fw-w aic jcsb g-30">
		<div class="status">
			<h4 class="value">{{ $u->balance }} {{ trans_choice('кредит|кредита|кредитов', $u->balance, [], 'ru') }}</h4>
			<p>Баланс</p>
		</div>
		<button id="deposit" class="button md" data-redirect="{{ route('deposit') }}">Пополнить</button>
	</div>
	<div class="password-change box">
		<form action="{{ route('change-password') }}" method="POST">
			<h5>Смена пароля</h5>
			@if ($message = session()->get('change-password'))
			<p class="alert green mb-30">{{ $message }}</p>
			@endif
			@error('change-password')
				<p class="alert red mb-30">{{ $message }}</p>
			@enderror
			{{ csrf_field() }}
			<input type="password" name="current" placeholder="Текущий пароль">
			<input type="password" name="new" placeholder="Новый пароль">
			<button type="submit" class="button lg mt-30">Сменить</button>
		</form>
	</div>
</main>
@endsection