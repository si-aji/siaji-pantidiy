<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ $wtitle ?? 'SIAJI' }}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="description" content="{{ $wdesc ?? 'SIAJI Basic CMS' }}">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ mix('adminlte/plugins/fontawesome-free/css/all.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ mix('adminlte/css/adminlte.css') }}">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        
        @yield('plugins_css')
        @yield('inline_css')
    </head>
    <body class="hold-transition {{ $extra_class ?? '' }}">
        
        @yield('content')

        <!-- jQuery -->
        <script src="{{ mix('adminlte/plugins/jquery/jquery.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ mix('adminlte/plugins/bootstrap/js/bootstrap.bundle.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ mix('adminlte/js/adminlte.js') }}"></script>

        @yield('plugins_js')
        @yield('inline_js')
    </body>
</html>