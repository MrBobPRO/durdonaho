@extends('layouts.app')
@section('main')

@section('title', 'Сиёсати маҳрамият')

<div class="main__content privacy-policy-page-content">
    <section class="privacy-policy-section">
        <div class="theme-styled-block privacy-policy">
            <h1 class="main-title">Сиёсати маҳрамият</h1>
            <div class="privacy-policy__text">{!! $text !!}</div>
        </div>
    </section>
</div>

@endsection