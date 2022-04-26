@props(['quotes'])

<div class="owl-carousel-container">
    <div class="owl-carousel card-carousel">
        @foreach ($quotes as $quote)
            <x-card-quote :quote="$quote" class="owl-carousel__item card_with_large_image" data-carousel-item-index="{{ $loop->index + 1 }}" />
        @endforeach
    </div>
</div>