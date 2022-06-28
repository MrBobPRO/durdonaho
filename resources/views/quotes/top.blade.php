@extends('layouts.app')
@section('main')

@section('title', 'Андарзҳои беҳтарин')

<aside class="aside">
    <div class="aside-text theme-styled-block">
        <h1 class="aside-text__title main-title">Андарзҳои беҳтарин</h1>

        <div class="aside-text__body">
            <p>Здесь короткое описание того, что здесь 10-20 лучших цитат всех времен и народов по мнению наших пользователей.</p>
        </div>
    </div>

    <x-aside-categories />
    <x-aside-popularity />
</aside>

<div class="main__content top-quotes-page-content">
    <section class="quotes-section" id="quotes-section">
        <div class="quotes-list" id="quotes-list">
            <x-list-inner-quotes :quotes="$quotes" card-class="card_with_small_image"/>
        </div>
    </section>
</div>

@endsection