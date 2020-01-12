@extends('layouts.dashboard', [
    'wsecond_title' => 'Liputan Panti',
    'menu' => 'panti',
    'sub_menu' => 'liputan',
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
                'text' => 'Liputan Panti',
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
        <h1 class="card-title">List Liputan</h1>
        <div class="card-tools">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-liputan">
                <i class="fas fa-plus"></i> Add New
            </button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped" id="liputan_table">
            <thead>
                <tr>
                    <th>Tanggal Liputan</th>
                    <th>Panti</th>
                    <th>Author</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('content_modal')
{{-- Password Modal --}}
<form class="modal fade" tabindex="-1" role="dialog" id="modal-liputan">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Panti</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @method('PUT')
                <p>Pilih panti untuk diliput</p>

                <div class="form-group" id="fieldpanti-select">
                    <select class="form-control select2" name="panti_id" id="panti-select" onchange="checkPanti()">
                    </select>
                </div>
            </div>
            <div class="modal-footer br">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-sm btn-danger" id="modal-reset" onclick="removeInvalid()">Reset</button>
                <button type="submit" class="btn btn-sm btn-primary" id="modal-submit" onclick="removeInvalid()" disabled>Submit</button>
            </div>
        </div>
    </div>
</form>
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
        let select2_query = {};
        $('#panti-select').select2({
            placeholder: 'Search Panti',
            minimumInputLength: 3,
            allowClear: true,
            ajax: {
                url: "{{ route('dashboard.select2.panti.select2') }}",
                // url: function(params){
                //     console.log(params);
                //     return "{{ route('dashboard.select2.panti.select2') }}"+params.term;
                // },
                delay: 250,
                data: function (params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data, params) {
                    var items = $.map(data.data, function(obj){
                        obj.id = obj.panti_slug;
                        obj.text = obj.panti_name;

                        if(obj.provinsi_id != null){
                            obj.text += ' / Prov. '+obj.provinsi.provinsi_name
                        }
                        if(obj.kabupaten_id != null){
                            obj.text += ' / Kab. : '+obj.kabupaten.kabupaten_name
                        }
                        if(obj.kecamatan_id != null){
                            obj.text += ' / Kec. : '+obj.kecamatan.kecamatan_name
                        }

                        return obj;
                    });
                    params.page = params.page || 1;

                    console.log(items);
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: items,
                        pagination: {
                            more: params.page < data.last_page
                        }
                    };
                },
            },
            templateResult: function (item) {
                // console.log(item);
                // No need to template the searching text
                if (item.loading) {
                    return item.text;
                }
                
                var term = select2_query.term || '';
                var $result = markMatch(item.text, term);

                return $result;
            },
            language: {
                searching: function (params) {
                    // Intercept the query as it is happening
                    select2_query = params;
                    
                    // Change this to be appropriate for your application
                    return 'Searching...';
                }
            }
        });
    });

    let liputan_table = $("#liputan_table").DataTable({
        order: [0, 'desc'],
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('dashboard.json.datatable.panti.liputan.all') }}",
            type: "GET",
        },
        success: function (result) {
            console.log(result);
        },
        columns: [
            { "data": "liputan_date" },
            { "data": "panti.panti_name" },
            { "data": "author.name" },
            { "data": "" }
        ],
        columnDefs: [
            {
                "targets": 1,
                "render": function(row, type, data){
                    console.log(data);
                    let url = "{{ route('dashboard.panti.index') }}";
                    return "<a href='"+url+"/"+data.panti.panti_slug+"'>"+row+"</a>"
                }
            }, {
                "targets": 3,
                "searchable": false,
                "sortable": false,
                "render": function(row, type, data){
                    // console.log(row);
                    return "<div class='btn-group'>"
                        +"<a href='{{ route('dashboard.panti.liputan.index') }}/"+data.panti.panti_slug+"/"+data.id+"/edit' class='btn btn-caction btn-warning btn-sm'><i class='far fa-edit'></i></a>"
                        +"<a href='{{ route('dashboard.panti.liputan.index') }}/"+data.panti.panti_slug+"/"+data.id+"' class='btn btn-caction btn-info btn-sm'><i class='far fa-eye'></i></a>"
                    +"</div>"
                }
            }
        ],
    });

    function checkPanti(){
        let val = $("#panti-select").val();
        let submit_btn = $("#modal-submit");

        if(val != null){
            submit_btn.attr('disabled', false);
        } else {
            submit_btn.attr('disabled', true);
        }
    }

    $("#modal-liputan").submit(function(e){
        e.preventDefault();
        
        let val = $("#panti-select").val();
        let url_link = "{{ route('dashboard.panti.liputan.index') }}";
        if(val != null){
            window.location.href = url_link+"/"+val;
        } else {
            $("#panti-select").addClass('is-invalid');
            $("#fieldpanti-select").append("<div class='invalid-feedback'>Mohon pilih panti</div>");
        }
    });
</script>
@endsection