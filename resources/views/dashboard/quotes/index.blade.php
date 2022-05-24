@extends('dashboard.layouts.app')
@section("main")

{{-- @if(!$errors->any() && $activePage == 1)
    <div class="alert alert-warning warning-container">
        <span class="material-icons">warning</span>
        При удалении продукта, также удалятся исследования по этому продукту
    </div>
@endif --}}

@include('dashboard.layouts.search')

{{-- Main form start --}}
<form action="{{ route('quotes.destroy') }}" method="POST" class="table-form" id="table-form">
    @csrf
    {{-- Table start --}}
    <table class="main-table" cellpadding = "8" cellspacing = "10">
        {{-- Table Head start --}}
        <thead>
            <tr>
                {{-- empty space for checkbox --}}
                <th width="20"></th>

                <th width="460">
                    Текст
                </th>

                <th>
                    <a class="{{$orderType}} {{$orderBy == 'author_name' ? 'active' : ''}}" href="{{route('dashboard.index')}}?page={{$activePage}}&orderBy=author_name&orderType={{$reversedOrderType}}">Автор</a>
                </th>

                <th>
                    <a class="{{$orderType}} {{$orderBy == 'category_titles' ? 'active' : ''}}" href="{{route('dashboard.index')}}?page={{$activePage}}&orderBy=category_titles&orderType={{$reversedOrderType}}">Категории</a>
                </th>

                <th>
                    <a class="{{$orderType}} {{$orderBy == 'created_at' ? 'active' : ''}}" href="{{route('dashboard.index')}}?page={{$activePage}}&orderBy=created_at&orderType={{$reversedOrderType}}">Дата добавления</a>
                </th>

                <th width="120">
                    Действие
                </th>
            </tr>
        </thead>  {{-- Table Head end --}}

        {{-- Table Body start --}}
        <tbody>
            @foreach ($quotes as $quote)
                <tr>
                    {{-- Checkbox for multidelete --}}
                    <td width="20">
                        <div class="checkbox">
                            <label for="item{{$quote->id}}">
                                <input id="item{{$quote->id}}" type="checkbox" name="id[]" value="{{$quote->id}}">
                                <span></span>
                            </label>
                        </div>
                    </td>

                    <td>{{ mb_strlen($quote->body) > 200 ? (mb_substr($quote->body, 0, 200) . '...') : $quote->body }}</td>
                    <td>{{ $quote->author->name }}</td>

                    <td>
                        @if($orderBy == 'category_titles')
                            {!! str_replace(',', '<br>', $quote->category_titles) !!}
                        @else
                            @foreach ($quote->categories as $category)
                                {{ $category->title }}
                                @if(!$loop->last)
                                    <br>
                                @endif
                            @endforeach
                        @endif
                    </td>

                    <td>{{ Carbon\Carbon::create($quote->created_at)->locale("ru")->isoFormat("DD MMMM YYYY HH:mm") }}</td>

                    {{-- Actions --}}
                    <td width="120">
                        <div class="table__actions">
                            <a class="button--secondary" href="{{ route('quotes.edit', $quote->id) }}" 
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Редактировать">
                                <span class="material-icons">edit</span>
                            </a>

                            <button class="button--danger" type="button" onclick="showSingleDestroyModal({{ $quote->id }})"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Удалить">
                                <span class="material-icons">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>  {{-- Table Body end --}}
    </table>  {{-- Table end --}}

    {{-- {{ $quotes->links('dashboard.layouts.pagination') }} --}}
</form>  {{-- Main form end --}}


@include('dashboard.modals.single-destroy', ['destroyRoute' => 'quotes.destroy', 'itemId' => '0'])
@include('dashboard.modals.multiple-destroy')

@endsection