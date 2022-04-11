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
    <x-aside-popularity />
</aside>

<div class="main__content quotes-page-content">
    <x-filter-categories title="Ҳама иқтибосҳо" />

    <section class="quotes-section" id="quotes-section">
        <div class="quotes-list" id="quotes-list">
            <x-quotes-list-inner :quotes="$quotes"/>
        </div>
    </section>
</div>

@endsection