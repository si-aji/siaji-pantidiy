@extends('layouts.dashboard', [
    'wsecond_title' => 'Pages',
    'menu' => 'page',
    'sub_menu' => null,
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Pages',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => '#',
                'text' => 'Pages',
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
        <h1 class="card-title">List Pages</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.page.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped" id="pages_table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('plugins_js')
<script src="{{ mix('adminlte/js/siaji.js') }}"></script>
<script src="{{ mix('adminlte/plugins/moment/moment.min.js') }}"></script>

<!-- Datatable -->
<script src="{{ mix('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ mix('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script src="http://cdn.datatables.net/plug-ins/1.10.20/sorting/datetime-moment.js"></script>
@endsection

@section('inline_js')
<script>
    $(document).ready(function() {
        $.fn.dataTable.moment( 'dddd, MMMM Do, YYYY' );
    });

    let pages_table = $("#pages_table").DataTable({
        order: [2, 'desc'],
        lengthMenu: [5, 10, 25],
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('dashboard.json.datatable.page.all') }}",
            type: "GET",
        },
        success: function (result) {
            console.log(result);
        },
        columns: [
            { "data": "page_title" },
            { "data": "" },
            { "data": "created_at" },
            { "data": "" }
        ],
        columnDefs: [
            {
                "targets": 1,
                "searchable": false,
                "sortable": false,
                "render": function(row, type, data){
                    let badge_color;
                    let page_status = ucwords(data.page_status);
                    if(data.page_status == 'draft'){
                        badge_color = 'warning';
                    } else {
                        if(data.page_published > "{{ date('Y-m-d H:i:s') }}"){
                            badge_color = 'info';
                            page_status = "Scheduled - "+moment(data.page_published).format('MMM Do YYYY, H:mm:ss');
                        } else {
                            badge_color = 'success';
                            page_status += " - "+moment(data.page_published).format('MMM Do YYYY, H:mm:ss');
                        }
                    }
                    return '<span class="right badge badge-'+badge_color+'">'+page_status+'</span>';
                }
            }, {
                "targets": 2,
                "render": function(row, type, data){
                    return moment(row).format('MMM Do YYYY, H:mm:ss');
                }
            }, {
                "targets": 3,
                "searchable": false,
                "sortable": false,
                "render": function(row, type, data){
                    // console.log(row);
                    return "<div class='btn-group'>"
                        +"<a href='{{ route('dashboard.page.index') }}/"+data.page_slug+"/edit' class='btn btn-caction btn-warning btn-sm'><i class='far fa-edit'></i></a>"
                        +"<a href='{{ route('dashboard.page.index') }}/"+data.page_slug+"' class='btn btn-caction btn-info btn-sm'><i class='far fa-eye'></i></a>"
                    +"</div>"
                }
            }
        ],
    });
</script>
@endsection