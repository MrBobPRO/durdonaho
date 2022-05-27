@extends('dashboard.layouts.app')
@section("main")

@include('dashboard.layouts.search')

{{-- Table form start --}}
<form action="{{ route($modelShortcut . '.destroy') }}" method="POST" class="table-form" id="table-form">
    @csrf
    {{-- Table start --}}
    <table class="main-table" cellpadding = "8" cellspacing = "10">
        {{-- Table Head start --}}
        <thead>
            <tr>
                {{-- Empty space for checkbox --}}
                <th width="20"></th>

                @php $reversedOrderType = App\Helpers\Helper::reverseOrderType($orderType); @endphp

                <th>
                    <a class="{{ $orderType }} {{ $orderBy == 'title' ? 'active' : '' }}" href="{{ route($modelShortcut . '.dashboard.index') }}?page={{ $activePage }}&orderBy=title&orderType={{ $reversedOrderType }}">Заголовок</a>
                </th>

                <th width="120">
                    Действие
                </th>
            </tr>
        </thead>  {{-- Table Head end --}}

        {{-- Table Body start --}}
        <tbody>
            @foreach ($items as $item)
                <tr>
                    {{-- Checkbox for multidelete --}}
                    <td>
                        <div class="checkbox">
                            <label for="item{{$item->id}}">
                                <input id="item{{$item->id}}" type="checkbox" name="id[]" value="{{$item->id}}">
                                <span></span>
                            </label>
                        </div>
                    </td>

                    <td>{{ $item->title }}</td>

                    {{-- Actions --}}
                    <td>
                        <div class="table__actions">
                            <a class="button--secondary" href="{{ route($modelShortcut . '.edit', $item->id) }}" 
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Редактировать">
                                <span class="material-icons">edit</span>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>  {{-- Table Body end --}}
    </table>  {{-- Table end --}}

    {{ $items->links('dashboard.layouts.pagination') }}
</form>  {{-- Table form end --}}

@endsection