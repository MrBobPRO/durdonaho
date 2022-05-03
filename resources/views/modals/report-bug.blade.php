<div class="modal report-bug-modal" id="report-bug-modal" style="background-image: url({{ asset('img/main/modal-bg.PNG') }})">
    {{-- Modal Dialog start --}}
    <div class="modal-dialog report-bug-modal-dialog">
        
        {{-- Modal Header start --}}
        <div class="modal-dialog__header">
            <div class="modal-dialog__header-inner">
                <h2 class="modal-dialog__title">Сообщить об ошибке</h2>
                <button class="modal-dissmiss" data-action="hide-modal" data-target-id="report-bug-modal">X</button>
            </div>
        </div>  {{-- Modal Header end --}}

        {{-- Modal Body start --}}
        <div class="modal-dialog__body">
            <div class="modal-dialog__body-inner">
                <form class="form modal-form" action="{{ route('report-bug') }}" method="POST" id="report-bug-form">
                    <p class="report-bug-modal__text">Здесь написать текст о том, какие жалобы можно отправлять. <br>Отправлять жалобы можно после регистрации</p>

                    @csrf
                    <input type="hidden" name="quote_id">
                    <input type="hidden" name="author_id">

                    <div class="form-group modal-form-group">
                        <label class="label modal-label" for="report-message">Введите текст ошибки или жалобу</label>
                        <textarea class="textarea modal-textarea" name="message" id="report-message" required rows="4"></textarea>
                    </div>

                    <button class="button button--main modal-submit report-bug-modal__submit">Отправить</button>

                    <div class="terms modal-terms">
                        <div class="checkbox-container">
                            <input class="checkbox terms__checkbox" type="checkbox" name="terms" value="accepted" id="report-bug-terms-checkbox" required>
                            <div class="checkbox-replacer"></div>
                        </div>

                        <div class="terms__divider">
                            <label class="terms__label unselectable" for="report-bug-terms-checkbox">Я принимаю</label>
                            <a class="terms__link" href="#" target="_blank">пользовательское соглашение</a>
                        </div>
                    </div>
                </form>
            </div>  {{-- Modal Body Inner end --}}
        </div>  {{-- Modal Body end --}}

    </div>  {{-- Modal Dialog end --}}
</div>