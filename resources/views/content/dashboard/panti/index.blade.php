@extends('layouts.dashboard', [
    'wsecond_title' => 'Panti',
    'menu' => 'panti',
    'sub_menu' => null,
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Panti',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => '#',
                'text' => 'Panti',
                'active' => true
            ]
        ]
    ]
])

@section('plugins_css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">

<!-- Select2 -->
<link rel="stylesheet" href="{{ mix('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ mix('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-3">
        <div class="card">
            <div class="card-header card-secondary card-outline">
                <h1 class="card-title">Filter</h1>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="filter_showall" value="all" onchange="checkFilter();" checked>
                        <label class="custom-control-label" for="filter_showall">Show All</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Provinsi</label>
                    <select class="form-control select2" name="provinsi_id" id="field-lprovinsi_id" onchange="checkProvince();" disabled>
                        <option value="none" >- Pilih Provinsi -</option>
                        @foreach($province as $item)
                        <option value="{{ $item->id }}">{{ $item->provinsi_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="field-lkabupaten_id">Kabupaten</label>
                    <select class="form-control select2" name="kabupaten_id" id="field-lkabupaten_id" disabled onchange="checkKabupaten()">
                        <option value="none" selected>- Pilih Kabupaten -</option>
                    </select>
                </div>
    
                <div class="form-group">
                    <label for="field-lkecamatan_id">Kecamatan</label>
                    <select class="form-control select2" name="kecamatan_id" id="field-lkecamatan_id" disabled>
                        <option value="none" selected>- Pilih Kecamatan -</option>
                    </select>
                </div>

                <div class="form-group">
                    <div class="offset-sm-2 text-right text-md-right">
                        <button type="reset" id="btn-field_reset" class="btn btn-sm btn-danger">Reset</button>
                        <button type="submit" class="btn btn-sm btn-primary" onclick="$('#panti_table').DataTable().ajax.reload();">Apply</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-9">
        <div class="card">
            <div class="card-header card-primary card-outline">
                <h1 class="card-title">List Panti</h1>
                <div class="card-tools">
                    <a href="{{ route('dashboard.panti.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover table-striped" id="panti_table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('plugins_js')
<script src="{{ mix('adminlte/js/siaji.js') }}"></script>

<!-- Datatable -->
<script src="{{ mix('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ mix('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<!-- Select2 -->
<script src="{{ mix('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        $('.select2').select2();
    });

    let panti_table = $("#panti_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('dashboard.json.datatable.panti.all') }}",
            type: "GET",
            data: function(d){
                console.log(d);
                let filter_show = null;
                if($("#filter_showall").is(':checked')){
                    filter_show = 'all';
                } else {
                    filter_show = 'filtered';
                }

                d.filter = filter_show;
                d.provinsi = $("#field-lprovinsi_id").val();
                d.kabupaten = $("#field-lkabupaten_id").val();
                d.kecamatan = $("#field-lkecamatan_id").val();
            }
        },
        success: function (result) {
            console.log(result);
        },
        columns: [
            { "data": "panti_name" },
            { "data": "created_at" },
            { "data": "updated_at" },
            { "data": "" }
        ],
        columnDefs: [
            {
                "targets": 3,
                "searchable": false,
                "sortable": false,
                "render": function(row, type, data){
                    // console.log(row);
                    return "<div class='btn-group'>"
                        +"<a href='{{ route('dashboard.panti.index') }}/"+data.panti_slug+"/edit' class='btn btn-caction btn-warning btn-sm'><i class='far fa-edit'></i></a>"
                        +"<a href='{{ route('dashboard.panti.index') }}/"+data.panti_slug+"' class='btn btn-caction btn-info btn-sm'><i class='far fa-eye'></i></a>"
                    +"</div>"
                }
            }
        ],
    });

    function checkFilter(){
        let filter_checkbox = $("#filter_showall");
        let province_id = $("#field-lprovinsi_id");

        if(filter_checkbox.is(':checked')){
            province_id.val('none').trigger('change');
            province_id.attr('disabled', true);
        } else {
            province_id.attr('disabled', false);
        }
    }

    function checkProvince(){
        console.log('Check Province is running...');
        let province = $("#field-lprovinsi_id").val();
        let kabupaten = $("#field-lkabupaten_id");

        kabupaten.empty();
        let arr = {
            id: 'none',
            text: '- Pilih Kabupaten -'
        };

        var newOption = new Option(arr.text, arr.id, true, true);
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

                    var newOption = new Option(arr.text, arr.id, false, false);
                    kabupaten.append(newOption);
                });

                kabupaten.attr('disabled', false);
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

        var newOption = new Option(arr.text, arr.id, true, true);
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

                    var newOption = new Option(arr.text, arr.id, false, false);
                    kecamatan.append(newOption);
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

        $("#field-lprovinsi_id").val('none').trigger('change');
    });
</script>
@endsection