@props(['id', 'class' => ''])

<div class="accept-terms {{ $class }}">
    <div class="checkbox-container">
        <input class="checkbox" type="checkbox" name="terms" value="accepted" id="{{ $id }}-checkbox" required>
        <div class="checkbox-replacer"></div>
    </div>

    <div class="accept-terms__divider">
        <label class="accept-terms__label unselectable" for="{{ $id }}-checkbox">Я принимаю</label>
        <a class="accept-terms__link" href="{{ route('terms-of-use') }}" target="_blank">пользовательское соглашение</a>
    </div>
</div>