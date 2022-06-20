@extends('layouts.app')
@section('main')

<div class="main__content profile-page-content">
    <section class="theme-styled-block profile-section">
        <div class="profile-section__inner">

            <form class="main-form profile-form" action="{{ route('users.update') }}" method="POST" id="profile-update-form" enctype="multipart/form-data">
                @csrf

                {{-- Profile Settings --}}
                <div class="main-form__divider">
                    <h1 class="main-title main-form__title">Настройки профиля</h1>

                    <div class="main-form__group">
                        @error('name')
                            <span class="main-form__error">{{ $message }}</span>
                        @enderror

                        <div class="main-form__editable-block @error('name') main-form__editable-block--error @enderror">
                            <input class="main-form__editable-block-input" name="name" type="text" value="{{ old('name') != '' ? old('name') : $user->name }}" placeholder="Имя" readonly required>
                            <button class="main-form__editable-block-button" type="button" data-target-input-name="name"><span class="material-icons">edit</span> Редактировать</button>
                        </div>
                    </div>
                    
                    <div class="main-form__group">
                        @error('email')
                            <span class="main-form__error">{{ $message }}</span>
                        @enderror

                        <div class="main-form__editable-block @error('email') main-form__editable-block--error @enderror">
                            <input class="main-form__editable-block-input" name="email" type="email" value="{{ old('email') != '' ? old('email') : $user->email }}" placeholder="Электронная почта" readonly required>
                            <button class="main-form__editable-block-button" type="button" data-target-input-name="email"><span class="material-icons">edit</span> Редактировать</button>
                        </div>
                    </div>
    
                    <div class="main-form__group">
                        <label class="label main-form__label" for="gender-select">Выберите пол</label>

                        <select class="selectize-singular main-form__selectize-singular" name="gender" id="gender-select" required>
                            <option value="male" @selected($user->gender == 'male')>Мужской</option>
                            <option value="female" @selected($user->gender == 'female')>Женский</option>
                        </select>
                    </div>

                    <div class="profile-form__image-group">
                        <img class="profile-form__image-group-image" src="{{ asset('img/users/' . $user->image) }}" alt="{{ $user->name }}" id="profile-form-image">
                        
                        {{-- Hidden input --}}
                        <input class="profile-form__image-group-input" name="image" type="file" id="profile-form-image-input">
                        
                        <div class="profile-form__image-group-actions">
                            <label class="profile-form__image-group-label" for="profile-form-image-input"><span class="material-icons">edit</span> Редактировать</label>

                            <button class="profile-form__image-group-remove-btn" type="button" id="profile-form-image-remove-btn">Удалить</button>
                            {{-- True when user clicks remove image button --}}
                            <input type="hidden" value="0" name="remove_image" id="profile-form-image-remove-input">
                        </div>
                    </div>
                </div>  {{-- /end Profile Settings --}}

                {{-- Password --}}
                <div class="main-form__divider">
                    <h1 class="main-title main-form__title">Изменить пароль</h1>

                    <div class="main-form__group">
                        @error('old_password')
                            <span class="main-form__error">{{ $message }}</span>
                        @enderror

                        <div class="main-form__editable-block @error('old_password') main-form__editable-block--error @enderror">
                            <input class="main-form__editable-block-input" name="old_password" type="password" placeholder="Старый пароль" minlength="5" readonly>
                            <button class="main-form__editable-block-button" type="button" data-target-input-name="old_password"><span class="material-icons">edit</span> Редактировать</button>
                        </div>
                    </div>

                    <div class="main-form__group">
                        <div class="main-form__editable-block">
                            <input class="main-form__editable-block-input" name="new_password" type="password" placeholder="Новый пароль" minlength="5" autocomplete="new-password" readonly>
                        </div>
                    </div>
                </div>  {{-- /end Password --}}

                {{-- About --}}
                <div class="main-form__divider">
                    <h1 class="main-title main-form__title">Коротко обо мне и интересах</h1>

                    <div class="main-form__group">
                        <div class="main-form__editable-block main-form__editable-block--columned">
                            <textarea class="textarea main-form__textarea textrarea_resize_on_input" name="biography" placeholder="Коротко обо мне и интересах" readonly>{{ $user->biography }}</textarea>
                            <button class="main-form__editable-block-button" type="button" data-target-input-name="biography"><span class="material-icons">edit</span> Редактировать</button>
                        </div>
                    </div>
                </div>  {{-- /end About --}}

                <button class="button button--main main-form__submit">Сохранить изменения</button>

                {{-- Terms --}}
                <div class="terms main-form-terms">
                    <div class="checkbox-container">
                        <input class="checkbox terms__checkbox" type="checkbox" name="terms" value="accepted" id="main-form-terms-checkbox" required checked>
                        <div class="checkbox-replacer"></div>
                    </div>

                    <div class="terms__divider">
                        <label class="terms__label unselectable" for="main-form-terms-checkbox">Я принимаю</label>
                        <a class="terms__link" href="{{ route('terms-of-use') }}" target="_blank">пользовательское соглашение</a>
                    </div>
                </div>  {{-- /end Terms --}}
            </form> 

        </div>
    </section>
</div>

@endsection