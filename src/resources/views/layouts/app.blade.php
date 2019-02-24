<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, maximum-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'HGA') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" />
    @env('production')
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-{{ env('GOOGLE_ANALYTICS_ID') }}-1"></script>
        <script type="application/javascript">
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());
            gtag('config', 'UA-{{ env('GOOGLE_ANALYTICS_ID') }}-1');
            @if(auth()->check())
                gtag('set', { 'user_id': {{ auth()->id() }} });
            @endif
        </script>
    @endenv
</head>
<body>
    <div id="app">
        @include('layouts.blocks.header')

        <main>
            @yield('content')
        </main>

        @include('layouts.blocks.footer')
    </div>
    <script src="{{ mix('js/manifest.js') }}" defer></script>
    <script src="{{ mix('js/vendor.js') }}" defer></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
