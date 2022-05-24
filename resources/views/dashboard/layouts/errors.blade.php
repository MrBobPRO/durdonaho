@if($errors->any())
    <div class="alert alert-danger errors-container">
        <h3><span class="material-icons">warning</span>
            Ошибка! Пожалуйста исправьте ошибки и попробуйте заново.
        </h3>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
@endif