@extends('dashboard.layouts.app')
@section("main")

<form action="{{ route('researches.store') }}" method="POST" class="form" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label class="required">Заголовок</label>
        <textarea class="form-textarea" name="title" rows="5" required>{{ old("title") }}</textarea>
    </div>

    <div class="form-group">
        <label class="required">Подзаголовок</label>
        <textarea class="form-textarea" name="subtitle" rows="5" required>{{ old("subtitle") }}</textarea>
    </div>

    <div class="form-group">
        <label class="required">Текст</label>
        <textarea class="simditor-wysiwyg" name="body" required>{{ old("body") }}</textarea>
    </div>

    <div class="form-group">
        <label class="required">Продукт</label>
        <select class="selectize-singular" name="product_id">
            @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="required">Изображение</label>
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