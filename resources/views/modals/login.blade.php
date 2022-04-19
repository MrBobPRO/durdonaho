<div class="modal login-modal" id="login-modal" style="background-image: url({{ asset('img/main/modal-bg.PNG') }})">
    {{-- Modal Dialog start --}}
    <div class="modal-dialog login-modal-dialog">
        
        {{-- Modal Header start --}}
        <div class="modal-dialog__header">
            <div class="modal-dialog__header-inner">
                <h2 class="modal-dialog__title">Войти</h2>
                <button class="modal-dissmiss" data-action="hide-modal" data-target-id="login-modal">X</button>
            </div>
        </div>  {{-- Modal Header end --}}

        {{-- Modal Body start --}}
        <div class="modal-dialog__body">
            <div class="modal-dialog__body-inner">
                <form class="form modal-form" action="/login" method="POST" id="login-form">
                    <div class="form-group modal-form-group">
                        <input class="input modal-input" type="email" placeholder="Электронная почта" name="email" autofocus required>
                    </div>

                    <div class="form-group modal-form-group">
                        <input class="input modal-input" type="password" placeholder="Пароль" name="password" autocomplete="current-password" required>
                    </div>

                    <ul class="modal-form-errors"></ul>

                    <button class="button button--main modal-submit">
                        <span class="material-icons modal-submit-icon">sensor_door</span> Войти
                    </button>
                </form>

                <div class="login-modal__additional-actions">
                    <button class="login-modal__forgot-password" href="#" id="login-modal-forgot-password">Забыли пароль?</button>
                    <button class="button--transparent login-modal__register" id="login-modal-register-button">Зарегистрируйтесь</button>
                </div>
            </div>  {{-- Modal Body Inner end --}}
        </div>  {{-- Modal Body end --}}

    </div>  {{-- Modal Dialog end --}}
</div>