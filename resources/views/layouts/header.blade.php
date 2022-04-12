<header class="header">
    <div class="header__inner main-container">
        <div class="header-top">
            <a class="logo" href="{{ route('home') }}">
                <img class="logo__image" src="{{ asset('img/main/logo.svg') }}" alt="Дурдонаҳо лого">
            </a>

            <div class="header-top__actions">
                @auth
                    <span class="material-icons">person</span>
                    <button class="button button--main">Добавить цитату</button>
                @endauth
                
                @guest
                    <button class="header-top__register button button--transparent">Зарегистрироваться</button>

                    <button class="button button--main header-top__login">
                        <span class="material-icons">person</span> ВОЙТИ
                    </button>
                @endguest
            </div>
        </div>
    
        <div class="header__bottom">
            <nav class="header-nav">
                <ul class="header-nav__ul">
                    <li class="header-nav__item">
                        <a class="header-nav__link header-nav__link--home @if($route == "home") active @endif" href="{{ route('home') }}"><span class="material-icons unselectable">home</span></a>
                    </li>
        
                    <li class="header-nav__item">
                        <a class="header-nav__link @if($route == "quotes.index") active @endif" href="{{ route('quotes.index') }}">Иқтибосҳо</a>
                    </li>
        
                    <li class="header-nav__item">
                        <a class="header-nav__link @if($route == "authors.index" || $route == "authors.show") active @endif" href="{{ route('authors.index') }}">Муаллифон</a>
                    </li>

                    <li class="header-nav__item">
                        <div class="dropdown">
                            <button class="header-nav__link dropdown__button @if($route == "quotes.individual" || $route == 'authors.individual') active @endif" >Самиздат</button>

                            <div class="dropdown__content">
                                <div class="dropdown__background"></div>
                                <ul class="dropdown__menu">
                                    <li><a class="dropdown__item" href="{{ route('authors.individual') }}">Муаллифон</a></li>
                                    <li><a class="dropdown__item" href="{{ route('quotes.individual') }}">Иқтибосҳо</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>

                    <li class="header-nav__item">
                        <a class="header-nav__link @if($route == "quotes.top") active @endif" href="{{ route('quotes.top') }}">Лучшие цитаты</a>
                    </li>
                </ul>
            </nav>

            <form action="#" class="search header__search">
                <input class="search__input" type="text" placeholder="Ҷустуҷӯ">
                <span class="material-icons search__icon">search</span>
            </form>
        </div>
    </div>
</header>