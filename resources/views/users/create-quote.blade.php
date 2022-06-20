@extends('layouts.app')
@section('main')

<div class="main__content quotes-create-page-content">
    <section class="theme-styled-block quotes-create-section">
        <div class="quotes-create-section__inner">

            <form class="form main-form store-quotes-form" action="{{ route('users.quotes.store') }}" method="POST" id="store-quotes-form" enctype="multipart/form-data">
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
                <div class="main-form__block">
                    <h1 class="main-title main-title--indented">Добавить цитату</h1>
    
                    <div class="form-group selectize-container">
                        <select class="selectize-singular-taggable main-form__selectize-singular" name="source" placeholder="Выберите источника цитаты">
                            <option></option>
                            @foreach ($sources as $source)
                                <option value="{{ $source->title }}">{{ $source->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group selectize-container">
                        <select class="selectize-singular-taggable main-form__selectize-singular" name="author" placeholder="Выберите автора цитаты" required>
                            <option></option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->name }}">{{ $author->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group selectize-container">
                        <select class="selectize-multiple-taggable main-form__selectize-multiple" multiple name="categories[]" placeholder="Выберите категории цитаты или добавьте новый" required>
                            <option></option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->title }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>  {{-- /end Selects --}}

                {{-- Body --}}
                <div class="main-form__block">
                    <h1 class="main-title">Текст цитаты</h1>

                    <div class="form-group">
                        <textarea class="textarea textrarea_resize_on_input" name="body">{{ old('body') }}</textarea>
                    </div>
                </div>  {{-- /end Body --}}

                <button class="button button--main main-form__submit">Опубликовать цитату</button>

                <x-terms-of-use class="accept-terms_with_dark_checkbox" id="create-quote-terms" />
            </form> 

        </div>
    </section>
</div>

@endsection