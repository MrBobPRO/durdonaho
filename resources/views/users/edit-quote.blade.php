@extends('layouts.app')
@section('main')

<div class="main__content quotes-edit-page-content">
    <section class="theme-styled-block quotes-edit-section">
        <div class="quotes-edit-section__inner">

            <form class="form main-form quotes-edit-form" action="{{ route('users.quotes.update') }}" method="POST" id="update-quotes-form" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id" value="{{ $quote->id }}">

                @if(session('status') == 'success')
                    <div class="alert alert--success">
                        <span class="material-icons-outlined alert__icon">error</span>
                        Цитата успешно обновлена. Она будет опубликована после успешной проверки администратором!
                    </div>

                @elseif(session('status') == 'similar-quote-error')
                    <div class="alert alert--warning">
                        <span class="material-icons-outlined alert__icon">error</span>
                        Похожая цитата уже существует. Пожалуйста, измените цитату и попробуйте заново! <br><br>
                        <b>Похожая цитата: </b> {{ session('similarQuote') }}
                    </div>

                @elseif(!$quote->approved)
                    <div class="alert alert--success">
                        <span class="material-icons-outlined alert__icon">error</span>
                        Цитата будет опубликована после успешной проверки администратором!
                    </div>
                @endif

                {{-- Selects --}}
                <div class="main-form__block">
                    <h1 class="main-title main-title--indented">Редактировать цитату</h1>
    
                    <div class="form-group selectize-container">
                        <select class="selectize-singular-taggable main-form__selectize-singular" name="source" placeholder="Выберите источник цитаты (Необъязательно поле)">
                            <option></option>
                            @foreach ($sources as $source)
                                <option value="{{ $source->title }}" @if($quote->source_id == $source->id) selected @endif>{{ $source->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group selectize-container">
                        <select class="selectize-singular-taggable main-form__selectize-singular" name="author" placeholder="Выберите автора цитаты" required>
                            <option></option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->name }}" @if($quote->author_id == $author->id) selected @endif>{{ $author->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group selectize-container">
                        <select class="selectize-multiple-taggable main-form__selectize-multiple" multiple name="categories[]" placeholder="Выберите категории цитаты или добавьте новый" required>
                            <option></option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->title }}" 
                                    @foreach ($quote->categories as $quoteCategory)
                                        @selected($quoteCategory->id == $category->id)
                                    @endforeach
                                    >{{ $category->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>  {{-- /end Selects --}}

                {{-- Body --}}
                <div class="main-form__block">
                    <h1 class="main-title">Текст цитаты</h1>

                    <div class="form-group">
                        <textarea class="textarea textrarea_resize_on_input" name="body">{{ old('body') != '' ? old('body') : $quote->body }}</textarea>
                    </div>
                </div>  {{-- /end Body --}}

                <button class="button button--main main-form__submit">Обновить цитату</button>

                <x-terms-of-use class="accept-terms_with_dark_checkbox" id="update-quote-terms" />                
            </form> 

        </div>
    </section>
</div>

@endsection