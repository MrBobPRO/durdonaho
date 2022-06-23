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

        <div class="quotes-list" id="main-list">
            <x-list-inner-quotes :quotes="$quotes" card-class="card_with_small_image card--full_width" show-edit-button="1" />
        </div>
    </section>
</div>

@endsection