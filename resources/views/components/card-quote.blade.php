@props(['quote', 'class' => '', 'dataCarouselItemIndex' => ''])

<div class="{{ $class }} card" data-card-id="quote{{ $quote->id }}" data-carousel-item-index="{{ $dataCarouselItemIndex }}">
    <div class="card__inner">

        {{-- Card Header start --}}
        <div class="card__header">
            <div class="card__header-main">
                <img class="card__image card__header-image--small" src="{{ asset('img/authors/' . $quote->author->image) }}" alt="{{ $quote->author->name }}">

                <div class="card__header-info">
                    <h1 class="card__title"><span class="card__title-span">Автор цитаты:</span> {{ $quote->author->name }}</h1>
                    <ul class="card__categories">
                        @foreach ($quote->categories as $category)
                            <li class="card__categories-item">
                                <a class="card__categories-link" href="{{ route('quotes.index') }}?category_id={{ $category->id }}">{{ $category->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="card__actions">
                @guest
                    <button class="card__actions-button card__actions-favorite" data-action="show-modal" data-target-id="login-modal">
                        <span class="material-icons-outlined card__actions-favorite-icon">bookmarks</span> В избранные
                    </button>

                    <button class="card__actions-button card__actions-share">
                        <div class="ya-share2" data-copy="last" data-curtain data-limit="0" data-more-button-type="long"
                            data-services="vkontakte,facebook,odnoklassniki,telegram,twitter,viber,whatsapp,skype" data-title="{{ App\Helpers\Helper::generateShareText($quote->author->name . ': “' . $quote->body) . '”'}}" data-image="{{ asset('img/main/logo-share.png') }}" data-url="{{ route('home') }}">
                        </div>
                    </button>

                    <button class="card__actions-button card__actions-like" data-action="show-modal" data-target-id="login-modal">
                        <span class="material-icons-outlined card__actions-like-icon">favorite_border</span> 
                        Понравилось: <span class="card__actions-like-counter">{{ $quote->likes->count() }}</span>
                    </button>
                @endguest

                @auth
                    <button class="card__actions-button card__actions-favorite" data-action="favorite" data-quote-id="{{ $quote->id }}">
                        @php
                            $favorited = App\Models\Favorite::where('user_id', auth()->user()->id)->where('quote_id', $quote->id)->first();
                        @endphp

                        <span class="material-icons{{ $favorited ? '' : '-outlined' }} card__actions-favorite-icon">bookmarks</span> В избранные
                    </button>

                    <button class="card__actions-button card__actions-share">
                        <div class="ya-share2" data-copy="last" data-curtain data-limit="0" data-more-button-type="long"
                            data-services="vkontakte,facebook,odnoklassniki,telegram,twitter,viber,whatsapp,skype" data-title="{{ App\Helpers\Helper::generateShareText($quote->author->name . ': “' . $quote->body) . '”'}}" data-image="{{ asset('img/main/logo-share.png') }}" data-url="{{ route('home') }}">
                        </div>
                    </button>

                    <button class="card__actions-button card__actions-like" data-action="like" data-quote-id="{{ $quote->id }}">
                        @php
                            $liked = App\Models\Like::where('user_id', auth()->user()->id)->where('quote_id', $quote->id)->first();
                        @endphp

                        <span class="material-icons-outlined card__actions-like-icon">{{ $liked ? 'favorite' : 'favorite_border' }}</span> 
                        Понравилось: <span class="card__actions-like-counter">{{ $quote->likes->count() }}</span>
                    </button>
                @endauth
            </div>
        </div> {{-- Card Header end --}}

        {{-- Card Body start --}}
        <div class="card__body">
            <img class="card__image card__body-image--large" src="{{ asset('img/authors/' . $quote->author->image) }}" alt="{{ $quote->author->name }}">
            <img class="card__image card__body-image--medium" src="{{ asset('img/authors/' . $quote->author->image) }}" alt="{{ $quote->author->name }}">
            <div class="card__body-text-container">
                <p class="card__body-text">{{ $quote->body }}</p>
                <a class="button button--secondary card__body-link" href="#">Муфассал</a>
            </div>
        </div> {{-- Card Body end --}}

        {{-- Card Footer start --}}
        <div class="card__footer">
            @php
                $formatted = Carbon\Carbon::create($quote->created_at)->locale("ru");
            @endphp

            <p class="card__footer-date">{{ $formatted->isoFormat("DD.mm.YYYY") }}<span> в </span>{{ $formatted->isoFormat("HH:mm:ss") }}</p>
            <p class="card__footer-text">Опубликовано:</p>
            <a class="card__footer-author" href="{{ route('users.show', $quote->publisher->slug) }}"><span class="material-icons">person</span> {{ $quote->publisher->name }}</a>
            <a class="card__footer-chat" href="#"><span class="material-icons-outlined">message</span> Написать</a>

            @auth
                <button class="report-bug-button" data-action="show-report-bug-modal" data-quote-id="{{ $quote->id }}">
                    <span class="material-icons-outlined report-bug-button__icon">error_outline</span>
                </button>
            @endauth
        </div> {{-- Card Footer end --}}

    </div>  {{-- Card Inner end --}}
</div>