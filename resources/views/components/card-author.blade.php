@props(['author', 'class' => ''])

<div class="{{ $class }} card">
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
            <button class="card__actions-button">
                <span class="material-icons-outlined card__actions-span">bookmarks</span> В избранные
            </button>
    
            <button class="card__actions-button">
                <div class="ya-share2" data-copy="last" data-curtain data-limit="0" data-more-button-type="long"
                    data-services="vkontakte,facebook,odnoklassniki,telegram,twitter,viber,whatsapp,skype"></div>
            </button>
    
            <button class="card__actions-button">
                <span class="material-icons-outlined card__actions-span">favorite_border</span> Понравилось: <span class="card__actions-counter">456</span>
            </button>
        </div>
    </div>  {{-- Card Header end --}}

    {{-- Card Body start --}}
    <div class="card__body">
        <img class="card__image card__body-image--large" src="{{ asset('img/authors/' . $author->image) }}" alt="{{ $author->name }}">
        <img class="card__image card__body-image--medium" src="{{ asset('img/authors/' . $author->image) }}" alt="{{ $author->name }}">
        <div class="card__body-text-container">
            <p class="card__body-text">{{ $author->biography }}</p>
            <a class="button button--secondary card__body-link" href="#">Муфассал</a>
        </div>
    </div>  {{-- Card Body end --}}

    {{-- Card Footer start --}}
    <div class="card__footer">
        @php
            $formatted = Carbon\Carbon::create($author->created_at)->locale("ru");
        @endphp

        <p class="card__footer-date">{{ $formatted->isoFormat("DD.mm.YYYY") }}<span> в </span>{{ $formatted->isoFormat("HH:mm:ss") }}</p>
        <p class="card__footer-text">Опубликовано:</p>
        <a class="card__footer-author" href="#"><span class="material-icons">person</span> {{ $author->name }}</a>
        <a class="card__footer-chat" href="#"><span class="material-icons-outlined">message</span> Написать</a>
    </div>  {{-- Card Footer end --}}
</div>