@extends('layouts.app')
@section('main')

@section('title', 'Сиёсати маҳрамият')

<div class="main__content privacy-policy-page-content">
    <section class="privacy-policy-section">
        <div class="privacy-policy">{!! $text !!}</div>
    </section>
</div>

@endsection