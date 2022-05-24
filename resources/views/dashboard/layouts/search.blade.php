<div class="search">
    <div class="selectize-singular-container">
        <select class="selectize-singular-linked" placeholder="Поиск...">
            <option></option>
            @foreach($items as $item)
                <option value="{{ route($editRoute, $item->id)}}">{{$item->title}}</option>
            @endforeach
        </select>
    </div>
</div>