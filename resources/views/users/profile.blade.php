@extends('layouts.app')
@section('main')

<div class="main__content profile-page-content">
    <section class="theme-styled-block profile-section">
        <div class="profile-section__inner">

            <form class="profile-form" action="{{ route('users.update') }}" method="POST">
                {{-- Profile Settings --}}
                <div class="profile-form__block">
                    <h1 class="main-title profile-form__title">Настройки профиля</h1>

                    <div class="profile-form__group">
                        <input class="input profile-form__input" name="name" type="text" value="{{ $user->name }}" readonly>
                        <button class="profile-form__edit-btn"><span class="material-icons">edit</span> Редактировать</button>
                    </div>
    
                    <div class="profile-form__group">
                        <input class="input profile-form__input" name="email" type="email" value="{{ $user->email }}" readonly>
                        <button class="profile-form__edit-btn" type="button"><span class="material-icons">edit</span> Редактировать</button>
                    </div>
    
                    <div class="profile-form__group profile-form__group--borderless">
                        <select class="selectize-singular profile-form__selectize-singular" name="prescription_id" required placeholder="Выберите пол">
                            <option></option>
                            <option value="male" @selected($user->gender == 'male')>Мужское</option>
                            <option value="female" @selected($user->gender == 'female')>Женский</option>
                        </select>
                    </div>
                </div>  {{-- /end Profile Settings --}}

                {{-- Password --}}
                <div class="profile-form__block">
                    <h1 class="main-title profile-form__title">Изменить пароль</h1>

                    <div class="profile-form__group">
                        <input class="profile-form__input" name="old_password" type="password" readonly placeholder="Старый пароль">
                        <button class="profile-form__edit-btn" type="button"><span class="material-icons">edit</span> Редактировать</button>
                    </div>

                    <div class="profile-form__group">
                        <input class="profile-form__input" name="old_password" type="password" readonly placeholder="Новый пароль">
                    </div>
                </div>  {{-- /end Password --}}

                {{-- About --}}
                <div class="profile-form__block">
                    <h1 class="main-title profile-form__title">Коротко обо мне и интересах</h1>

                    <div class="profile-form__group profile-form__group--columned profile-form__group--borderless">
                        <textarea class="textarea profile-form__textarea" name="biography">{{ $user->biography }}</textarea>
                        <button class="profile-form__edit-btn"><span class="material-icons">edit</span> Редактировать</button>
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