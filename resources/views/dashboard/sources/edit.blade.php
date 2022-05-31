@extends('dashboard.layouts.app')
@section("main")

<form action="{{ route($modelShortcut . '.update') }}" method="POST" class="form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $item->id }}">

    <div class="form-group">
        <label class="required">Заголовок</label>
        <input type="text" class="form-input" name="title" value="{{ old('title') ?? $item->title }}" required />
    </div>

    <div class="form__actions">
        <button class="button button--success" type="submit">
            <span class="material-icons">done_all</span> Обновить
        </button>

        <button class="button button--danger" type="button" data-bs-toggle="modal" data-bs-target="#destroy-single-item-modal">
            <span class="material-icons">remove_circle</span> Удалить
        </button>
    </div>

</form>

@include('dashboard.modals.single-item-destroy', ['destroyItemId' => $item->id ])

@endsection