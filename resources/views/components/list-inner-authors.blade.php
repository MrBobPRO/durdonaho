@unless(count($authors))
    <h3 class="no-quotes-title">Ба дархости шумо ягон муаллиф ёфт нашуд !</h3>
@endunless

@foreach ($authors as $author)
    <x-card-author :author="$author" class="theme-styled-block card_with_medium_image" />
@endforeach

{{ $authors->links('layouts.pagination') }}