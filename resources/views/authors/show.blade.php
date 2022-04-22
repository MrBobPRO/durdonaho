@extends('layouts.app')
@section('main')

<aside class="aside">
    <x-aside-categories />
    <x-aside-popularity />
</aside>

<div class="main__content authors-show-page-content">
    <x-card-author :author="$author" class="theme-styled-block card_with_medium_image authors-show-main-card"/>
    <x-filter-categories :request="$request" :authorId="$author->id"/>

    <section class="quotes-section" id="quotes-section">
        <div class="quotes-list" id="quotes-list">
            <x-list-inner-quotes :quotes="$quotes" />
        </div>
    </section>
</div>

@endsection