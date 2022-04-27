@extends('layouts.app')
@section('main')

<div class="main__content users-show-page-content">
    <section class="users-card-section">
        <x-card-users :user="$user" class="theme-styled-block card_with_medium_image card--full_width users-card" />
    </section>
</div>

@endsection