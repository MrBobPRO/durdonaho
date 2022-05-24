@extends('dashboard.layouts.app')
@section("main")

<form action="{{ route('products.update') }}" method="POST" class="form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $product->id }}">

    <div class="form-group">
        <label class="required">Название</label>
        <input class="form-input" name="name" type="text" value="{{ $product->name }}" required>
    </div>

    <div class="form-group">
        <label class="required">Короткое описание</label>
        <textarea class="simditor-wysiwyg" name="description" required>{{ $product->description }}</textarea>
    </div>

    <div class="form-group">
        <label class="required">Полное описание (Показания к применению / Способ применения итд)</label>
        <textarea class="simditor-wysiwyg" name="body" required>{{ $product->body }}</textarea>
    </div>

    <div class="form-group">
        <label>Изображение. Необходимый размер: квадратное изображение</label>
        <input class="form-input" name="image" type="file" accept=".png, .jpg, .jpeg"
        data-action="show-image-from-local" data-target="local-image">

        <img class="form-image" src="{{ asset('img/products/' . $product->image)}}" id="local-image">
    </div>

    <div class="form-group">
        <label>Инструкция. Формат : pdf. <a href="{{ asset('instructions/' . $product->instruction) }}" target="_blank">Текущий файл: {{ $product->instruction }}</a></label>
        <input class="form-input" name="instruction" accept=".pdf" type="file">
    </div>

    <div class="form-group">
        <label>Ссылка на приобретение препарата. Полная ссылка включая https или http</label>
        <input class="form-input" name="obtain_link" type="text" placeholder="https://salomat.tj/" value="{{ $product->obtain_link }}">
    </div>

    <div class="form-group">
        <label class="required">Рецептурность</label>
        <select class="selectize-singular" name="prescription_id" required>
            @foreach ($prescriptions as $prescription)
                <option value="{{ $prescription->id }}" {{ $product->prescription_id == $prescription->id ? 'selected' : '' }}>{{ $prescription->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="required">Форма</label>
        <select class="selectize-singular" name="form_id" required>
            @foreach ($forms as $form)
                <option value="{{ $form->id }}" {{ $product->form_id == $form->id ? 'selected' : '' }}>{{ $form->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="required">Воздействие</label>
        <select class="selectize-singular" name="impact_id" required>
            @foreach ($impacts as $impact)
                <option value="{{ $impact->id }}" {{ $product->impact_id == $impact->id ? 'selected' : '' }}>{{ $impact->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="required">Действующее вещество</label>
        <select class="selectize-multiple" name="substances[]" multiple="multiple" required>
            @foreach ($substances as $substance)
                <option value="{{ $substance->id }}"
                    @foreach ($product->substances as $prodSub)
                        @if($prodSub->id == $substance->id) selected @endif
                    @endforeach
                    >{{ $substance->title }}
                </option>
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

@include('dashboard.modals.single-destroy', ['destroyRoute' => 'products.destroy', 'itemId' => $product->id ])

@endsection