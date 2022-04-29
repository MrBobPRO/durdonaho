{{-- Props not used because of controller components return error --}}

@unless(count($authors))
    <div class="theme-styled-block empty-query-warning">Ба дархости шумо ягон муаллиф ёфт нашуд !</div>
@endunless

@foreach ($authors as $author)
    <x-card-author :author="$author" class="theme-styled-block {{ $cardClass }}" />
@endforeach

{{ $authors->links('layouts.pagination') }}