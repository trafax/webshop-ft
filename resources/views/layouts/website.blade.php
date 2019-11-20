<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
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
</head>
<body>
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
                    <div class="col d-flex">
                        <div> <i class="fas fa-phone-square-alt"></i></div>
                        <div>
                            Telefoonnummer<br>
                            +316-10694149
                        </div>
                    </div>
                    <div class="col d-flex">
                        <div><i class="fas fa-envelope-square"></i></div>
                        <div>
                            E-mailadres<br>
                            info@floratuin.com
                        </div>
                    </div>
                    <div class="col d-flex">
                        <div><i class="fas fa-map-marked-alt"></i></div>
                        <div>
                            Locatie<br>
                            Rijksweg 85, 1787 PK Julianadorp
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
                            <a href="{{ route('page', 'disclaimer') }}">Disclaimer</a> |
                            <a href="{{ route('page', 'contact') }}">Contact</a>
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
