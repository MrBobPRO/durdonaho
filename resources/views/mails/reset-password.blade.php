<h2>Сброс пароля</h2>
<p>По вашей почте был запрошен сброс пароля на сайте <a href="{{ route('home') }}" target="_blank">{{ route('home') }}</a></p>
<p>Вы можете сбросить пароль своего аккаунта по нижней ссылке:</p>
<a href="{{ route('password.reset.show', $token) }}" target="_blank">{{ route('password.reset.show', $token) }}</a>
<p><br>Если вы не запрашивали сброс пароля, то никаких дальнейших действий не требуется</p>