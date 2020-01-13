@extends('layouts.dashboard', [
    'wsecond_title' => 'Provinsi',
    'menu' => 'location',
    'sub_menu' => 'provinsi',
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Provinsi',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => '#',
                'text' => 'Provinsi',
                'active' => true
            ]
        ]
    ]
])

@section('plugins_css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
@endsection

@section('content')
<div class="card">
    <div class="card-header card-primary card-outline">
        <h1 class="card-title">List Provinsi</h1>
        <div class="card-tools">
            <button type="button" data-toggle="modal" data-target="#provinceModal" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New
            </button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped" id="province_table">
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
<form method="POST" action="{{ route('dashboard.provinsi.index') }}" class="modal fade" tabindex="-1" role="dialog" id="provinceModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Provinsi (Insert)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                <input type="hidden" name="_method" id="_method" value="POST">

                <div class="form-group" id="form-provinsi_name">
                    <label>Name{!! printRequired() !!}</label>
                    <input type="text" name="provinsi_name" id="field-provinsi_name" class="form-control" placeholder="Provinsi Name">
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
@endsection

@section('inline_js')
<script>
    let province_table = $("#province_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('dashboard.json.datatable.provinsi.all') }}",
        columns: [
            { "data": "provinsi_name" },
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

    $("#provinceModal").submit(function(e){
        e.preventDefault();
        console.log("Form is being submited...");
        removeInvalid();

        // Form Data
        let form_data = $(e.target).serialize();
        let target_url = $("#provinceModal").attr('action');
        console.log("Target : "+target_url);

        let el = $(this).closest('.modal');
        // el.addClass('modal-progress');

        $.post(target_url, form_data, function(result){
            console.log(result);
            $("#province_table").DataTable().ajax.reload();

            $('<blockquote class="mx-0 mt-0">'
                +'<button type="button" class="close as-close" aria-hidden="true">×</button>'
                +'<p>Action: '+result.action+'</p>'
                +'<small>Message: '+result.message+'</small>'
            +'</blockquote>').appendTo($('#alert_section'));

            $("#provinceModal").modal('hide');
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
    $("#provinceModal").on('hide.bs.modal', function(){
        console.log("Modal is being hide");
        $("#btn_reset").click();
    });

    function formReset(){
        removeInvalid();

        $("#provinceModal").attr('action', "{{ route('dashboard.provinsi.index') }}");
        $("#provinceModal .modal-title").text('Form Provinsi (Insert)');

        $("#_method").val("POST");
        $("#field-provinsi_name").val('');
    }

    function actionEdit(id){
        console.log("Edit Action is running... ID is : "+id);
        $(".btn-caction").attr('disabled', true);

        $.get("{{ route('dashboard.json.provinsi.all') }}/"+id, function(result){
            console.log(result);
            let data = result.data;

            $("#provinceModal").attr('action', "{{ route('dashboard.provinsi.index') }}/"+data.id);
            $("#provinceModal .modal-title").text('Form Provinsi (Update)');

            $("#_method").val("PUT");
            $("#field-provinsi_name").val(data.provinsi_name);

            $("#provinceModal").modal("show");
        }).always(function(result){
            $(".btn-caction").attr('disabled', false);
        }).fail(function(jqXHR, textStatus, errorThrown){
            console.log("Ajax Fail");
            console.log(jqXHR);
        });
    }
</script>
@endsection