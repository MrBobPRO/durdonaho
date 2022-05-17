@extends('layouts.app')
@section('main')

@if(request()->route()->getName() == 'users.current.quotes')
    @section('title', 'Цитаты опубликованные мною')
@endif

<div class="main__content users-quotes-page-content">
    <x-filter-categories :request="$request" :user-id="$userId" class="categories-filter--full_width"/>

    <section class="quotes-section" id="quotes-section">
        <div class="quotes-list" id="main-list">
            <x-list-inner-quotes :quotes="$quotes" card-class="card_with_large_image card--full_width"/>
        </div>
    </section>
</div>

@endsection