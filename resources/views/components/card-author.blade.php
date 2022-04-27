@props(['author', 'class' => '', 'dataCarouselItemIndex' => ''])

<div class="{{ $class }} card" data-card-id="author{{ $author->id }}" data-carousel-item-index="{{ $dataCarouselItemIndex }}">
    {{-- Card Header start --}}
    <div class="card__header">
        <div class="card__header-main">
            <img class="card__image card__header-image--small" src="{{ asset('img/authors/' . $author->image) }}" alt="{{ $author->name }}">

            <div class="card__header-info">
                <h1 class="card__title">{{ $author->name }}</h1>
                <ul class="card__categories">
                    {{-- Generate collection of unique categories --}}
                    @php
                        $quotes = $author->quotes;
                        $categories = collect();
    
                        foreach($quotes as $quote) {
                            foreach($quote->categories as $category) {
                                $categories->push($category);
                            }
                        }
                    @endphp
    
                    @foreach ($categories->unique('title') as $category)
                    <li>
                        <a class="card__categories-link" href="#">{{ $category->title }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="card__actions">
            @guest
                <button class="card__actions-button card__actions-bookmark" data-action="show-modal" data-target-id="login-modal">
                    <span class="material-icons-outlined card__actions-bookmark-icon">bookmarks</span> В избранные
                </button>
        
                <button class="card__actions-button card__actions-share">
                    <div class="ya-share2" data-copy="last" data-curtain data-limit="0" data-more-button-type="long"
                        data-services="vkontakte,facebook,odnoklassniki,telegram,twitter,viber,whatsapp,skype"></div>
                </button>
        
                <button class="card__actions-button card__actions-like" data-action="show-modal" data-target-id="login-modal">
                    <span class="material-icons-outlined card__actions-like-icon">favorite_border</span> 
                    Понравилось: <span class="card__actions-like-counter">{{ $author->likes->count() }}</span>
                </button>
            @endguest

            @auth
                <button class="card__actions-button card__actions-bookmark" data-action="bookmark" data-author-id="{{ $author->id }}">
                    @php 
                        $bookmarked = App\Models\Bookmark::where('user_id', auth()->user()->id)->where('author_id', $author->id)->first();
                    @endphp

                    <span class="material-icons{{ $bookmarked ? '' : '-outlined' }} card__actions-bookmark-icon">bookmarks</span>
                    В избранные
                </button>
        
                <button class="card__actions-button card__actions-share">
                    <div class="ya-share2" data-copy="last" data-curtain data-limit="0" data-more-button-type="long"
                        data-services="vkontakte,facebook,odnoklassniki,telegram,twitter,viber,whatsapp,skype"></div>
                </button>
        
                <button class="card__actions-button card__actions-like" data-action="like" data-author-id="{{ $author->id }}">
                    @php 
                        $liked = App\Models\Like::where('user_id', auth()->user()->id)->where('author_id', $author->id)->first();
                    @endphp
                    <span class="material-icons-outlined card__actions-like-icon">{{ $liked ? 'favorite' : 'favorite_border' }}</span>
                    Понравилось: <span class="card__actions-like-counter">{{ $author->likes->count() }}</span>
                </button>
            @endauth
        </div>
    </div>  {{-- Card Header end --}}

    {{-- Card Body start --}}
    <div class="card__body">
        <img class="card__image card__body-image--large" src="{{ asset('img/authors/' . $author->image) }}" alt="{{ $author->name }}">
        <img class="card__image card__body-image--medium" src="{{ asset('img/authors/' . $author->image) }}" alt="{{ $author->name }}">
        <div class="card__body-text-container">
            <p class="card__body-text">{{ $author->biography }}</p>
            <a class="button button--secondary card__body-link" href="{{ route('authors.show', $author->slug) }}">Муфассал</a>
        </div>
    </div>  {{-- Card Body end --}}

    {{-- Card Footer start --}}
    <div class="card__footer">
        @php
            $formatted = Carbon\Carbon::create($author->created_at)->locale("ru");
        @endphp

        <p class="card__footer-date">{{ $formatted->isoFormat("DD.mm.YYYY") }}<span> в </span>{{ $formatted->isoFormat("HH:mm:ss") }}</p>
        <p class="card__footer-text">Опубликовано:</p>
        <a class="card__footer-author" href="{{ route('users.show', $author->publisher->slug) }}"><span class="material-icons">person</span> {{ $author->publisher->name }}</a>
        <a class="card__footer-chat" href="#"><span class="material-icons-outlined">message</span> Написать</a>
    </div>  {{-- Card Footer end --}}
</div>