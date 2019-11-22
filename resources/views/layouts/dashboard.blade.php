
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ ($wtitle ?? 'SIAJI').(!empty($wsecond_title) ? ': '.$wsecond_title : '' ) }}</title>
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
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{ mix('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.css') }}">
        
        @yield('plugins_css')
        @yield('inline_css')
    </head>
    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
        <div class="wrapper">

            {{-- Navbar --}}
            @include('layouts.partials.dashboard.navbar')

            {{-- Sidebar --}}
            @include('layouts.partials.dashboard.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @if(!empty($content_header))
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">{{ $content_header['title'] }}</h1>
                            </div><!-- /.col -->
                            @if(!empty($content_header['breadcrumb']))
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    @foreach ($content_header['breadcrumb'] as $br)
                                    @if(empty($br['active']))
                                    <li class="breadcrumb-item"><a href="{{ $br['url'] }}">{{ $br['text'] }}</a></li>
                                    @else
                                    <li class="breadcrumb-item active">{{ $br['text'] }}</li>
                                    @endif
                                    @endforeach
                                </ol>
                            </div><!-- /.col -->
                            @endif
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
                @endif

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="alert_section" id="alert_section">
                            @if(Session::get('message'))
                            <blockquote class="mx-0 mt-0">
                                <p>Action: {{ Session::get('action') }}</p>
                                <small>Message: {{ Session::get('message') }}</small>
                            </blockquote>
                            @endif
                        </div>

                        @yield('content')
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            {{-- Footer --}}
            @include('layouts.partials.dashboard.footer')

            {{-- Control --}}
            @include('layouts.partials.dashboard.control')
        </div>
        <!-- ./wrapper -->
        @yield('content_modal')

        <!-- jQuery -->
        <script src="{{ mix('adminlte/plugins/jquery/jquery.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ mix('adminlte/plugins/bootstrap/js/bootstrap.bundle.js') }}"></script>
        <!-- overlayScrollbars -->
        <script src="{{ mix('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ mix('adminlte/js/adminlte.js') }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
        @yield('plugins_js')
        
        <script>
            $.ajaxSetup({ {{-- Set csrf token for every ajax request --}}
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });
            $(document).ajaxSend(function(event, request, setting){
                $("#alert_section").empty();
            });
        </script>
        @yield('inline_js')
    </body>
</html>
