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
                    <span class="material-icons">medication</span> Цитаты
                </a>
            </li>

            <li>
                <a class="@if( strpos($route, 'authors') !== false ) active @endif" href="{{route('authors.dashboard.index')}}">
                    <span class="material-icons">article</span> Авторы
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