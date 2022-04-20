@props(['categories'])

<div class="aside-categories theme-styled-block">
    <h1 class="aside-categories__title main-title">Категорияҳо</h1>

    <form action="#" class="search aside__search">
        <input class="search__input" type="text" placeholder="Поиск категорий" id="aside-search-input">
        <span class="material-icons search__icon">search</span>
    </form>

    <ul class="aside-categories__list" id="aside-categories-list">
        @foreach ($categories as $category)
            <li class="aside-categories__item"><a class="aside-categories__link" href="{{ route('quotes.index') }}?category_id={{ $category->id }}">{{ $category->title }}</a></li>
        @endforeach
    </ul>
</div>