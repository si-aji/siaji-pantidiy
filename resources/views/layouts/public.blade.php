<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Fancy - Creative Agency Template</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('fancy/img/core-img/favicon.ico') }}">

    <!-- Core Stylesheet -->
    <link href="{{ mix('fancy/css/style.css') }}" rel="stylesheet">

    <!-- Responsive CSS -->
    <link href="{{ mix('fancy/css/responsive/responsive.css') }}" rel="stylesheet">

</head>

<body>
    <!-- Preloader Start -->
    @include('layouts.partials.public.preload')

    <!-- Search Form Area -->
    @include('layouts.partials.public.search')

    <!-- ***** Header Area Start ***** -->
    @include('layouts.partials.public.navbar')
    <!-- ***** Header Area End ***** -->

    @yield('content')

    <!-- ***** Footer Area Start ***** -->
    @include('layouts.partials.public.footer')
    <!-- ***** Footer Area End ***** -->

    <!-- jQuery-2.2.4 js -->
    <script src="{{ mix('fancy/js/jquery/jquery-2.2.4.min.js') }}"></script>
    <!-- Popper js -->
    <script src="{{ mix('fancy/js/bootstrap/popper.min.js') }}"></script>
    <!-- Bootstrap-4 js -->
    <script src="{{ mix('fancy/js/bootstrap/bootstrap.min.js') }}"></script>
    <!-- All Plugins js -->
    <script src="{{ mix('fancy/js/others/plugins.js') }}"></script>
    <!-- Active JS -->
    <script src="{{ mix('fancy/js/active.js') }}"></script>
</body>