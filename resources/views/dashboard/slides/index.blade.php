@extends('dashboard.layouts.app')
@section("main")

{{-- Main form start --}}
<form action="{{ route('slides.destroy') }}" method="POST" class="table-form" id="table-form">
    @csrf
    {{-- Table start --}}
    <table class="main-table" cellpadding = "8" cellspacing = "10">
        {{-- Table Head start --}}
        <thead>
            <tr>
                {{-- empty space for checkbox --}}
                <th width="20"></th>

                <th>
                    Приоритет
                </th>

                <th>
                    Заголовок
                </th>

                <th>
                    Ссылка
                </th>

                <th width="120">
                    Действие
                </th>
            </tr>
        </thead>  {{-- Table Head end --}}

        {{-- Table Body start --}}
        <tbody>
            @foreach ($slides as $slide)
                <tr>
                    {{-- Checkbox for multidelete --}}
                    <td width="20">
                        <div class="checkbox">
                            <label for="item{{$slide->id}}">
                                <input id="item{{$slide->id}}" type="checkbox" name="id[]" value="{{$slide->id}}">
                                <span></span>
                            </label>
                        </div>
                    </td>

                    <td>{{ $slide->priority }}</td>
                    <td>{{ $slide->title }}</td>
                    <td>{{ $slide->link }}</td>

                    {{-- Actions --}}
                    <td width="120">
                        <div class="table__actions">
                            <a class="button--main" href="{{ route('home') }}"
                                target="_blank" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Посмотреть">
                                <span class="material-icons">visibility</span>
                            </a>
        
                            <a class="button--secondary" href="{{ route('slides.edit', $slide->id) }}" 
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Редактировать">
                                <span class="material-icons">edit</span>
                            </a>
        
                            <button class="button--danger" type="button" onclick="showSingleDestroyModal({{ $slide->id }})"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Удалить">
                                <span class="material-icons">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>  {{-- Table Body end --}}
    </table>  {{-- Table end --}}
    
</form>  {{-- Main form end --}}


@include('dashboard.modals.single-destroy', ['destroyRoute' => 'slides.destroy', 'itemId' => '0'])
@include('dashboard.modals.multiple-destroy')

@endsection