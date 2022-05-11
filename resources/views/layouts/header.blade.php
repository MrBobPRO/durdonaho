<header class="header">
    <div class="header__inner main-container">
        <div class="header-top">
            <a class="logo" href="{{ route('home') }}">
                <img class="logo__image" src="{{ asset('img/main/logo.svg') }}" alt="Дурдонаҳо лого">
            </a>

            <div class="header-top__actions">
                @auth
                    <div class="dropdown profile-dropdown">
                        <button class="dropdown__button"><span class="material-icons">person</span></button>

                        <div class="dropdown__content">
                            <div class="dropdown__background"></div>
                            <ul class="dropdown__menu">
                                <li><p class="profile-dropdown__username">{{ auth()->user()->name }}</p></li>

                                <li><a class="dropdown__item" href="{{ route('authors.individual') }}">
                                    <span class="material-icons dropdown__item-icon">message</span>Личные сообщения <span class="profile-dropdown__badget">0</span>
                                </a></li>

                                <li><a class="dropdown__item" href="{{ route('favorite.authors') }}">
                                    <span class="material-icons dropdown__item-icon">face</span> Избранные авторы
                                </a></li>

                                <li><a class="dropdown__item" href="{{ route('favorite.quotes') }}">
                                    <span class="material-icons dropdown__item-icon">bookmark</span> Избранные цитаты
                                </a></li>

                                <li><a class="dropdown__item" href="{{ route('users.quotes') }}">
                                    <span class="material-icons dropdown__item-icon">edit</span> Редактировать цитаты
                                </a></li>

                                <li><a class="dropdown__item" href="{{ route('users.profile') }}">
                                    <span class="material-icons dropdown__item-icon">settings</span> Настройки профиля
                                </a></li>

                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown__item dropdown__item--logout">
                                            <span class="material-icons dropdown__item-icon">logout</span> Выйти
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <a class="button button--main header-top__add-quote" href="{{ route('users.quotes.create') }}"><span class="material-icons-outlined">drive_file_rename_outline</span> Добавить цитату</a>
                @endauth
                
                @guest
                    <button class="header-top__register button button--transparent" data-action="show-modal" data-target-id="register-modal">Зарегистрироваться</button>

                    <button class="button button--main header-top__login" data-action="show-modal" data-target-id="login-modal">
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
                        <a class="header-nav__link 
                            @if($route == 'authors.index') active 
                            @elseif($route == 'authors.show' && !$author->individual) active
                            @endif"
                            href="{{ route('authors.index') }}">Муаллифон
                        </a>
                    </li>

                    <li class="header-nav__item">
                        <div class="dropdown">
                            <button class="header-nav__link dropdown__button 
                                @if($route == "quotes.individual" || $route == 'authors.individual') active 
                                @elseif($route == 'authors.show' && $author->individual) active
                                @endif"
                            >Самиздат</button>

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

            <form action="{{ route('search') }}" method="GET" class="search header__search {{ $route == 'search' ? 'search--active' : '' }}">
                <input class="search__input" type="text" placeholder="Ҷустуҷӯ" name="keyword" value="{{ $route == 'search' ? $keyword : '' }}">
                <span class="material-icons search__icon">search</span>
            </form>
        </div>
    </div>
</header>