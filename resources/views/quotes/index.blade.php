@extends('layouts.app')
@section('main')

<aside class="aside">
    <div class="aside-text theme-styled-block">
        <h1 class="aside-text__title main-title">Иқтибосҳо ва афоризмҳо</h1>

        <div class="aside-text__body">
            <p>Беҳтарин иқтибосҳо ва афоризмҳои инсонҳо ва мутафаккирони бузург.</p>
        </div>
    </div>

    <x-aside-categories />
    <x-aside-quote />

</aside>

<div class="main__content quotes-page-content">
    <section class="latest-quotes carousel-section theme-styled-block">
        <h1 class="carousel-section__title main-title">Иқтибосҳои ахир
            <span class="carousel-section__counter">1 из 5</span>
        </h1>
        {{-- <x-carousel-quotes :quotes="$latestQuotes" /> --}}
    </section>

</div>

@endsection