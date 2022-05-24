@extends('dashboard.layouts.app')
@section("main")

@include('dashboard.layouts.search')

{{-- Main form start --}}
<form action="{{ route('researches.destroy') }}" method="POST" class="table-form" id="table-form">
    @csrf
    {{-- Table start --}}
    <table class="main-table" cellpadding = "8" cellspacing = "10">
        {{-- Table Head start --}}
        <thead>
            <tr>
                {{-- empty space for checkbox --}}
                <th width="20"></th>

                <th>
                    <a class="{{$orderType}} {{$orderBy == 'title' ? 'active' : ''}}" href="{{route('dashboard.researches.index')}}?page={{$activePage}}&orderBy=title&orderType={{$reversedOrderType}}">Заголовок</a>
                </th>

                <th>
                    <a class="{{$orderType}} {{$orderBy == 'subtitle' ? 'active' : ''}}" href="{{route('dashboard.researches.index')}}?page={{$activePage}}&orderBy=subtitle&orderType={{$reversedOrderType}}">Подзаголовок</a>
                </th>

                <th>
                    <a class="{{$orderType}} {{$orderBy == 'productName' ? 'active' : ''}}" href="{{route('dashboard.researches.index')}}?page={{$activePage}}&orderBy=productName&orderType={{$reversedOrderType}}">Продукт</a>
                </th>

                <th width="120">
                    Действие
                </th>
            </tr>
        </thead>  {{-- Table Head end --}}

        {{-- Table Body start --}}
        <tbody>
            @foreach ($researches as $research)
                <tr>
                    {{-- Checkbox for multidelete --}}
                    <td width="20">
                        <div class="checkbox">
                            <label for="item{{$research->id}}">
                                <input id="item{{$research->id}}" type="checkbox" name="id[]" value="{{$research->id}}">
                                <span></span>
                            </label>
                        </div>
                    </td>

                    <td>{{ $research->title }}</td>
                    <td>{{ $research->subtitle }}</td>
                    <td>{{ $research->productName }}</td>

                    {{-- Actions --}}
                    <td width="120">
                        <div class="table__actions">
                            <a class="button--main" href="{{ route('researches.show', $research->url) }}"
                                target="_blank" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Посмотреть">
                                <span class="material-icons">visibility</span>
                            </a>
        
                            <a class="button--secondary" href="{{ route('researches.edit', $research->id) }}" 
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Редактировать">
                                <span class="material-icons">edit</span>
                            </a>
        
                            <button class="button--danger" type="button" onclick="showSingleDestroyModal({{ $research->id }})"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Удалить">
                                <span class="material-icons">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>  {{-- Table Body end --}}
    </table>  {{-- Table end --}}
    
    {{ $researches->links('dashboard.layouts.pagination') }}
</form>  {{-- Main form end --}}


@include('dashboard.modals.single-destroy', ['destroyRoute' => 'researches.destroy', 'itemId' => '0'])
@include('dashboard.modals.multiple-destroy')

@endsection