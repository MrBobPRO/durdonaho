@props(['quotes'])

<div class="owl-carousel-container">
    <div class="owl-carousel card-carousel">
        @foreach ($quotes as $quote)
        <div class="owl-carousel__item card">
            <div class="card__header">
                <div class="card__header-info">
                    <h1 class="card__title">Автор цитаты: {{ $quote->author->name }}</h1>
                    <ul class="card__categories">
                        @foreach ($quote->categories as $category)
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

            <img class="card__image" src="{{ asset('img/authors/' . $quote->author->image) }}" alt="{{ $quote->author->name }}">
            <p class="card__text">{{ $quote->body }}</p>

            <div class="card__publish">
                @php
                    $formatted = Carbon\Carbon::create($quote->created_at)->locale("ru");
                @endphp

                <p class="card__publish-date">{{ $formatted->isoFormat("DD.mm.YYYY") }}<span> в </span>{{ $formatted->isoFormat("HH:mm:ss") }} Опубликовано:</p>
                <a class="card__publish-author" href="#"><span class="material-icons">person</span> {{ $quote->author->name }}</a>
                <a class="card__publish-chat" href="#"><span class="material-icons-outlined">message</span> Написать</a>
            </div>
        </div>
        @endforeach
    </div>
</div>