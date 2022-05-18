@extends('layouts.app')
@section('main')

<div class="main__content unverified-quotes-page-content">
    <section class="unverified-quotes-section">
        <div class="unverified-quotes-about">
            <div class="unverified-quotes-about__inner">
                <h1 class="main-title unverified-quotes-about__title">Цитаты на рассмотрении</h1>
                <p class="unverified-quotes-about__text">Здесь будут отображатся цитаты добавлении вами, которые нахдятся на рассмотрении у администратора!</p>
            </div>
        </div>
    
        <div class="unverified-quotes-list">
                @foreach ($quotes as $quote)
                <div class="unverified-quotes-card">
                    <div class="unverified-quotes-card__inner">
                        <p class="unverified-quotes-card__author">Автор цитаты: {{ $quote->author->name }}</p>
                        <p class="unverified-quotes-card__body">{{ $quote->body }}</p>
                        <a class="button button--secondary unverified-quotes-card__edit" href="{{ route('users.quotes.edit', $quote->id) }}">Редактировать</a>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </section>
</div>

@endsection