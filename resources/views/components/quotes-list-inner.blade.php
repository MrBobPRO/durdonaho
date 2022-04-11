@unless(count($quotes))
    <h3 class="no-quotes-title">Ба дархости шумо ягон иқтибос ёфт нашуд !</h3>
@endunless

@foreach ($quotes as $quote)
    <x-card-quote :quote="$quote" class="theme-styled-block card_with_small_image" />
@endforeach

{{ $quotes->links('layouts.pagination') }}