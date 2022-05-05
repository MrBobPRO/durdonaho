<!DOCTYPE html>
<html lang="tj">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@hasSection('title')@yield('title'){{ ' – Дурдонаҳо' }}@else{{'Дурдонаҳо'}}@endif</title>

        <meta name="robots" content="none"/>
        <meta name="googlebot" content="noindex, nofollow"/>
        <meta name="yandex" content="none"/>

        <meta name="keywords" content="Дурдонаҳо, Иқтибосҳо ва афоризмҳо, Муаллифони машҳур, Иқтибосҳои маъмул, цитаты и афоризмы"/>
        <meta property="og:site_name" content="Дурдонаҳо">
        <meta property="og:type" content="object" />
        <meta name="twitter:card" content="summary_large_image">

        @hasSection ('meta-tags')
            @yield('meta-tags')
        @else
            <meta name="description" content="Сомонаи мазкур “Дурдонаҳо” номдошта, асоси онро  иқтибосҳо аз китобҳои сатҳи ҷаҳонӣ, суханрониҳои афроди муваффақ ва афоризмҳои файласуфону равоншиносону...">
            <meta property="og:title" content="Дурдонаҳо" />
            <meta property="og:description" content="Сомонаи мазкур “Дурдонаҳо” номдошта, асоси онро  иқтибосҳо аз китобҳои сатҳи ҷаҳонӣ, суханрониҳои афроди муваффақ ва афоризмҳои файласуфону равоншиносону...">
            <meta property="og:image" content="{{ asset('img/main/logo-share.png') }}">
            <meta property="og:image:alt" content="Дурдонаҳо – Лого">
        @endif

        {{-- Favicons for all devices --}}
        <link rel="icon" href="{{ asset('img/main/cropped-favi-32x32.ico') }}" sizes="32x32">
        <link rel="icon" href="{{ asset('img/main/cropped-favi-192x192.ico') }}" sizes="192x192">
        <link rel="apple-touch-icon-precomposed" href="{{ asset('img/main/cropped-favi-180x180.ico') }}">
        <meta name="msapplication-TileImage" content="{{ asset('img/main/cropped-favi-270x270.ico') }}">

        {{-- Raleway Google Fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">

        {{-- Material Icons --}}
        <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined" rel="stylesheet">

        {{-- Owl Carousel --}}
        <link rel="stylesheet" href="{{ asset('js/plugins/owl-carousel/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('js/plugins/owl-carousel/owl.theme.default.min.css') }}">

        {{-- Selectize --}}
        <link href="{{ asset('js/plugins/selectize/dist/css/selectize.css') }}" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('css/full/main.css') }}">
    </head>
    
    <body>
        @include('layouts.header')
        <main class="main" role="main">
            @yield('main')
            
            @include('modals.login')
            @include('modals.register')
            @include('modals.forgot-password')

            @auth
                @include('modals.report-bug')
            @endauth
            
            <div class="spinner" id="spinner"><span class="spinner__icon"></span></div>
        </main>
        @include('layouts.footer')
        
        {{-- JQuery --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

        {{-- Owl Carousel --}}
        <script src="{{ asset('js/plugins/owl-carousel/owl.carousel.min.js') }}"></script>

        {{-- Yandex share buttons --}}
        <script src="https://yastatic.net/share2/share.js"></script>

        {{-- Selectize --}}
        <script src="{{ asset('js/plugins/selectize/dist/js/standalone/selectize.min.js') }}"></script>

        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
