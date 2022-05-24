<header class="header" id="header">
    {{-- Title start --}}
    <h1 class="header__title">
        {{-- first level --}}
        @if(strpos($route, 'quotes') !== false  || $route == 'dashboard.index') Цитаты 
        @elseif(strpos($route, 'authors') !== false) Авторы
        @endif

        {{-- First levels items count --}}
        @if( strpos($route, 'index') ) ({{ count($items) }}) @endif

        {{-- second level for CREATE --}}
        @if(strpos($route, 'create') ) / Добавить

        {{-- second level for EDIT --}}
        @elseif($route == 'quotes.edit') / {{ $quote->id }}
        @elseif($route == 'authors.edit') / {{ $author->name }}
        @endif
    </h1>  {{-- Title end --}}

    {{-- Actions start --}}
    <div class="header__actions">
        {{-- Create Buttons --}}
        @switch($route)
            @case('dashboard.index')
                <a href="{{route('quotes.create')}}">
                    <span class="material-icons">add</span> Добавить
                </a>
            @break

            @case('authors.dashboard.index')
                <a href="{{route('authors.create')}}">
                    <span class="material-icons">add</span> Добавить
                </a>
            @break
        @endswitch

        {{-- Destroy Multiple Items actions for index routes --}}
        @switch($route)
            @case('dashboard.index')
            @case('authors.dashboard.index')
                <button id="header-select-all-button">
                    <span class="material-icons">done_all</span> Отметить все
                </button>

                <button data-bs-toggle="modal" data-bs-target="#destroy-multiple-items-form">
                    <span class="material-icons">clear</span> Удалить отмеченные
                </button>
            @break
        @endswitch
    </div>  {{-- Actions end --}}
</header>