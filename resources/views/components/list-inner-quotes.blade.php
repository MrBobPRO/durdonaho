@unless(count($quotes))
    <div class="theme-styled-block empty-query-warning">Ба дархости шумо ягон иқтибос ёфт нашуд !</div>
@endunless

@foreach ($quotes as $quote)
    <x-card-quote :quote="$quote" class="theme-styled-block card_with_small_image" />
@endforeach

{{ $quotes->links('layouts.pagination') }}