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
    <link href="{{ mix('fancy/css/siaji.css') }}" rel="stylesheet">
    <!-- Responsive CSS -->
    <link href="{{ mix('fancy/css/responsive/responsive.css') }}" rel="stylesheet">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ mix('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ mix('fancy/css/others/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ mix('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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

    <!-- Select2 -->
    <script src="{{ mix('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function(){
            $('.select2').select2();
        });

        function checkProvince(){
            // console.log('Check Province is running...');
            let province = $("#field-provinsi_id").val();
            let kabupaten = $("#field-kabupaten_id");
            let panti_submit = $("#panti-submit");

            panti_submit.text('Please wait...').attr('disabled', true);
            kabupaten.empty();
            let arr = {
                id: 'all',
                text: 'All'
            };
            var newOption = new Option(arr.text, arr.id, true, true);
            kabupaten.append(newOption).trigger('change');

            if(province != 'all'){
                $.get("{{ url('json/provinsi') }}/"+province+"/kabupaten", function(result){
                    // console.log(result);
                    let data = result.data;
                    $.each(data, function(key, data){
                        let arr = {
                            id: data.id,
                            text: data.kabupaten_name
                        };

                        var newOption = new Option(arr.text, arr.id, false, false);
                        kabupaten.append(newOption);
                    });

                    kabupaten.attr('disabled', false).trigger('change');
                }).always(function(){
                    panti_submit.text('Submit').attr('disabled', false);
                });
            } else {
                kabupaten.attr('disabled', true);
                panti_submit.text('Submit').attr('disabled', false);
            }
        }
        function checkKabupaten(){
            // console.log('Check Kabupaten is running...');
            let province = $("#field-provinsi_id").val();
            let kabupaten = $("#field-kabupaten_id").val();
            let kecamatan = $("#field-kecamatan_id");
            let panti_submit = $("#panti-submit");

            panti_submit.text('Please wait...').attr('disabled', true);
            kecamatan.empty();
            let arr = {
                id: 'all',
                text: 'All'
            };

            var newOption = new Option(arr.text, arr.id, true, true);
            kecamatan.append(newOption).trigger('change');

            if(province != 'all' && kabupaten != 'all'){
                $.get("{{ url('json/kabupaten') }}/"+kabupaten+"/kecamatan", function(result){
                    console.log(result);
                    let data = result.data;
                    $.each(data, function(key, data){
                        let arr = {
                            id: data.id,
                            text: data.kecamatan_name
                        };

                        var newOption = new Option(arr.text, arr.id, false, false);
                        kecamatan.append(newOption).trigger('change');
                    });

                    kecamatan.attr('disabled', false);
                }).always(function(){
                    panti_submit.text('Submit').attr('disabled', false);
                });
            } else {
                if(province == "all"){
                    panti_submit.text('Submit').attr('disabled', false);
                }
                kecamatan.attr('disabled', true);
            }
        }
    </script>
</body>