<div class="modal register-modal" style="background-image: url({{ asset('img/main/modal-bg.PNG') }})">
    <div class="modal-dialog register-modal-dialog">
        <div class="modal-dialog__header">
            <div class="modal-dialog__header-inner">
                <h2 class="modal-dialog__title">Зарегестрироваться</h2>
                <button class="modal-dissmiss" data-action="dismiss-modal">X</button>
            </div>
        </div>

        <div class="modal-dialog__body">
            <div class="modal-dialog__body-inner">
                <form class="form modal-form" action="#">
                    <div class="form-group modal-form-group">
                        <input class="input modal-input" type="text" placeholder="Имя" name="name">
                    </div>
                    
                    <div class="form-group modal-form-group">
                        <input class="input modal-input" type="text" placeholder="Электронная почта" name="email">
                    </div>

                    <div class="form-group modal-form-group">
                        <input class="input modal-input" type="text" placeholder="Пароль" name="password">
                    </div>

                    <div class="form-group modal-form-group">
                        <input class="input modal-input" type="text" placeholder="Подтвердите пароль" name="password_confirmation">
                    </div>
                    
                    <div class="form-group modal-form-group">
                        <label class="label modal-label">Ваш пол</label>
                        <div class="radio-group modal-radio-group">
                            <div class="radio-container">
                                <input class="radio modal-radio" id="radio-male" type="radio" name="gender" value="male">
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

                    <button class="button button--main modal-submit">
                        <span class="material-icons modal-submit-icon">sensor_door</span> Зарегестрироваться
                    </button>

                    <div class="terms modal-terms">
                        <div class="checkbox-container">
                            <input class="checkbox terms__checkbox" type="checkbox" name="terms" value="accepted" id="register-terms-checkbox">
                            <div class="checkbox-replacer"></div>
                        </div>

                        <div class="terms__divider">
                            <label class="terms__label unselectable" for="register-terms-checkbox">Я принимаю</label>
                            <a class="terms__link" href="#" target="_blank">пользовательское соглашение</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>