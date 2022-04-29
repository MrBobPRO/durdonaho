@extends('layouts.app')
@section('main')

<aside class="aside">
    <x-aside-categories />
    <x-aside-popularity />
</aside>

<div class="main__content authors-page-content">
    <x-filter-categories :request="$request"/>

    <section class="authors-section" id="authors-section">
        <div class="authors-list" id="main-list">
            <x-list-inner-authors :authors="$authors"/>
        </div>
    </section>
</div>

@endsection