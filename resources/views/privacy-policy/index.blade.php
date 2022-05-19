@extends('layouts.app')
@section('main')

@section('title', 'Сиёсати маҳрамият')

<div class="main__content privacy-policy-page-content">
    <section class="privacy-policy-section">
        <div class="theme-styled-block privacy-policy">
            <h1 class="main-title privacy-policy__title">Сиёсати маҳрамият</h1>
            <div class="privacy-policy__text">{!! App\Models\Option::where('key', 'privacy-policy')->first()->value !!}</div>
        </div>
    </section>
</div>

@endsection