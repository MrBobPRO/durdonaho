@if($errors->any())
    <div class="alert alert-danger alert-errors">
        <h3><span class="material-icons">warning</span>
            Ошибка! Пожалуйста исправьте ошибки и попробуйте заново.
        </h3>

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif