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
    <div class="language-selector">
        <select name="language" onchange="window.location.href = '/' + this.value">
            @foreach (\App\Models\Language::orderBy('sort')->get() as $language)
                <option {{ config('app.locale') == $language->language_key ? 'selected' : '' }} value="{{ $language->is_default == 0 ? $language->language_key : '' }}">{{ t($language, 'title') }}</option>
            @endforeach
        </select>
    </div>
    @yield('content')
</body>
</html>
