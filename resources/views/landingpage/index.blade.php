<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-81032033-1', 'auto');
        ga('send', 'pageview');
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($seo) && $seo['title'] ? $seo['title'] . ' - ' . config('app.name', 'Laravel') : config('app.name', 'Laravel') }}</title>
    <meta name="keywords" content="{{ isset($seo) && $seo['keywords'] ? $seo['keywords'] : setting('seo_keywords') }}">
    <meta name="description" content="{{ isset($seo) && $seo['description'] ? $seo['description'] : setting('seo_description') }}">
    <meta property="og:title" content="{{ isset($seo) && $seo['title'] ? $seo['title'] . ' - ' . config('app.name', 'Laravel') : config('app.name', 'Laravel') }}" />
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <script src="{{ mix('js/website.js') }}" type="text/javascript"></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ mix('css/website.css') }}" rel="stylesheet">
    <style type="text/css">
        {!! setting('custom_css') !!}
        @if (setting('landing_bg') ?? '')
            body {
                background-image: url('{{ asset(setting('landing_bg')) }}');
                background-size: cover;
                background-position: center;
            }
        @endif
        .white-tr-bg {
            background: rgba(255,255,255,0.5);
        }
        .logo {
            width: 300px;
        }
        @media (max-width: 991px) {
            .logo {
                width: 200px;
            }
            .logo-container {
                margin-top: 50px;
            }
        }
        @media (min-width: 991px) {
            .align-center {
                align-self: center;
            }
        }
        .text-block a {
            background-color: #99bc3c;
            color: #fff;
            display: inline-block;
            font-weight: 400;
            text-align: center;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            padding: .375rem .75rem;
            font-size: .9rem;
            line-height: 1.6;
            border-radius: .25rem;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            text-decoration: none;
        }
    </style>
</head>
<body class="h-100">

<div class="container h-100">
    <div class="row h-100">
        <div class="col align-center">
            <div class="row mb-4 pb-4">
                <div class="col text-center logo-container">
                    <span class="white-tr-bg w-auto d-inline-block p-4"><a href=""><img src="/img/floratuin.png" alt="Floratuin" class="logo"></a></span>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 mb-4">
                    <div class="white-tr-bg p-2 px-3 text-block">{!! it('landing_block_a', 'Een tekst', true) !!}</div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="white-tr-bg p-2 px-3 text-block">{!! it('landing_block_b', 'Een tekst', true) !!}</div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
