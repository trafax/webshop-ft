<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-81032033-1', 'auto');
        ga('send', 'pageview');
        gtag('config', 'AW-877666406');
        @yield('js-head')
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
    </style>


<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/a43609110c4d794a6bc591c19/f86640d5ac714ed4e1abd6b48.js");</script>


</head>
<body>

    @section('popup')
        @if (setting('show_popup'))
            <div class="website-popup" style="{!! setting('popup-bg') ? 'background-color: ' . setting('popup-bg') : '' !!}">
                {!! t('settings', 'popup_content', '', setting('popup_content')) !!}
            </div>
        @endif
    @show

    <div class="header border-bottom">

        <div class="container">
            <div class="d-flex px-3">
                <div class="ml-auto">

                    <a href="{{ route('cart') }}" class="nav-shopping-cart mr-2"><i class="fas fa-shopping-cart"></i> ({{ Gloudemans\Shoppingcart\Facades\Cart::count() }})</a>

                    <div class="dropdown d-inline language-selector">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa{{ Auth::user() ? 's' : 'r' }} fa-user nav-shopping-cart"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            @if (Auth::user())
                                <a href="{{ route('customer.edit') }}" class="dropdown-item">{!! it('my-details', 'Mijn gegevens') !!}</a>
                                <a href="{{ route('order.index') }}" class="dropdown-item">{!! it('my-orders', 'Mijn bestellingen') !!}</a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('customer.logout') }}" class="dropdown-item">{!! it('logout', 'Uitloggen') !!}</a>
                            @else
                                <a href="{{ route('customer') }}" class="dropdown-item">{!! it('login', 'Inloggen') !!}</a>
                            @endif
                        </div>
                    </div>

                    <div class="dropdown d-inline language-selector">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @php $active_language = \App\Models\Language::where('language_key', config('app.locale'))->first(); @endphp
                            <img src="{{ asset('img/flags/'.strtoupper($active_language->language_key).'.png') }}">{{ t($active_language, 'title') }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            @foreach (\App\Models\Language::orderBy('sort')->get() as $language)
                                @if (config('app.locale') != $language->language_key)
                                    <a class="dropdown-item" href="/language/set/{{ $language->id }}"><img src="{{ asset('img/flags/'.strtoupper($language->language_key).'.png') }}"> {{ t($language, 'title') }}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="m-0">

        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent">
                <a class="navbar-brand" href="{{ route('homepage') }}"><img src="/img/floratuin.png" alt="Floratuin" class="logo"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="{{ route('homepage') }}" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('webshop') }}" class="nav-link">Webshop</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown_voorjaar" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{!! it('dropdown-spring', 'Voorjaar') !!}</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown_voorjaar">
                                @foreach(App\Models\Category::where('season', 0)->where('visible', 1)->orderBy('_lft')->get() as $dropdown_category)
                                    <a class="dropdown-item" href="{{ route('category', $dropdown_category->slug) }}">{{ t($dropdown_category, 'title') }}</a>
                                @endforeach
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown_zomer" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{!! it('dropdown-zomer', 'Zomer') !!}</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown_zomer">
                                @foreach(App\Models\Category::where('season', 1)->where('visible', 1)->orderBy('_lft')->get() as $dropdown_category)
                                    <a class="dropdown-item" href="{{ route('category', $dropdown_category->slug) }}">{{ t($dropdown_category, 'title') }}</a>
                                @endforeach
                            </div>
                        </li>
                        @foreach ($menu_items as $menu_item)
                            <li class="nav-item {{ $menu_item->children()->count() > 0 ? 'dropdown' : '' }}">
                                @if ($menu_item->children()->count() > 0)
                                    <a class="nav-link dropdown-toggle" href="#" id="dropdown_{{ $menu_item->id }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ t($menu_item, 'title') }}</a>
                                    <div class="dropdown-menu" aria-labelledby="dropdown_{{ $menu_item->id }}">
                                        @foreach ($menu_item->children as $child)
                                            <a class="dropdown-item" href="{{ route('page', $child->slug) }}">{{ t($child, 'title') }}</a>
                                        @endforeach
                                    </div>
                                @else
                                    <a class="nav-link" href="{{ route('page', $menu_item->slug) }}">{{ t($menu_item, 'title') }}</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    @yield('content')

    <div class="footer">
        <div class="contact-details py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 d-md-flex text-center text-lg-left mb-4 mb-md-0">
                        <div class="mr-md-4"><i class="fas fa-phone-square-alt"></i></div>
                        <div>
                            <span class="font-weight-bold">{!! it('footer-telephone', 'Telefoonnummer') !!}</span><br>
                            {!! it('footer-telephone-value', '+316-10694149') !!}
                        </div>
                    </div>
                    <div class="col-md-4 d-md-flex text-center text-lg-left mb-4 mb-md-0">
                        <div class="mr-md-4"><i class="fas fa-envelope-square"></i></div>
                        <div>
                            <span class="font-weight-bold">{!! it('footer-email', 'E-mailadres') !!}</span><br>
                            {!! it('footer-email-value', 'info@floratuin.com') !!}
                        </div>
                    </div>
                    <div class="col-md-4 d-md-flex text-center text-lg-left">
                        <div class="mr-md-4"><i class="fas fa-map-marked-alt"></i></div>
                        <div>
                            <span class="font-weight-bold">{!! it('footer-location', 'Locatie') !!}</span><br>
                            {!! it('footer-location-value', 'Rijksweg 85, 1787 PK Julianadorp') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright py-4">
            <div class="container">
                <div class="row">
                    <div class="col d-flex">
                        <div>&copy; {{ date('Y') }} - <a href="https://vanspelden.nl/">van Spelden IT solutions</a></div>
                        <div class="ml-auto">
                            <a href="{{ route('page', 'disclaimer') }}">{!! it('footer-disclaimer','Disclaimer') !!}</a> |
                            <a href="{{ route('page', 'privacy-verklaring') }}">{!! it('footer-privacy', 'Privacy verklaring') !!}</a> |
                            <a href="{{ route('page', 'contact') }}">{!! it('footer-contact', 'Contact') !!}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('modal'))
        <div class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{!! session('modal')['title'] !!}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{!! session('modal')['content'] !!}</p>
                </div>
                <div class="modal-footer">
                    {!! session('modal')['buttons'] !!}
                </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function(){
                $('.modal').modal('show');
            });
        </script>
    @endif
</body>
</html>
