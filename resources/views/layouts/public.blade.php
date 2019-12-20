<!doctype html>
<html lang="en">
    <head>
        <!--====== Required meta tags ======-->
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="author" content="Ayro UI">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!--====== Title ======-->
        <title>{{ ($wtitle ?? 'SIAJI').(!empty($wsecond_title) ? ': '.$wsecond_title : '' ) }}</title>
        <!--====== Favicon Icon ======-->
        <link rel="shortcut icon" href="{{ asset('ayro-ui/images/favicon.ico') }}" type="image/png">
        <!--====== Bootstrap css ======-->
        <link rel="stylesheet" href="{{ asset('ayro-ui/css/bootstrap.min.css') }}">
        <!--====== Line Icons css ======-->
        <link rel="stylesheet" href="{{ asset('ayro-ui/css/LineIcons.css') }}">
        <!--====== Default css ======-->
        <link rel="stylesheet" href="{{ asset('ayro-ui/css/default.css') }}">
        <!--====== Style css ======-->
        <link rel="stylesheet" href="{{ asset('ayro-ui/css/style.css') }}">

        @yield('plugins_css')
        @yield('inline_css')
    </head>
    <body>
        @yield('content')

        <!--====== jquery js ======-->
        <script src="{{ asset('ayro-ui/js/vendor/modernizr-3.6.0.min.js') }}"></script>
        <script src="{{ asset('ayro-ui/js/vendor/jquery-1.12.4.min.js') }}"></script>
        <!--====== Bootstrap js ======-->
        <script src="{{ asset('ayro-ui/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('ayro-ui/js/popper.min.js') }}"></script>
        <!--====== Images Loaded js ======-->
        <script src="{{ asset('ayro-ui/js/imagesloaded.pkgd.min.js') }}"></script>
        <!--====== Appear js ======-->
        <script src="{{ asset('ayro-ui/js/jquery.appear.min.js') }}"></script>
        <!--====== Main js ======-->
        <script src="{{ asset('ayro-ui/js/main.js') }}"></script>

        @yield('plugins_js')
        @yield('inline_js')
    </body>
</html>