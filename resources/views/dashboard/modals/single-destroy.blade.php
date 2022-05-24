{{-- itemId = 0 used for index pages --}}
<div class="modal fade" id="destroy-single-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Удалить</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route($destroyRoute) }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" value="{{ $itemId}} " name="id" id="destroy-single-modal-input" />
                {{-- Relations have model name --}}
                @isset($model)
                    <input type="hidden" value="{{ $model }}" name="model">
                @endisset

                <div class="modal-body">
                    Вы уверены что хотите удалить ?
                </div>

                <div class="modal-footer">
                    <button type="button" class="button button--secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="button button--danger">Удалить</button>
                </div>
            </form>
        </div>
    </div>
</div>