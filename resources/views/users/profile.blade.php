@extends('layouts.app')
@section('main')

<div class="main__content profile-page-content">
    <section class="theme-styled-block profile-section">
        <div class="profile-section__inner">

            <form class="profile-form" action="{{ route('users.update') }}" method="POST" id="profile-update-form">
                @csrf

                {{-- Profile Settings --}}
                <div class="profile-form__block">
                    <h1 class="main-title profile-form__title">Настройки профиля</h1>

                    <div class="profile-form__group">
                        <input class="input profile-form__input" name="name" type="text" value="{{ $user->name }}" readonly>
                        <button class="profile-form__edit-btn" type="button" data-target-input-name="name"><span class="material-icons">edit</span> Редактировать</button>
                    </div>
    
                    <div class="profile-form__group">
                        <input class="input profile-form__input" name="email" type="email" value="{{ $user->email }}" readonly>
                        <button class="profile-form__edit-btn" type="button" data-target-input-name="email"><span class="material-icons">edit</span> Редактировать</button>
                    </div>
    
                    <div class="profile-form__group profile-form__group--borderless">
                        <select class="selectize-singular profile-form__selectize-singular" name="prescription_id" required placeholder="Выберите пол">
                            <option></option>
                            <option value="male" @selected($user->gender == 'male')>Мужской</option>
                            <option value="female" @selected($user->gender == 'female')>Женский</option>
                        </select>
                    </div>

                    <div class="profile-form__image-group">
                        <img class="profile-form__image-file" src="{{ asset('img/users/' . $user->image) }}" alt="{{ $user->name }}" id="profile-form-image-file">
                        
                        {{-- Hidden input --}}
                        <input class="input profile-form__image-input" name="image" type="file" id="profile-form-image-input">
                        
                        <div class="profile-form__image-additional-actions">
                            <label class="profile-form__image-edit-label" for="profile-form-image-input"><span class="material-icons">edit</span> Редактировать</label>

                            <button class="profile-form__image-remove-btn" type="button" id="profile-form-image-remove-btn">Удалить</button>
                            {{-- True when user clicks remove image button --}}
                            <input type="hidden" value="0" name="remove_image" id="profile-form-image-remove-input">
                        </div>
                    </div>
                </div>  {{-- /end Profile Settings --}}

                {{-- Password --}}
                <div class="profile-form__block">
                    <h1 class="main-title profile-form__title">Изменить пароль</h1>

                    <div class="profile-form__group">
                        <input class="profile-form__input" name="old_password" type="password" readonly placeholder="Старый пароль">
                        <button class="profile-form__edit-btn" type="button" data-target-input-name="old_password"><span class="material-icons">edit</span> Редактировать</button>
                    </div>

                    <div class="profile-form__group">
                        <input class="profile-form__input" name="new_password" type="password" readonly placeholder="Новый пароль">
                    </div>
                </div>  {{-- /end Password --}}

                {{-- About --}}
                <div class="profile-form__block">
                    <h1 class="main-title profile-form__title">Коротко обо мне и интересах</h1>

                    <div class="profile-form__group profile-form__group--columned profile-form__group--borderless">
                        <textarea class="textarea profile-form__textarea textrarea_resize_on_input" name="biography" placeholder="Коротко обо мне и интересах" readonly>{{ $user->biography }}</textarea>
                        <button class="profile-form__edit-btn" type="button" data-target-input-name="biography"><span class="material-icons">edit</span> Редактировать</button>
                    </div>
                </div>  {{-- /end About --}}

                <button class="button button--main profile-form__submit">Сохранить изменения</button>

                {{-- Terms --}}
                <div class="terms profile-terms">
                    <div class="checkbox-container">
                        <input class="checkbox terms__checkbox" type="checkbox" name="terms" value="accepted" id="profile-terms-checkbox" required checked>
                        <div class="checkbox-replacer"></div>
                    </div>

                    <div class="terms__divider">
                        <label class="terms__label unselectable" for="profile-terms-checkbox">Я принимаю</label>
                        <a class="terms__link" href="#" target="_blank">пользовательское соглашение</a>
                    </div>
                </div>  {{-- /end Terms --}}
            </form> 

        </div>
    </section>
</div>

@endsection