<h2>Подтверждение электронной почты</h2>
<p>По вашей почте был зарегистрирован аккаунт на сайте <a href="{{ route('home') }}" target="_blank">{{ route('home') }}</a></p>
<p>Вы можете подтвердить свою электронную почту по нижней ссылке:</p>
<a href="{{ route('verification.verify', $token) }}" target="_blank">{{ route('verification.verify', $token) }}</a>
<p><br>Если вы не создавали учетную запись, никаких дальнейших действий не требуется</p>