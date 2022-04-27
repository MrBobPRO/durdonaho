@extends('layouts.app')
@section('main')

<div class="main__content users-show-page-content">
    <section class="users-card-section">
        <div class="theme-styled-block users-card-section__inner">
            <h1 class="main-title users-card-section__title">Профиль пользователя</h1>

            <x-card-users :user="$user" />
        </div>
    </section>
</div>

@endsection