@extends('dashboard.layouts.app')
@section("main")

<form action="{{ route('slides.store') }}" method="POST" class="form" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label class="required">Заголовок</label>
        <input class="form-input" name="title" type="text" value="{{ old('title') }}" required>
    </div>

    <div class="form-group">
        <label class="required">Текст</label>
        <textarea class="form-textarea" name="body" required>{{ old("body") }}</textarea>
    </div>

    <div class="form-group">
        <label class="required">Приоритет</label>
        <input class="form-input" name="priority" type="number" value="{{ old('priority') }}" required>
    </div>

    <div class="form-group">
        <label class="required">Текст кнопки</label>
        <input class="form-input" name="button" type="text" value="{{ old('button') }}" required>
    </div>

    <div class="form-group">
        <label class="required">Полная ссылка кнопки включая https или http</label>
        <input class="form-input" name="link" type="text" value="{{ old('link') }}" required>
    </div>

    <div class="form-group">
        <label class="required">Изображение. Все изображение слайдера должны иметь одинаковые размеры! Рек/размер (1300x272 px)</label>
        <input class="form-input" name="image" type="file" accept=".png, .jpg, .jpeg" required
        data-action="show-image-from-local" data-target="local-image">

        <img class="form-image" src="{{ asset('img/dashboard/default-image.png') }}" id="local-image">
    </div>

    <div class="form__actions">
        <button class="button button--success" type="submit">
            <span class="material-icons">done_all</span> Добавить
        </button>
    </div>

</form>

@endsection