@extends('layouts.public', [
    'wsecond_title' => 'List Panti'
])

@section('plugins_css')
<!-- Select2 -->
<link rel="stylesheet" href="{{ mix('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ mix('fancy/css/others/select2/select2.css') }}">
<link rel="stylesheet" href="{{ mix('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
@include('layouts.partials.public.content-header', [
    'page_title' => 'List Panti',
    'breadcrumb' => [
        [
            'breadcrumb_title' => 'Panti',
            'is_active' => true,
            'url' => null,
            'breadcrumb_icon' => null
        ]
    ]
])

<section class="section-padding-100 container" id="panti-area">
    <div class="row">
        <div class="col-12 col-md-4">
            @include('content.public.panti.partials.filter')
        </div>
        <div class="col-12 col-md-8">
            @include('content.public.panti.partials.panti')
        </div>
    </div>
</section>
@endsection

@section('plugins_js')
<!-- Select2 -->
<script src="{{ mix('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        $('.select2').select2();

        checkProvince();
    });

    function checkProvince(){
        console.log('Check Province is running...');
        let province = $("#field-provinsi_id").val();
        let kabupaten = $("#field-kabupaten_id");
        let panti_submit = $("#panti-submit");

        kabupaten.empty();
        let arr = {
            id: 'all',
            text: 'All'
        };
        var newOption = new Option(arr.text, arr.id, true, true);
        kabupaten.append(newOption).trigger('change');
        panti_submit.text('Please wait...').attr('disabled', true);

        if(province != 'all'){
            $.get("{{ url('json/provinsi') }}/"+province+"/kabupaten", function(result){
                // console.log(result);
                let data = result.data;
                $.each(data, function(key, data){
                    let arr = {
                        id: data.id,
                        text: data.kabupaten_name
                    };

                    if("{{ !empty($kabupaten) }}" == "1"){
                        if("{{ !empty($kabupaten) ? $kabupaten->id : '' }}" == data.id){
                            var newOption = new Option(arr.text, arr.id, false, true);
                        } else {
                            var newOption = new Option(arr.text, arr.id, false, false);
                        }
                    } else {
                        var newOption = new Option(arr.text, arr.id, false, false);
                    }
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

        kecamatan.empty();
        let arr = {
            id: 'all',
            text: 'All'
        };

        var newOption = new Option(arr.text, arr.id, true, true);
        kecamatan.append(newOption).trigger('change');
        panti_submit.text('Please wait...').attr('disabled', true);

        if(province != 'all' && kabupaten != 'all'){
            $.get("{{ url('json/kabupaten') }}/"+kabupaten+"/kecamatan", function(result){
                console.log(result);
                let data = result.data;
                $.each(data, function(key, data){
                    let arr = {
                        id: data.id,
                        text: data.kecamatan_name
                    };

                    if("{{ !empty($kecamatan) }}" == "1"){
                        if("{{ !empty($kecamatan) ? $kecamatan->id : '' }}" == data.id){
                            var newOption = new Option(arr.text, arr.id, false, true);
                        } else {
                            var newOption = new Option(arr.text, arr.id, false, false);
                        }
                    } else {
                        var newOption = new Option(arr.text, arr.id, false, false);
                    }
                    kecamatan.append(newOption).trigger('change');
                });

                kecamatan.attr('disabled', false);
            }).always(function(){
                panti_submit.text('Submit').attr('disabled', false);
            });
        } else {
            panti_submit.text('Submit').attr('disabled', false);
            kecamatan.attr('disabled', true);
        }
    }
</script>
@endsection