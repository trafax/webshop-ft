<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ mix('css/admin.css') }}" rel="stylesheet">
    <script src="{{ mix('js/admin.js') }}" type="text/javascript"></script>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">

                </ul>
                <ul class="navbar-nav ml-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.page.index') }}">Pagina's</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Webwinkel <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('admin.overview') }}">Overzicht</a>
                                <a class="dropdown-item" href="{{ route('admin.category.index') }}">Categorieën</a>
                                <a class="dropdown-item" href="{{ route('admin.product.season', ['null', '0']) }}">Voorjaars producten</a>
                                <a class="dropdown-item" href="{{ route('admin.product.season', ['null', '1']) }}">Zomer producten</a>
                                <a class="dropdown-item" href="{{ route('admin.order.index') }}">Bestellingen</a>
                                <a class="dropdown-item" href="{{ route('admin.customer.index') }}">Klanten</a>
                                <a class="dropdown-item" href="{{ route('admin.variation.index') }}">Variaties</a>
                                <a class="dropdown-item" href="{{ route('admin.country.index') }}">Landen</a>
                                <a class="dropdown-item" href="{{ route('admin.shipping.index') }}">Verzendkosten</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.form.index') }}">Formulieren</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.gallery.index') }}">Fotoalbums</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Instellingen <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('admin.setting.index') }}">Standaard instellingen</a>
                                <a class="dropdown-item" href="{{ route('admin.emailTemplate.index') }}">E-mail templates</a>
                                <a class="dropdown-item" href="{{ route('admin.language.index') }}">Talen</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->firstname }} {{ Auth::user()->preposition }} {{ Auth::user()->lastname }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @yield('content')
    </main>
</body>
</html>
