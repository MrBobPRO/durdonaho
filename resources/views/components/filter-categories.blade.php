@props(['categories', 'request'])

@php
    switch ($request->route()->getName()) {
        case 'quotes.index':
            $title = 'Ҳама иқтибосҳо';
            break;
        
        default:
            $title = 'Undefined';
            break;
    }

    if($request->category_id) {
        $activeCategories = explode(',', $request->category_id);
    } else {
        $activeCategories = false;
    }
@endphp

<section class="categories-filter theme-styled-block">
    <h1 class="categories-filter__title main-title">{{ $title }}</h1>

    <form class="categories-filter__form" action="#" id="categories-filter-form">
        <div class="search categories-filter__search">
            <input class="search__input categories-filter__search-input" type="text" placeholder="Ҷустуҷӯи иқтибосҳо" name="keyword" value="{{ $request->keyword }}">
            <span class="material-icons search__icon">search</span>
        </div>

        <div class="categories-filter__list">
            {{-- All categories --}}
            <input class="categories-filter__checkbox" type="checkbox" id="all-categories-checkbox" @checked(!$activeCategories)>
            <label class="categories-filter__label" for="all-categories-checkbox">Все</label>

            @foreach ($categories as $category)
                <input class="categories-filter__checkbox
                    @if(!$activeCategories && $loop->index > 13)
                        categories-filter__checkbox--hidden
                    @endif"

                    type="checkbox" name="category_id" id="category{{ $category->id }}"

                    @if($activeCategories)
                        @foreach ($activeCategories as $activeId)
                            @checked($category->id == $activeId)
                        @endforeach
                    @endif
                >
                <label class="categories-filter__label" for="category{{ $category->id }}">{{ $category->title }}</label>
            @endforeach

            {{-- Show all categories --}}
            @if(!$activeCategories && count($categories) > 13)
                <input class="categories-filter__checkbox" checked type="checkbox" id="show-hidden-categories-checkbox">
                <label class="categories-filter__label" for="show-hidden-categories-checkbox">Ещё {{ count($categories) - 13 }}</label>
            @endif
        </div>
    </form>
</section>