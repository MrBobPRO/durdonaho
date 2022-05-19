<div class="modal register-modal" id="register-modal" style="background-image: url({{ asset('img/main/modal-bg.PNG') }})">
    {{-- Modal Dialog start --}}
    <div class="modal-dialog register-modal-dialog">
        
        {{-- Modal Header start --}}
        <div class="modal-dialog__header">
            <div class="modal-dialog__header-inner">
                <h2 class="modal-dialog__title">Зарегестрироваться</h2>
                <button class="modal-dissmiss" data-action="hide-modal" data-target-id="register-modal">X</button>
            </div>
        </div>  {{-- Modal Header end --}}

        {{-- Modal Body start --}}
        <div class="modal-dialog__body">
            <div class="modal-dialog__body-inner">
                <form class="form modal-form" action="/register" method="POST" id="register-form">
                    @csrf

                    <div class="form-group modal-form-group">
                        <input class="input input--light modal-input" type="text" placeholder="Имя" name="name" autocomplete="off" required>
                    </div>
                    
                    <div class="form-group modal-form-group">
                        <input class="input input--light modal-input" type="email" placeholder="Электронная почта" autocomplete="off" name="email" required>
                    </div>

                    <div class="form-group modal-form-group">
                        <input class="input input--light modal-input" type="password" placeholder="Пароль" name="password" minlength="5" required autocomplete="new-password">
                    </div>

                    <div class="form-group modal-form-group">
                        <input class="input input--light modal-input" type="password" placeholder="Подтвердите пароль" name="password_confirmation" minlength="5" required>
                    </div>
                    
                    <div class="form-group modal-form-group">
                        <label class="label modal-label">Ваш пол</label>
                        
                        <div class="radio-group modal-radio-group">
                            <div class="radio-container">
                                <input class="radio modal-radio" id="radio-male" type="radio" name="gender" value="male" checked>
                                <div class="radio-replacer"></div>
                                <label class="radio-label unselectable" for="radio-male">Мужчина</label>
                            </div>

                            <div class="radio-container">
                                <input class="radio modal-radio" id="radio-female" type="radio" name="gender" value="female">
                                <div class="radio-replacer"></div>
                                <label class="radio-label unselectable" for="radio-female">Женщина</label>
                            </div>
                        </div>
                    </div>

                    <ul class="modal-form-errors"></ul>

                    <button class="button button--main modal-submit">
                        <span class="material-icons modal-submit-icon">sensor_door</span> Зарегестрироваться
                    </button>

                    <div class="terms modal-terms">
                        <div class="checkbox-container">
                            <input class="checkbox terms__checkbox" type="checkbox" name="terms" value="accepted" id="register-terms-checkbox" required>
                            <div class="checkbox-replacer"></div>
                        </div>

                        <div class="terms__divider">
                            <label class="terms__label unselectable" for="register-terms-checkbox">Я принимаю</label>
                            <a class="terms__link" href="{{ route('privacy-policy') }}" target="_blank">пользовательское соглашение</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>  {{-- Modal Body end --}}

    </div>  {{-- Modal Dialog end --}}
</div>