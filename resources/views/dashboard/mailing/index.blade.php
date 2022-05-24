@extends('dashboard.layouts.app')
@section("main")

{{-- Main form start --}}
<form action="{{ route('dashboard.mailing.destroy') }}" method="POST" class="table-form" id="table-form">
    @csrf
    {{-- Table start --}}
    <table class="main-table" cellpadding = "8" cellspacing = "10">
        {{-- Table Head start --}}
        <thead>
            <tr>
                {{-- empty space for checkbox --}}
                <th width="20"></th>

                <th>
                    <a class="{{$orderType}} {{$orderBy == 'email' ? 'active' : ''}}" href="{{route('dashboard.mailing.index')}}?page={{$activePage}}&orderBy=email&orderType={{$reversedOrderType}}">E-mail</a>
                </th>

                <th>
                    <a class="{{$orderType}} {{$orderBy == 'created_at' ? 'active' : ''}}" href="{{route('dashboard.mailing.index')}}?page={{$activePage}}&orderBy=created_at&orderType={{$reversedOrderType}}">Дата подписки</a>
                </th>

                <th>
                    <a class="{{$orderType}} {{$orderBy == 'ip' ? 'active' : ''}}" href="{{route('dashboard.mailing.index')}}?page={{$activePage}}&orderBy=ip&orderType={{$reversedOrderType}}">Ip адрес</a>
                </th>

                <th width="120">
                    Действие
                </th>
            </tr>
        </thead>  {{-- Table Head end --}}

        {{-- Table Body start --}}
        <tbody>
            @foreach ($subscriptions as $subscription)
                <tr>
                    {{-- Checkbox for multidelete --}}
                    <td width="20">
                        <div class="checkbox">
                            <label for="item{{$subscription->id}}">
                                <input id="item{{$subscription->id}}" type="checkbox" name="id[]" value="{{$subscription->id}}">
                                <span></span>
                            </label>
                        </div>
                    </td>

                    <td>{{ $subscription->email }}</td>
                    <td>{{ Carbon\Carbon::create($subscription->created_at)->locale("ru")->isoFormat("DD MMMM YYYY HH:mm:ss") }}</td>
                    <td>{{ $subscription->ip }}</td>

                    {{-- Actions --}}
                    <td width="120">
                        <div class="table__actions">
                            <button class="button--danger" type="button" onclick="showSingleDestroyModal({{ $subscription->id }})"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Удалить">
                                <span class="material-icons">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>  {{-- Table Body end --}}
    </table>  {{-- Table end --}}
    
    {{ $subscriptions->links('dashboard.layouts.pagination') }}
</form>  {{-- Main form end --}}


@include('dashboard.modals.single-destroy', ['destroyRoute' => 'dashboard.mailing.destroy', 'itemId' => '0'])
@include('dashboard.modals.multiple-destroy')

@endsection