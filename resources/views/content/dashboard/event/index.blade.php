@extends('layouts.dashboard', [
    'wsecond_title' => 'Event',
    'menu' => 'event',
    'sub_menu' => null,
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Event',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => '#',
                'text' => 'Event',
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
        <h1 class="card-title">List Event</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.event.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped" id="event_table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Start</th>
                    <th>End</th>
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

    let event_table = $("#event_table").DataTable({
        order: [1, 'desc'],
        lengthMenu: [5, 10, 25],
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('dashboard.json.datatable.event.all') }}",
            type: "GET",
        },
        success: function (result) {
            console.log(result);
        },
        columns: [
            { "data": "event_title" },
            { "data": "event_start" },
            { "data": "event_end" },
            { "data": "" }
        ],
        columnDefs: [
            {
                "targets": 1,
                "render": function(row, type, data){
                    return moment(row).format('MMM Do YYYY, H:mm:ss')
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
                        +"<a href='{{ route('dashboard.event.index') }}/"+data.event_slug+"/edit' class='btn btn-caction btn-warning btn-sm'><i class='far fa-edit'></i></a>"
                        +"<a href='{{ route('dashboard.event.index') }}/"+data.event_slug+"' class='btn btn-caction btn-info btn-sm'><i class='far fa-eye'></i></a>"
                    +"</div>"
                }
            }
        ],
    });
</script>
@endsection