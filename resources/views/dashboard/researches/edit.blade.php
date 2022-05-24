@extends('dashboard.layouts.app')
@section("main")

<form action="{{ route('researches.update') }}" method="POST" class="form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $research->id }}">

    <div class="form-group">
        <label class="required">Заголовок</label>
        <textarea class="form-textarea" name="title" rows="5" required>{{ $research->title }}</textarea>
    </div>

    <div class="form-group">
        <label class="required">Подзаголовок</label>
        <textarea class="form-textarea" name="subtitle" rows="5" required>{{ $research->subtitle }}</textarea>
    </div>

    <div class="form-group">
        <label class="required">Текст</label>
        <textarea class="simditor-wysiwyg" name="body" required>{{ $research->body }}</textarea>
    </div>

    <div class="form-group">
        <label>Изображение</label>
        <input class="form-input" name="image" type="file" accept=".png, .jpg, .jpeg"
        data-action="show-image-from-local" data-target="local-image">

        <img class="form-image" src="{{ asset('img/researches/' . $research->image)}}" id="local-image">
    </div>

    <div class="form-group">
        <label class="required">Продукт</label>
        <select class="selectize-singular" name="product_id" required>
            @foreach ($products as $product)
                <option value="{{ $product->id }}" {{ $research->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
            @endforeach
        </select>
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

@include('dashboard.modals.single-destroy', ['destroyRoute' => 'researches.destroy', 'itemId' => $research->id ])

@endsection