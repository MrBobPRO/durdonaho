{{-- 
    This component is used everywhere as a Card for all types of quote cards

    $class ->                   Additional classes: card_with_medium_image || card--vertical || card--full_width etc
    $dataCarouselItemIndex ->   Counter for current carousel items index (used only on home page)
    $routeName ->               Used only to determine if it is search page
    $keyword ->                 Highlighting search Keywords on search page
    $showEditButton ->          Used to display edit button (true only on users.current.quotes route)
--}}

@props(['quote', 'class' => '', 'dataCarouselItemIndex' => '', 'routeName' => request()->route()->getName(), 'keyword' => request()->keyword, 'showEditButton' => null])

<div class="{{ $class }} card" data-card-id="quote{{ $quote->id }}" data-carousel-item-index="{{ $dataCarouselItemIndex }}">
    <div class="card__inner">

        {{-- Card Header start --}}
        <div class="card__header">
            <img class="card__image card__image--small"
                @switch($quote->source->key)
                    @case(App\Models\Source::AUTHORS_QUOTE_KEY)
                        src="{{ asset('img/authors/' . $quote->author->image) }}" alt="{{ $quote->author->name }}"
                        @break

                    @case(App\Models\Source::OWN_QUOTE_KEY)
                        src="{{ asset('img/users/' . $quote->user->image) }}" alt="{{ $quote->user->name }}"
                        @break

                    @case(App\Models\Source::UNKNOWN_AUTHOR_KEY)
                        src="{{ asset('img/sources/' . $quote->source->image ?? App\Models\Source::UNKNOWN_AUTHOR_DEFAULT_IMAGE) }}" alt="Неизвестный автор"
                        @break

                    @case(App\Models\Source::FROM_BOOK_KEY)
                        src="{{ asset('img/sources/' . $quote->source->image ?? App\Models\Source::FROM_BOOK_DEFAULT_IMAGE) }}" alt="{{ $quote->bookSource->title }}"
                        @break

                    @case(App\Models\Source::FROM_MOVIE_KEY)
                        src="{{ asset('img/sources/' . $quote->source->image ?? App\Models\Source::FROM_MOVIE_DEFAULT_IMAEG) }}" alt="{{ $quote->movieSource->title }}"
                        @break

                    @case(App\Models\Source::FROM_SONG_KEY)
                        src="{{ asset('img/sources/' . $quote->source->image ?? App\Models\Source::FROM_SONG_DEFAULT_IMAGE) }}" alt="{{ $quote->songSource->title }}"
                        @break

                    @case(App\Models\Source::FROM_PROVERB_KEY)
                        src="{{ asset('img/sources/' . $quote->source->image ?? App\Models\Source::FROM_PROVERB_DEFAULT_IMAGE) }}" alt="Пословица/поговорка"
                        @break

                    @case(App\Models\Source::FROM_PARABLE_KEY)
                        src="{{ asset('img/sources/' . $quote->source->image ?? App\Models\Source::FROM_PARABLE_DEFAULT_IMAGE) }}" alt="Притча"
                        @break
                @endswitch
            >

            <div class="card__header-text">
                @if($showEditButton)
                    <a class="card__edit-btn button button--transparent" href="{{ route('users.quotes.edit', $quote->id) }}">
                        <span class="material-icons-outlined card__edit-btn-icon">edit</span> Редактировать
                    </a>
                @endif

                <h3 class="card__title">
                    @switch($quote->source->key)
                        @case(App\Models\Source::AUTHORS_QUOTE_KEY)
                            <a class="card__title-link" href="{{ route('authors.show', $quote->author->slug) }}">
                                {!! $routeName == 'search' ? App\Helpers\Helper::highlightKeyword($keyword, $quote->author->name) : $quote->author->name !!}
                            </a>
                            @break

                        @case(App\Models\Source::OWN_QUOTE_KEY)
                            <a class="card__title-link" href="{{ route('users.show', $quote->user->slug) }}">
                                {{ $quote->user->name }}
                            </a>
                            @break

                        @case(App\Models\Source::UNKNOWN_AUTHOR_KEY)
                            Неизвестный автор
                            @break

                        @case(App\Models\Source::FROM_BOOK_KEY)
                            {{ $quote->bookSource->title }}
                            @break

                        @case(App\Models\Source::FROM_MOVIE_KEY)
                            {{ $quote->movieSource->title }}
                            @break

                        @case(App\Models\Source::FROM_SONG_KEY)
                            {{ $quote->songSource->title }}
                            @break

                        @case(App\Models\Source::FROM_PROVERB_KEY)
                            Пословица/поговорка
                            @break

                        @case(App\Models\Source::FROM_PARABLE_KEY)
                            Притча
                            @break
                    @endswitch
                </h3>


                <ul class="card__categories">
                    @foreach ($quote->categories as $category)
                        <li class="card__categories-item">
                            <a class="card__categories-link" href="{{ route('quotes.index') }}?category_id={{ $category->id }}">{{ $category->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div> {{-- Card Header end --}}

        {{-- Card Body start --}}
        <div class="card__body">
            <img class="card__image card__image--medium" src="{{ asset('img/authors/' . $quote->author->image) }}" alt="{{ $quote->author->name }}">
            
            <div class="card__body-text-container">
                <p class="card__body-text">{!! $routeName == 'search' ? App\Helpers\Helper::highlightKeyword($keyword, $quote->body) : $quote->body !!}</p>
                {{-- <a class="button button--secondary card__body-link" href="#">Муфассал</a> --}}
            </div>
        </div> {{-- Card Body end --}}

        {{-- Card Footer start --}}
        <div class="card__footer">
            <div class="card__actions">
                @guest
                    <button class="card__actions-button card__actions-favorite" data-action="show-modal" data-target-id="login-modal">
                        <span class="material-icons-outlined card__actions-favorite-icon">bookmarks</span> В избранные
                    </button>

                    <button class="card__actions-button card__actions-share">
                        <div class="ya-share2" data-copy="last" data-curtain data-limit="0" data-more-button-type="long"
                            data-services="vkontakte,facebook,telegram,twitter,viber,whatsapp,skype" data-title="{{ App\Helpers\Helper::generateShareText($quote->author->name . ': “' . $quote->body) . '”'}}" data-image="{{ asset('img/main/logo-share.png') }}" data-url="{{ route('quotes.index') }}">
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
                            data-services="vkontakte,facebook,telegram,twitter,viber,whatsapp,skype" data-title="{{ App\Helpers\Helper::generateShareText($quote->author->name . ': “' . $quote->body) . '”'}}" data-image="{{ asset('img/main/logo-share.png') }}" data-url="{{ route('quotes.index') }}">
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

            <div class="card__publication">
                @php
                    $formatted = Carbon\Carbon::create($quote->created_at)->locale("ru");
                @endphp

                <p class="card__publication-date">{{ $formatted->isoFormat("DD.mm.YYYY HH:mm") }}</p>
                <p class="card__publication-text">Опубликовано:</p>
                <a class="card__publication-user" href="{{ route('users.show', $quote->publisher->slug) }}"><span class="material-icons">person</span> {{ $quote->publisher->name }}</a>
                {{-- <a class="card__publication-chat" href="#"><span class="material-icons-outlined">message</span> Написать</a> --}}
            </div>

            @auth
                <button class="report-bug-button" data-action="show-report-bug-modal" data-quote-id="{{ $quote->id }}">
                    <span class="material-icons-outlined report-bug-button__icon">error_outline</span>
                </button>
            @endauth
        </div> {{-- Card Footer end --}}

    </div>  {{-- Card Inner end --}}
</div>