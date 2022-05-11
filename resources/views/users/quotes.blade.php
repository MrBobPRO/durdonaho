@extends('layouts.app')
@section('main')

@section('title', 'Редактировать цитаты')

<div class="main__content users-quotes-page-content">
    <x-filter-categories :request="$request" :user-id="auth()->user()->id" class="categories-filter--full_width"/>

    <section class="quotes-section" id="quotes-section">
        <div class="quotes-list" id="main-list">
            <x-list-inner-quotes :quotes="$quotes" card-class="card_with_large_image card--full_width"/>
        </div>
    </section>
</div>

@endsection