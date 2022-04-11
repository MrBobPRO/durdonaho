@props(['quote', 'author'])

<div class="aside-popularity aside-popular-quote theme-styled-block">
    <h1 class="aside-popularity__title main-title">Иқтибосҳои маъмул</h1>

    <x-card-quote :quote="$quote" class="card_with_medium_image card--vertical" />
</div>

<div class="aside-popularity aside-popular-author theme-styled-block">
    <h1 class="aside-popularity__title main-title">Муаллифони машҳур</h1>

    <x-card-author :author="$author" class="card_with_medium_image card--vertical" />
</div>