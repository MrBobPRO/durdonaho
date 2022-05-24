@extends('dashboard.layouts.app')
@section("main")

<form action="{{ route('products.store') }}" method="POST" class="form" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label class="required">Название</label>
        <input class="form-input" name="name" type="text" value="{{ old('name') }}" required>
    </div>

    <div class="form-group">
        <label class="required">Короткое описание</label>
        <textarea class="simditor-wysiwyg" name="description" required>{{ old("description") }}</textarea>
    </div>

    <div class="form-group">
        <label class="required">Полное описание (Показания к применению / Способ применения итд)</label>
        <textarea class="simditor-wysiwyg" name="body" required>{{ old("body") }}</textarea>
    </div>

    <div class="form-group">
        <label class="required">Изображение. Необходимый размер: квадратное изображение</label>
        <input class="form-input" name="image" type="file" accept=".png, .jpg, .jpeg" required
        data-action="show-image-from-local" data-target="local-image">

        <img class="form-image" src="{{ asset('img/dashboard/default-image.png') }}" id="local-image">
    </div>

    <div class="form-group">
        <label class="required">Инструкция. Формат : pdf</label>
        <input class="form-input" name="instruction" accept=".pdf" type="file" value="{{ old('instruction') }}" required>
    </div>

    <div class="form-group">
        <label>Ссылка на приобретение препарата. Полная ссылка включая https или http</label>
        <input class="form-input" name="obtain_link" type="text" placeholder="https://salomat.tj/" value="{{ old('obtain_link') }}">
    </div>

    <div class="form-group">
        <label class="required">Рецептурность</label>
        <select class="selectize-singular" name="prescription_id">
            @foreach ($prescriptions as $prescription)
                <option value="{{ $prescription->id }}">{{ $prescription->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="required">Форма</label>
        <select class="selectize-singular" name="form_id">
            @foreach ($forms as $form)
                <option value="{{ $form->id }}">{{ $form->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="required">Воздействие</label>
        <select class="selectize-singular" name="impact_id">
            @foreach ($impacts as $impact)
                <option value="{{ $impact->id }}">{{ $impact->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="required">Действующее вещество</label>
        <select class="selectize-multiple" name="substances[]" multiple="multiple" required>
            @foreach ($substances as $substance)
                <option value="{{ $substance->id }}">{{ $substance->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="form__actions">
        <button class="button button--success" type="submit">
            <span class="material-icons">done_all</span> Добавить
        </button>
    </div>

</form>

@endsection