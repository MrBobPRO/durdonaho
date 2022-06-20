@extends('layouts.app')
@section('main')

<div class="main__content unverified-quotes-page-content">
    <section class="unverified-quotes-section">
        <div class="theme-styled-block unverified-quotes-about">
            <div class="unverified-quotes-about__inner">
                <h1 class="main-title unverified-quotes-about__title">Цитаты на рассмотрении</h1>
                <p class="unverified-quotes-about__text">Здесь будут отображатся цитаты добавлении вами, которые нахдятся на рассмотрении у администратора!</p>
            </div>
        </div>
    
        <div class="unverified-quotes-list">
            @foreach ($quotes as $quote)
                <div class="card theme-styled-block card--full_width unverified-quotes-card">
                    <div class="card__inner">
                
                        {{-- Card Header start --}}
                        <div class="card__header">
                            <div class="card__header-text">
                                <a class="card__edit-btn button button--transparent" href="{{ route('users.quotes.edit', $quote->id) }}">
                                    <span class="material-icons-outlined card__edit-btn-icon">edit</span> Редактировать
                                </a>
            
                                <h3 class="card__title">
                                    @switch($quote->source->key)
                                        @case(App\Models\Source::AUTHORS_QUOTE_KEY)
                                            <a class="card__title-link" href="{{ route('authors.show', $quote->author->slug) }}">
                                                {{ $quote->author->name }}
                                            </a>
                                            @break
                
                                        @case(App\Models\Source::OWN_QUOTE_KEY)
                                            <a class="card__title-link" href="{{ route('users.show', $quote->publisher->slug) }}">
                                                {{ $quote->publisher->name }}
                                            </a>
                                            @break
                
                                        @case(App\Models\Source::UNKNOWN_AUTHOR_KEY)
                                            Неизвестный автор
                                            @break
                
                                        @case(App\Models\Source::FROM_BOOK_KEY)
                                            {{ $quote->bookSource->title }}
                                            @break
                
                                        @case(App\Models\Source::FROM_MOVIE_KEY)
                                            {{ $quote->movieSource->title }}
                                            @break
                
                                        @case(App\Models\Source::FROM_SONG_KEY)
                                            {{ $quote->songSource->title }}
                                            @break
                
                                        @case(App\Models\Source::FROM_PROVERB_KEY)
                                            Пословица/поговорка
                                            @break
                
                                        @case(App\Models\Source::FROM_PARABLE_KEY)
                                            Притча
                                            @break
                                    @endswitch
                                </h3>
                            </div>
                        </div> {{-- Card Header end --}}
                
                        {{-- Card Body start --}}
                        <div class="card__body">
                            <div class="card__body-text-container">
                                <p class="card__body-text">{{ $quote->body }}</p>
                            </div>
                        </div> {{-- Card Body end --}}
                
                        {{-- Card Footer start --}}
                        <div class="card__footer">
                            <div class="card__publication">
                                @php
                                    $formatted = Carbon\Carbon::create($quote->updated_at)->locale("ru");
                                @endphp
                    
                                <p class="card__publication-text">Дата последней изменении цитаты:</p>
                                <p class="card__publication-date">{{ $formatted->isoFormat("DD.mm.YYYY HH::mm") }}</p>
                            </div>
                            
                            <button class="report-bug-button" data-action="show-report-bug-modal" data-quote-id="{{ $quote->id }}">
                                <span class="material-icons-outlined report-bug-button__icon">error_outline</span>
                            </button>
                        </div> {{-- Card Footer end --}}
                    </div>  {{-- Card Inner end --}}
                </div>
            @endforeach
        </div>
    </section>
</div>

@endsection