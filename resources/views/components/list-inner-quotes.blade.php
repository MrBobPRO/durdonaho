{{-- Props not used because of controllers component return error --}}

@unless(count($quotes))
    <div class="theme-styled-block empty-query-warning">Ба дархости шумо ягон иқтибос ёфт нашуд !</div>
@endunless

@foreach ($quotes as $quote)
    <x-card-quote :quote="$quote" class="theme-styled-block {{ $cardClass }}" />
@endforeach

{{ $quotes->links('layouts.pagination') }}