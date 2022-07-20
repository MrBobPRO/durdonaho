@extends('layouts.app')
@section('main')

<aside class="aside">
    <div class="aside-text theme-styled-block">
        <h1 class="aside-text__title main-title">Роҷеъ ба сомона</h1>

        <div class="aside-text__body aside-text__body--center">{!! App\Models\Option::where('key', 'welcome-text')->first()->value !!}</div>
    </div>

    <x-aside-categories />
    <x-aside-popular-categories />

</aside>

<div class="main__content home-page-content">
    <section class="latest-quotes carousel-section theme-styled-block">
        <h1 class="carousel-section__title main-title">Иқтибосҳои ахир
            <span class="carousel-section__counter"><span class="carousel-section__counter-active">1</span> из {{ $latestQuotes->count() }}</span>
        </h1>
        <x-carousel-quotes :quotes="$latestQuotes" />
    </section>

    <section class="popular-quotes carousel-section theme-styled-block">
        <h1 class="carousel-section__title main-title">Иқтибосҳои маъмул
            <span class="carousel-section__counter"><span class="carousel-section__counter-active">1</span> из {{ $popularQuotes->count() }}</span>
        </h1>
        <x-carousel-quotes :quotes="$popularQuotes" />
    </section>

    <section class="popular-authors carousel-section theme-styled-block">
        <h1 class="carousel-section__title main-title">Муаллифони машхур
            <span class="carousel-section__counter"><span class="carousel-section__counter-active">1</span> из {{ $popularAuthors->count() }}</span>
        </h1>
        <x-carousel-authors :authors="$popularAuthors" />
    </section>

</div>

@endsection