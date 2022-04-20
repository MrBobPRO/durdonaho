@unless(count($authors))
    <div class="theme-styled-block empty-query-warning">Ба дархости шумо ягон муаллиф ёфт нашуд !</div>
@endunless

@foreach ($authors as $author)
    <x-card-author :author="$author" class="theme-styled-block card_with_medium_image" />
@endforeach

{{ $authors->links('layouts.pagination') }}