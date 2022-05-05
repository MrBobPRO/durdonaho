<div class="modal forgot-password-modal" id="forgot-password-modal" style="background-image: url({{ asset('img/main/modal-bg.PNG') }})">
    {{-- Modal Dialog start --}}
    <div class="modal-dialog forgot-password-modal-dialog">
        
        {{-- Modal Header start --}}
        <div class="modal-dialog__header">
            <div class="modal-dialog__header-inner">
                <h2 class="modal-dialog__title">Сбросить пароль</h2>
                <button class="modal-dissmiss" data-action="hide-modal" data-target-id="forgot-password-modal">X</button>
            </div>
        </div>  {{-- Modal Header end --}}

        {{-- Modal Body start --}}
        <div class="modal-dialog__body">
            <div class="modal-dialog__body-inner">
                <form class="form modal-form" action="/forgot-password" method="POST" id="forgot-password-form">
                    <div class="form-group modal-form-group">
                        <label class="forgot-password-modal-text">Забыли Ваш пароль? Просто сообщите нам свой адрес электронной почты, и мы отправим вам ссылку для сброса пароля, которая позволит вам задать новый пароль.</label>

                        <input class="input input--light modal-input" type="email" placeholder="Электронная почта" name="email" autofocus required>
                    </div>

                    <ul class="modal-form-errors"></ul>

                    <button class="button button--main modal-submit">
                        <span class="material-icons modal-submit-icon">lock_reset</span> Запросить ссылку для смены пароля
                    </button>
                </form>
            </div>  {{-- Modal Body Inner end --}}
        </div>  {{-- Modal Body end --}}

    </div>  {{-- Modal Dialog end --}}
</div>