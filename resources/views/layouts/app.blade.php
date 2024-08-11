<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- OGP -->
        <meta property="og:title" content="@yield('title')" />
        <meta property="og:description" content="オセロ棋譜共有サイト" />
        <meta property="og:type" content="article">
        <meta property="og:url" content="https://waffleboard.net" />
        <meta property="og:image" content="https://waffleboard.net/images/ogp.png" />
        <meta property="og:site_name" content="わっふる" />

        <!-- Twitter -->
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:site" content="@board_waffle" />
        <meta name="twitter:domain" content="waffleboard.net" />
        <meta name="twitter:image" content="https://waffleboard.net/images/ogp.png" />
        <meta property="twitter:title" content="@yield('title')" />
        <meta name="twitter:description" content="オセロ棋譜共有サイト" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @stack('scripts')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-black text-white">
        <header id="header">
            @yield('header')
        </header>
        <div class="content" style="min-height: calc(100vh - 170px)">
            @yield('content')
        </div>
        <footer id="footer">
            @yield('footer')
        </footer>
    </body>
</html>
