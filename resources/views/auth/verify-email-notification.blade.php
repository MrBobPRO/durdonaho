@extends('layouts.app')
@section('main')

<div class="main__content email-verification-page">
    <div class="theme-styled-block email-verification-block">
        <p class="email-verification-text">Спасибо за регистрацию! Прежде чем начать, не могли бы вы подтвердить свой адрес электронной почты, перейдя по ссылке, которую мы отправили вам по электронной почте? Если вы не получили письмо, мы с радостью вышлем вам другое.</p>

        <div class="email-verification-actions">
            <form action="#">
                @csrf
                <button class="button button--main email-verification-resend">Переотправить письмо подтверждения</button>
            </form>
    
            <form action="/logout" method="POST">
                @csrf
                <button class="button email-verification-logout">Выйти из аккаунта</button>
            </form>
        </div>
    </div>
</div>

@endsection
