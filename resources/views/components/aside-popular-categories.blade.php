@props(['categories'])

<div class="aside-popular-categories theme-styled-block">
    <h1 class="aside-popular-categories__title main-title">Категорияҳои маъмул</h1>
    <div class="aside-popular-categories__text">{!! App\Models\Option::where('key', 'popular-categories-text')->first()->value !!}</div>
    
    <ul class="categories-card-list">
        @foreach ($categories as $category)
            <a class="category-card" href="{{ route('quotes.index') }}?category_id={{ $category->id }}">
                <img class="category-card__image" src="{{ asset('img/categories/' . $category->image) }}" alt="{{ $category->title }}">
                <h6 class="category-card__title">{{ $category->title }}</h6>
            </a>
        @endforeach
    </div>
</div>