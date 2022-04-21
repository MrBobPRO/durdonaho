@extends('layouts.app')
@section('main')

<aside class="aside">
    <x-aside-categories />
    <x-aside-popularity />
</aside>

<div class="main__content quotes-page-content">
    <x-filter-categories :request="$request"/>

    <section class="quotes-section" id="quotes-section">
        <div class="quotes-list" id="quotes-list">
            <x-list-inner-quotes :quotes="$quotes"/>
        </div>
    </section>
</div>

@endsection