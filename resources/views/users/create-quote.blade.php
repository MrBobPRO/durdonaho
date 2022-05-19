@extends('layouts.app')
@section('main')

<div class="main__content quotes-create-page-content">
    <section class="theme-styled-block quotes-create-section">
        <div class="quotes-create-section__inner">

            <form class="main-form quotes-store-form" action="{{ route('users.quotes.store') }}" method="POST" id="store-quotes-form" enctype="multipart/form-data">
                @csrf

                @if(session('status') == 'success')
                    <div class="alert alert--success">
                        <span class="material-icons-outlined alert__icon">done_all</span>
                        Цитата успешно добавлена. Она будет опубликована после успешной проверки администратором!
                    </div>
                @endif

                @if(session('status') == 'similar-quote-error')
                    <div class="alert alert--warning">
                        <span class="material-icons-outlined alert__icon">error</span>
                        Похожая цитата уже существует. Пожалуйста, измените цитату и попробуйте заново! <br><br>
                        <b>Похожая цитата: </b> {{ session('similarQuote') }}
                    </div>
                @endif

                {{-- Selects --}}
                <div class="main-form__divider">
                    <h1 class="main-title main-form__title main-form__title--indented">Добавить цитату</h1>
    
                    <div class="main-form__group main-form__group-select-container">
                        <select class="selectize-singular-taggable main-form__selectize-singular" name="source" placeholder="Выберите источник цитаты (Необъязательно поле)">
                            <option></option>
                            @foreach ($sources as $source)
                                <option value="{{ $source->title }}">{{ $source->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="main-form__group main-form__group-select-container">
                        <select class="selectize-singular-taggable main-form__selectize-singular" name="author" placeholder="Выберите автора цитаты" required>
                            <option></option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->name }}">{{ $author->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="main-form__group main-form__group-select-container">
                        <select class="selectize-multiple-taggable main-form__selectize-multiple" multiple name="categories[]" placeholder="Выберите категории цитаты или добавьте новый" required>
                            <option></option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->title }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>  {{-- /end Selects --}}

                {{-- Body --}}
                <div class="main-form__divider">
                    <h1 class="main-title main-form__title">Текст цитаты</h1>

                    <div class="main-form__group main-form__group--columned main-form__group--borderless">
                        <textarea class="textarea main-form__textarea textrarea_resize_on_input" name="body">{{ old('body') }}</textarea>
                    </div>
                </div>  {{-- /end Body --}}

                <button class="button button--main main-form__submit">Опубликовать цитату</button>

                {{-- Terms --}}
                <div class="terms main-form-terms">
                    <div class="checkbox-container">
                        <input class="checkbox terms__checkbox" type="checkbox" name="terms" value="accepted" id="main-form-terms-checkbox" required checked>
                        <div class="checkbox-replacer"></div>
                    </div>

                    <div class="terms__divider">
                        <label class="terms__label unselectable" for="main-form-terms-checkbox">Я принимаю</label>
                        <a class="terms__link" href="{{ route('privacy-policy') }}" target="_blank">пользовательское соглашение</a>
                    </div>
                </div>  {{-- /end Terms --}}
            </form> 

        </div>
    </section>
</div>

@endsection