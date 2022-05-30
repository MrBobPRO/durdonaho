@extends('dashboard.layouts.app')
@section("main")

@if($activePage == 1)
    <div class="alert alert-warning">
        <span class="material-icons">info</span>
        Список новых цитат или изменённых цитат пользователей, коорые находятся на рассмотрении у администратора (не отображаются на сайте)
    </div>
@endif

@include('dashboard.layouts.search')

{{-- Table form start --}}
<form action="javascript:void(0)" method="POST" class="table-form" id="table-form">
    @csrf
    {{-- Table start --}}
    <table class="main-table" cellpadding = "8" cellspacing = "10">
        {{-- Table Head start --}}
        <thead>
            <tr>
                @php $reversedOrderType = App\Helpers\Helper::reverseOrderType($orderType); @endphp

                <th width="460">
                    Текст
                </th>

                <th>
                    Автор
                </th>

                <th>
                    Издатель
                </th>

                <th>
                    <a class="{{ $orderType }} {{ $orderBy == 'author_name' ? 'active' : '' }}" href="{{ route('quotes.dashboard.unapproved.index') }}?page={{ $activePage }}&orderBy=author_name&orderType={{ $reversedOrderType }}">Статус</a>
                </th>

                <th>
                    <a class="{{ $orderType }} {{ $orderBy == 'updated_at' ? 'active' : '' }}" href="{{ route('quotes.dashboard.unapproved.index') }}?page={{ $activePage }}&orderBy=updated_at&orderType={{ $reversedOrderType }}">Дата посл/измен</a>
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
                    <td>{{ mb_strlen($item->body) > 200 ? (mb_substr($item->body, 0, 200) . '...') : $item->body }}</td>

                    <td>
                        @php $manual = App\Models\Manual::where('quote_id', $item->id)->where('key', 'author')->first(); @endphp
                        {{ $manual ? $manual->value : $item->author->name }}
                    </td>
                    
                    <td><a href="{{ route('users.show', $item->publisher->slug) }}" target="_blank">{{ $item->publisher->name }}</a></td>
                    <td>{!! $item->verified ? 'Просмотрено' : '<span class="danger-color"><b>НОВЫЙ</b></span>' !!}</td>
                    <td>{{ Carbon\Carbon::create($item->updated_at)->locale('ru')->isoFormat('DD MMMM YYYY HH:mm') }}</td>

                    {{-- Actions --}}
                    <td>
                        <div class="table__actions">
                            <a class="button--secondary" href="{{ route('quotes.dashboard.unapproved.edit', $item->id) }}" 
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