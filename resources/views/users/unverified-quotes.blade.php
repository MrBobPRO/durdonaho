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
            
                                @if($quote->author)
                                    <a class="card__title" href="{{ route('authors.show', $quote->author->slug) }}">
                                        <span class="card__title-span">Автор цитаты:</span> {{ $quote->author->name }}
                                    </a>
                                @else
                                    <a class="card__title">
                                        <span class="card__title-span">Автор цитаты:</span> {{ $quote->manuals()->where('key', 'author')->first()->value }}
                                    </a>
                                @endif
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

                                <button class="report-bug-button" data-action="show-report-bug-modal" data-quote-id="{{ $quote->id }}">
                                    <span class="material-icons-outlined report-bug-button__icon">error_outline</span>
                                </button>
                            </div>
                        </div> {{-- Card Footer end --}}
                    </div>  {{-- Card Inner end --}}
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

@endsection