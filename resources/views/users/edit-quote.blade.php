@extends('layouts.app')
@section('main')

<div class="main__content quotes-edit-page-content">
    <section class="theme-styled-block quotes-edit-section">
        <div class="quotes-edit-section__inner">

            <form class="main-form quotes-edit-form" action="{{ route('users.quotes.update') }}" method="POST" id="update-quotes-form" enctype="multipart/form-data">
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
                <div class="main-form__divider">
                    <h1 class="main-title main-form__title main-form__title--indented">Редактировать цитату</h1>
    
                    <div class="main-form__group main-form__group-select-container">
                        <select class="selectize-singular-taggable main-form__selectize-singular" name="source" placeholder="Выберите источник цитаты (Необъязательно поле)">
                            <option></option>
                            @if($manualSource)
                                <option value="{{ $manualSource->value }}" selected>{{ $manualSource->value }}</option>
                            @endif

                            @foreach ($sources as $source)
                                <option value="{{ $source->title }}" @if($quote->source_id == $source->id) selected @endif>{{ $source->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="main-form__group main-form__group-select-container">
                        <select class="selectize-singular-taggable main-form__selectize-singular" name="author" placeholder="Выберите автора цитаты" required>
                            <option></option>
                            @if($manualAuthor)
                                <option value="{{ $manualAuthor->value }}" selected>{{ $manualAuthor->value }}</option>
                            @endif

                            @foreach ($authors as $author)
                                <option value="{{ $author->name }}" @if($quote->author_id == $author->id) selected @endif>{{ $author->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="main-form__group main-form__group-select-container">
                        <select class="selectize-multiple-taggable main-form__selectize-multiple" multiple name="categories[]" placeholder="Выберите категории цитаты или добавьте новый" required>
                            <option></option>
                            @if($manualCategories)
                                @foreach ($manualCategories as $manualCategory)
                                    <option value="{{ $manualCategory }}" selected>{{ $manualCategory }}</option>
                                @endforeach
                            @endif

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
                <div class="main-form__divider">
                    <h1 class="main-title main-form__title">Текст цитаты</h1>

                    <div class="main-form__group main-form__group--columned main-form__group--borderless">
                        <textarea class="textarea main-form__textarea textrarea_resize_on_input" name="body">{{ old('body') != '' ? old('body') : $quote->body }}</textarea>
                    </div>
                </div>  {{-- /end Body --}}

                <button class="button button--main main-form__submit">Обновить цитату</button>

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