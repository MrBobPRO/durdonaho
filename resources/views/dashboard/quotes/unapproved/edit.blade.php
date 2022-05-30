@extends('dashboard.layouts.app')
@section("main")

<form action="{{ route('quotes.approve') }}" method="POST" class="form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $item->id }}">

    <div class="form-group">
        <label class="required">Текст</label>
        <textarea class="form-textarea" name="body" rows="7" required>{{ old('body') ?? $item->body }}</textarea>
    </div>

    <div class="form-group">
        @php
            $manual = App\Models\Manual::where('quote_id', $item->id)->where('key', 'author')->first();
            // Skip manual if author was already created after quote create
            $manualAuthorAlreadyCreated = $manual ? App\Models\Author::where('name', $manual->value)->first() : false;
        @endphp

        <label class="required">Автор @if($manual && !$manualAuthorAlreadyCreated). Пользователь добавил нового автора: {{ $manual->value }} @endif</label>
        <select class="selectize-singular" name="author_id" placeholder="Выберите автора" required>
            <option></option>
            @foreach ($authors as $author)
                <option value="{{ $author->id }}" @selected($author->id == $item->author_id)
                    @if($manualAuthorAlreadyCreated)
                        @selected($author->id == $manualAuthorAlreadyCreated->id)
                    @endif
                    >{{ $author->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Источник</label>
        <select class="selectize-singular" name="source_id" placeholder="Выберите источник">
            <option></option>
            @foreach ($sources as $source)
                <option value="{{ $source->id }}" @selected($source->id == $item->source_id)>{{ $source->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="required">Издатель</label>
        <select class="selectize-singular" name="user_id" required>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected($user->id == $item->user_id)>{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="required">Категории</label>
        <select class="selectize-multiple" name="categories[]" multiple="multiple" required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    @foreach ($item->categories as $itemCat)
                        @selected($category->id == $itemCat->id)
                    @endforeach
                    >{{ $category->title }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="required">Добавить в популярные цитаты?</label>
        <select class="selectize-singular" name="popular" required>
            <option value="0" @selected(!$item->popular)>Нет</option>
            <option value="1" @selected($item->popular)>Да</option>
        </select>
    </div>

    <div class="form__actions">
        <button class="button button--success" type="submit">
            <span class="material-icons">done_all</span> Опубликовать
        </button>
    </div>

</form>

@endsection