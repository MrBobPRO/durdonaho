<aside class="aside" id="aside">
    <span class="material-icons aside-toggler-button" id="aside-toggler-button">chevron_left</span>

    <img class="aside__avatar" src="{{ asset('img/dashboard/admin.jpg') }}">

    <nav class="aside__nav">
        <ul class="aside__menu">
            <li>
                <a href="{{route('home')}}" target="_blank">
                    <span class="material-icons">home</span> Перейти на сайт
                </a>
            </li>

            <li>
                <a class="@if( strpos($route, 'quotes') !== false || $route == 'dashboard.index') active @endif" href="{{route('dashboard.index')}}">
                    <span class="material-icons">article</span> Цитаты
                </a>
            </li>

            @if( strpos($route, 'quotes') !== false || $route == 'dashboard.index') 
                <ul class="aside__submenu">
                    <li>
                        <a href="{{ route('quotes.dashboard.unapproved') }}" @if($route == 'quotes.dashboard.unapproved') class="active" @endif>На рассмотрении</a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.index') }}" @if($route == 'sources.dashboard.index') class="active" @endif>Источники</a>
                    </li>
                </ul>
            @endif

            <li>
                <a class="@if( strpos($route, 'authors') !== false ) active @endif" href="{{route('authors.dashboard.index')}}">
                    <span class="material-icons">account_circle</span> Авторы
                </a>
            </li>

            <li>
                <a class="@if( strpos($route, 'categories') !== false ) active @endif" href="{{route('authors.dashboard.index')}}">
                    <span class="material-icons">category</span> Категории
                </a>
            </li>

            <li>
                <a class="@if( strpos($route, 'options') !== false ) active @endif" href="{{route('authors.dashboard.index')}}">
                    <span class="material-icons">notes</span> Тексты
                </a>
            </li>

            <li>
                <a class="@if( strpos($route, 'users') !== false ) active @endif" href="{{route('authors.dashboard.index')}}">
                    <span class="material-icons">people</span> Пользователи
                </a>
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"><span class="material-icons">logout</span> Выйти</button>
                </form>
            </li>
        </ul>
    </nav>
</aside>