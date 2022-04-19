@extends('layouts.app')
@section('main')

<div class="main__content password-reset-page">
    <div class="theme-styled-block password-reset-block">
        @if(isset($token))
            <form class="password-reset-form" action="{{ route('password.reset.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label class="password-reset__label">Электронная почта</label>
                    <input class="password-reset__input" type="email" readonly value="{{ $email }}" required>
                </div>

                <div class="form-group">
                    <label class="password-reset__label">Новый пароль*</label>
                    <input class="password-reset__input @error('password') password-reset__input--error  @enderror" type="password" name="password" minlength="5" autocomplete="new-password" required @error('password') placeholder="Пароли не совпадают!" @enderror>
                </div>

                <div class="form-group">
                    <label class="password-reset__label">Подтвердите новый пароль*</label>
                    <input class="password-reset__input @error('password') password-reset__input--error  @enderror" type="password" name="password_confirmation" minlength="5" required @error('password') placeholder="Пароли не совпадают!" @enderror>
                </div>

                <button class="button button--main password-reset-submit"><span class="material-icons">lock_reset</span> Обновить пароль</button>
            </form>
        @else
            <p class="password-reset__error-text">Неверный запрос, или срок вашего запроса уже истёк!</p>
        @endif
    </div>
</div>

@endsection
