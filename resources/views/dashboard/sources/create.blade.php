@extends('dashboard.layouts.app')
@section("main")

<form action="{{ route($modelShortcut . '.store') }}" method="POST" class="form" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label class="required">Заголовок</label>
        <input type="text" class="form-input" name="title" value="{{ old('title') }}" required />
    </div>

    <div class="form__actions">
        <button class="button button--success" type="submit">
            <span class="material-icons">done_all</span> Добавить
        </button>
    </div>

</form>

@endsection