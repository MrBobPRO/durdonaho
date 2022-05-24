@extends('dashboard.layouts.app')
@section("main")

<form action="{{ route('slides.update') }}" method="POST" class="form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $slide->id }}">

    <div class="form-group">
        <label class="required">Заголовок</label>
        <input class="form-input" name="title" type="text" value="{{ $slide->title }}" required>
    </div>

    <div class="form-group">
        <label class="required">Текст</label>
        <textarea class="form-textarea" name="body" required>{{ $slide->body }}</textarea>
    </div>

    <div class="form-group">
        <label class="required">Приоритет</label>
        <input class="form-input" name="priority" type="number" value="{{ $slide->priority }}" required>
    </div>

    <div class="form-group">
        <label class="required">Текст кнопки</label>
        <input class="form-input" name="button" type="text" value="{{ $slide->button }}" required>
    </div>

    <div class="form-group">
        <label class="required">Полная ссылка кнопки включая https или http</label>
        <input class="form-input" name="link" type="text" value="{{ $slide->link }}" required>
    </div>


    <div class="form-group">
        <label>Изображение. Все изображение слайдера должны иметь одинаковые размеры! Рек/размер (1300x272 px)</label>
        <input class="form-input" name="image" type="file" accept=".png, .jpg, .jpeg"
        data-action="show-image-from-local" data-target="local-image">

        <img class="form-image" src="{{ asset('img/slides/' . $slide->image)}}" id="local-image">
    </div>

    <div class="form__actions">
        <button class="button button--success" type="submit">
            <span class="material-icons">done_all</span> Обновить
        </button>

        <button class="button button--danger" type="button" data-bs-toggle="modal" data-bs-target="#destroy-single-modal">
            <span class="material-icons">remove_circle</span> Удалить
        </button>
    </div>

</form>

@include('dashboard.modals.single-destroy', ['destroyRoute' => 'slides.destroy', 'itemId' => $slide->id ])

@endsection