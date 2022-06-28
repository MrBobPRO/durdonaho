@extends('layouts.app')
@section('main')

<div class="main__content password-reset-page">
    <div class="theme-styled-block password-reset-page__inner">
        @if(isset($token))
            <form class="form main-form password-reset-form" action="{{ route('password.reset.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="main-form__block">
                    <h1 class="main-title main-title--indented">Обновить пароль</h1>

                    <div class="form-group">
                        <input class="input" type="email" readonly value="{{ $email }}" placeholder="Почтаи электронӣ" required>
                    </div>

                    <div class="form-group">
                        @error('password') <span class="form-error-message">Рамзи номувофиқ !</span> @enderror
                        <input class="input @error('password') input--error  @enderror" type="password" name="password" minlength="5" autocomplete="new-password" placeholder="Новый пароль" required>
                    </div>

                    <div class="form-group">
                        <input class="input @error('password') input--error  @enderror" type="password" name="password_confirmation" minlength="5" placeholder="Подтвердите новый пароль" required >
                    </div>
                </div>

                <button class="button button--main password-reset-submit"><span class="material-icons">lock_reset</span> Обновить пароль</button>
            </form>
        @else
            <span class="password-reset__error-text">Неверный запрос, или срок вашего запроса уже истёк!</span>
        @endif
    </div>
</div>

@endsection
