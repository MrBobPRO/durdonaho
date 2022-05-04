{{-- Props not used because of controllers component return error --}}

@unless(count($quotes))
    <div class="theme-styled-block empty-query-warning">
        <div class="empty-query-warning__inner">
            Ба дархости шумо ягон иқтибос ёфт нашуд !
        </div>
    </div>
@endunless

@foreach ($quotes as $quote)
    <x-card-quote :quote="$quote" class="theme-styled-block {{ $cardClass }}" />
@endforeach

{{ $quotes->links('layouts.pagination') }}