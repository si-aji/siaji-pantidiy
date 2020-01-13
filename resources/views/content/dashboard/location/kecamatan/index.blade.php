@extends('layouts.dashboard', [
    'wsecond_title' => 'Kecamatan',
    'menu' => 'location',
    'sub_menu' => 'kecamatan',
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Kabupaten',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => '#',
                'text' => 'Kecamatan',
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
<div class="card">
    <div class="card-header card-primary card-outline">
        <h1 class="card-title">List Kecamatan</h1>
        <div class="card-tools">
            <button type="button" data-toggle="modal" id="subdistrictButton" data-target="#subdistrictModal" class="btn btn-primary btn-sm" disabled>
                <i class="fas fa-plus"></i> Add New
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <select class="form-control select2" name="lkabupaten_id" id="lkabupaten_id" onchange="updateTable();">
                <option value="none" selected>- Pilih Kabupaten -</option>
                
                @foreach($provinsi as $item)
                <optgroup label="{{ $item->provinsi_name }}">
                    @foreach($item->kabupaten as $kabupaten)
                    <option value="{{ $kabupaten->id }}">{{ $kabupaten->kabupaten_name }}</option>
                    @endforeach
                </optgroup>
                @endforeach
            </select>
        </div>

        <table class="table table-bordered table-hover table-striped" id="subdistrict_table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('content_modal')
<form method="POST" action="{{ route('dashboard.kecamatan.index') }}" class="modal fade" tabindex="-1" role="dialog" id="subdistrictModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Kecamatan (Insert)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                <input type="hidden" name="_method" id="_method" value="POST">

                <div class="form-group" id="form-provinsi_name">
                    <label>Provinsi{!! printRequired() !!}</label>
                    <input type="text" class="form-control" id="field-provinsi_name" readonly>
                </div>

                <div class="form-group" id="form-kabupaten_id">
                    <label>Kabupaten{!! printRequired() !!}</label>
                    <input type="hidden" name="kabupaten_id" id="field-kabupaten_id">
                    <input type="text" class="form-control" id="field-kabupaten_name" readonly>
                </div>

                <div class="form-group" id="form-kecamatan_name">
                    <label>Name</label>
                    <input type="text" name="kecamatan_name" id="field-kecamatan_name" class="form-control" placeholder="Kecamatan Name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btn_reset" class="btn btn-sm btn-danger" onclick="formReset();">Reset</button>
                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('plugins_js')
<script src="{{ mix('adminlte/js/siaji.js') }}"></script>

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

    let subdistrict_table = $("#subdistrict_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('dashboard.json.datatable.kecamatan.all') }}",
            type: "GET",
            data: function(d){
                d.kabupaten = $("#lkabupaten_id").val()
            }
        },
        success: function (result) {
            console.log(result);
        },
        columns: [
            { "data": "kecamatan_name" },
            { "data": "" }
        ],
        columnDefs: [
            {
                "targets": 1,
                "searchable": false,
                "sortable": false,
                "render": function(row, type, data){
                    // console.log(row);
                    return "<div class='btn-group'>"
                        +"<button type='button' onclick='actionEdit("+data.id+")' class='btn btn-caction btn-warning btn-sm'><i class='far fa-edit'></i></button>"
                        +"<button type='button' class='btn btn-caction btn-info btn-sm'><i class='far fa-eye'></i></button>"
                    +"</div>"
                }
            }
        ]
    });

    function updateTable(){
        console.log("Update Table");

        if($("#lkabupaten_id").val() != "none"){
            $("#subdistrictButton").attr('disabled', false);
            $("#field-provinsi_name").val($("#lkabupaten_id option:selected").parent().attr('label'));
            $("#field-kabupaten_name").val($("#lkabupaten_id option:selected").text());
            $("#field-kabupaten_id").val($("#lkabupaten_id").val());
        } else {
            formReset();
            $("#subdistrictButton").attr('disabled', true);
        }

        $("#subdistrict_table").DataTable().ajax.reload();
    }

    $("#subdistrictModal").submit(function(e){
        e.preventDefault();
        console.log("Form is being submited...");
        removeInvalid();

        // Form Data
        let form_data = $(e.target).serialize();
        let target_url = $("#subdistrictModal").attr('action');
        console.log("Target : "+target_url);

        let el = $(this).closest('.modal');
        // el.addClass('modal-progress');

        $.post(target_url, form_data, function(result){
            console.log(result);
            $("#subdistrict_table").DataTable().ajax.reload();

            $('<blockquote class="mx-0 mt-0">'
                +'<button type="button" class="close as-close" aria-hidden="true">×</button>'
                +'<p>Action: '+result.action+'</p>'
                +'<small>Message: '+result.message+'</small>'
            +'</blockquote>').appendTo($('#alert_section'));

            $("#subdistrictModal").modal('hide');
        }).always(function(result){
            el.removeClass('modal-progress');
        }).fail(function(jqXHR, textStatus, errorThrown){
            console.log("Ajax Fail");
            console.log(jqXHR);
            $.each(jqXHR.responseJSON.errors, function(key, result){
                $("#field-"+key).addClass('is-invalid');
                $("#form-"+key).append("<div class='invalid-feedback'>"+result+"</div>");
            });
        });
    });
    $("#subdistrictModal").on('hide.bs.modal', function(){
        console.log("Modal is being hide");
        $("#btn_reset").click();
    });

    function formReset(){
        removeInvalid();

        $("#subdistrictModal").attr('action', "{{ route('dashboard.kecamatan.index') }}");
        $("#subdistrictModal .modal-title").text('Form Kecamatan (Insert)');

        if($("#lkabupaten_id").val() == "none"){
            $("#field-provinsi_name").val("");
            $("#field-kabupaten_id").val("");
            $("#field-kabupaten_name").val("");
        }

        $("#_method").val("POST");
        $("#field-kecamatan_name").val('');
    }

    function actionEdit(id){
        console.log("Edit Action is running... ID is : "+id);
        $(".btn-caction").attr('disabled', true);

        $.get("{{ route('dashboard.json.kecamatan.all') }}/"+id, function(result){
            console.log(result);
            let data = result.data;

            $("#subdistrictModal").attr('action', "{{ route('dashboard.kecamatan.index') }}/"+data.id);
            $("#subdistrictModal .modal-title").text('Form Kecamatan (Update)');

            $("#_method").val("PUT");
            $("#field-kecamatan_name").val(data.kecamatan_name);

            $("#subdistrictModal").modal("show");
        }).always(function(result){
            $(".btn-caction").attr('disabled', false);
        }).fail(function(jqXHR, textStatus, errorThrown){
            console.log("Ajax Fail");
            console.log(jqXHR);
        });
    }
</script>
@endsection