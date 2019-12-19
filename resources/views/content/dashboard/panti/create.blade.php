@extends('layouts.dashboard', [
    'wsecond_title' => 'Panti - Create',
    'menu' => 'panti',
    'sub_menu' => null,
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Panti - Create',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => route('dashboard.panti.index'),
                'text' => 'Panti',
                'active' => false
            ], [
                'url' => '#',
                'text' => 'Create',
                'active' => true
            ]
        ]
    ]
])

@section('plugins_css')
<!-- Select2 -->
<link rel="stylesheet" href="{{ mix('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ mix('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<!-- Summernote -->
<link rel="stylesheet" href="{{ mix('adminlte/plugins/summernote/summernote-bs4.css') }}">
@endsection

@section('content')
<form class="card" action="{{ route('dashboard.panti.store') }}" method="POST">
    @csrf

    <div class="card-header card-primary card-outline">
        <h1 class="card-title">Add new Panti</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.panti.create') }}" class="btn btn-warning btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="field-panti_name">Panti Name</label>
            <input type="text" name="panti_name" id="field-panti_name" class="form-control @error('panti_name') is-invalid @enderror" placeholder="Panti Name" onkeyup="generateSlug('field-panti_name', 'field-panti_slug')" value="{{ old('panti_name') }}">
            
            @error('panti_name')
            <div class='invalid-feedback'>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="field-panti_slug">Panti Slug</label>
            <input type="text" name="panti_slug" id="field-panti_slug" class="form-control @error('panti_slug') is-invalid @enderror" placeholder="Panti Slug" value="{{ old('panti_slug') }}">
            
            @error('panti_name')
            <div class='invalid-feedback'>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="field-panti_address">Addess</label>
            <textarea name="panti_address" class="form-control @error('panti_slug') is-invalid @enderror" id="field-panti_address" placeholder="Panti Address">{{ old('panti_address') }}</textarea>
            
            @error('panti_address')
            <div class='invalid-feedback'>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group col-12 col-lg-4">
                <label for="field-lprovinsi_id">Provinsi</label>
                <select class="form-control select2 @error('provinsi_id') is-invalid @enderror" name="provinsi_id" id="field-lprovinsi_id" onchange="checkProvince();">
                    <option value="none" {{ old('provinsi_id') ? (old('provinsi_id') == 'none' ? 'selected' : '') : 'selected' }}>- Pilih Provinsi -</option>
                    
                    @foreach($province as $item)
                    <option value="{{ $item->id }}" {{ old('provinsi_id') == $item->id ? 'selected' : '' }}>{{ $item->provinsi_name }}</option>
                    @endforeach
                </select>
                @error('provinsi_id')
                <div class='invalid-feedback'>{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group col-12 col-lg-4">
                <label for="field-lkabupaten_id">Kabupaten</label>
                <select class="form-control select2 @error('kabupaten_id') is-invalid @enderror" name="kabupaten_id" id="field-lkabupaten_id" disabled onchange="checkKabupaten()">
                    <option value="none" selected>- Pilih Kabupaten -</option>
                </select>
                @error('kabupaten_id')
                <div class='invalid-feedback'>{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group col-12 col-lg-4">
                <label for="field-lkecamatan_id">Kecamatan</label>
                <select class="form-control select2 @error('kecamatan_id') is-invalid @enderror" name="kecamatan_id" id="field-lkecamatan_id" disabled>
                    <option value="none" selected>- Pilih Kecamatan -</option>
                </select>
                @error('kecamatan_id')
                <div class='invalid-feedback'>{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="field-panti_description">Description</label>
            <textarea name="panti_description" id="field-panti_description" class="form-control @error('panti_description') is-invalid @enderror" placeholder="Description about Panti"></textarea>
            @error('panti_description')
            <div class='invalid-feedback'>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10 text-right text-md-right">
                <button type="reset" id="btn-field_reset" class="btn btn-sm btn-danger">Reset</button>
                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('plugins_js')
<script src="{{ mix('adminlte/js/siaji.js') }}"></script>

<!-- Select2 -->
<script src="{{ mix('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ mix('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        console.log("Lama {{ old('kabupaten_id') }}");
        checkProvince();

        $('.select2').select2();
        $("#field-panti_description").summernote({
            'height': 170,
            'placeholder': 'Description about Panti',
        });
    });

    function checkProvince(){
        console.log('Check Province is running...');
        let province = $("#field-lprovinsi_id").val();
        let kabupaten = $("#field-lkabupaten_id");

        kabupaten.empty();
        let arr = {
            id: 'none',
            text: '- Pilih Kabupaten -'
        };

        var newOption = new Option(arr.text, arr.id, {{ old('kabupaten_id') ? 'false' : 'true' }}, {{ old('kabupaten_id') ? 'false' : 'true' }});
        kabupaten.append(newOption).trigger('change');

        if(province != 'none'){
            $.get("{{ url('json/provinsi') }}/"+province+"/kabupaten", function(result){
                // console.log(result);
                let data = result.data;
                $.each(data, function(key, data){
                    let arr = {
                        id: data.id,
                        text: data.kabupaten_name
                    };

                    if("{{ old('kabupaten_id') }}" != "none"){
                        if("{{ old('kabupaten_id') }}" == data.id){
                            console.log("Kabupaten Lama sama dengan id");
                            var newOption = new Option(arr.text, arr.id, false, true);
                        } else {
                            var newOption = new Option(arr.text, arr.id, false, false);
                        }
                    }

                    kabupaten.append(newOption);
                });

                kabupaten.attr('disabled', false).trigger('change');
            });
        } else {
            kabupaten.attr('disabled', true);
        }
    }

    function checkKabupaten(){
        console.log('Check Kabupaten is running...');
        let province = $("#field-lprovinsi_id").val();
        let kabupaten = $("#field-lkabupaten_id").val();
        let kecamatan = $("#field-lkecamatan_id");

        kecamatan.empty();
        let arr = {
            id: 'none',
            text: '- Pilih Kecamatan -'
        };

        var newOption = new Option(arr.text, arr.id, {{ old('kecamatan_id') ? 'false' : 'true' }}, {{ old('kecamatan_id') ? 'false' : 'true' }});
        kecamatan.append(newOption).trigger('change');

        if(province != 'none' && kabupaten != 'none'){
            $.get("{{ url('json/kabupaten') }}/"+kabupaten+"/kecamatan", function(result){
                console.log(result);
                let data = result.data;
                $.each(data, function(key, data){
                    let arr = {
                        id: data.id,
                        text: data.kecamatan_name
                    };

                    if("{{ old('kecamatan_id') }}" != "none"){
                        if("{{ old('kecamatan_id') }}" == data.id){
                            console.log("Kecamatan Lama sama dengan id");
                            var newOption = new Option(arr.text, arr.id, false, true);
                        } else {
                            var newOption = new Option(arr.text, arr.id, false, false);
                        }
                    }

                    kecamatan.append(newOption).trigger('change');
                });

                kecamatan.attr('disabled', false);
            });
        } else {
            kecamatan.attr('disabled', true);
        }
    }

    $("#btn-field_reset").click(function(e){
        e.preventDefault();
        console.log('Field is being reset');

        $("#field-panti_name").val('');
        $("#field-panti_slug").val('');
        $("#field-panti_address").val('');
        $("#field-lprovinsi_id").val('none').trigger('change');
        $("#field-panti_description").summernote('code', '');
    });
</script>
@endsection