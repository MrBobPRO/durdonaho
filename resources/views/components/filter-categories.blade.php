@props(['title', 'categories'])

<section class="categories-filter theme-styled-block">
    <h1 class="categories-filter__title main-title">{{ $title }}</h1>

    <form class="categories-filter__form" action="#">
        <div class="search categories-filter__search">
            <input class="search__input categories-filter__search-input" type="text" placeholder="Ҷустуҷӯи иқтибосҳо ">
            <span class="material-icons search__icon">search</span>
        </div>

        <div class="categories-filter__list">
            @foreach ($categories as $category)
                <input class="categories-filter__checkbox" type="checkbox" id="category{{ $category->id }}">
                <label class="categories-filter__label" for="category{{ $category->id }}">{{ $category->title }}</label>
            @endforeach
        </div>
    </form>

</section>