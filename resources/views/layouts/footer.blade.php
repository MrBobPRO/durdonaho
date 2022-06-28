<footer class="footer">
    <div class="footer__inner main-container">
        <div class="footer__block">
            <a class="logo" href="{{ route('home') }}">
                <img class="logo__image" src="{{ asset('img/main/logo.svg') }}" alt="Дурдонаҳо лого">
            </a>
        </div>

        <div class="footer__block">
            <p>© 2017 - 2021 — ДУРДУРНАҲО</p>
            <p>Ҳамаи ҳуқуқ маҳфуз аст</p>
        </div>

        <div class="footer__block">
            <p><a href="{{ route('privacy-policy') }}">Сиёсати махрамият</a></p>
            <p><a href="{{ route('terms-of-use') }}">Ахдномаи истифодабари</a></p>
        </div>

        {{-- <div class="footer__block footer__socials">
            <div class="footer__socials-text">
                <p>Моро мутолиа</p>
                <p>намоед:</p>
            </div>

            <div class="footer__socials-container">
                <a class="footer__socials-link" href="#">
                    @include('svgs.twitter')
                </a>
        
                <a class="footer__socials-link" href="#">
                    @include('svgs.telegram')
                </a>
        
                <a class="footer__socials-link" href="#">
                    @include('svgs.facebook')
                </a>
        
                <a class="footer__socials-link" href="#">
                    @include('svgs.instagram')
                </a>
            </div>
        </div> --}}
    </div>
</footer>