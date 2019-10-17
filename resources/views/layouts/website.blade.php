<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
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
                                <a href="{{ route('customer.edit') }}" class="dropdown-item">Mijn gegevens</a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('customer.logout') }}" class="dropdown-item">Uitloggen</a>
                            @else
                                <a href="{{ route('customer') }}" class="dropdown-item">Inloggen</a>
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
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('homepage') }}">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('webshop') }}">Webshop</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Pricing</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dropdown link
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    @yield('content')

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
