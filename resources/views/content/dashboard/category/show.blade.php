@extends('layouts.dashboard', [
    'wsecond_title' => 'Category - Detail',
    'menu' => 'post',
    'sub_menu' => 'category',
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Category - Detail',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => route('dashboard.category.index'),
                'text' => 'Category',
                'active' => false
            ], [
                'url' => '#',
                'text' => 'Detail',
                'active' => true
            ]
        ]
    ]
])

@if($category->post()->exists())
@section('plugins_css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
@endsection
@endif

@section('content')
<div class="card">
    <div class="card-header card-primary card-outline">
        <h1 class="card-title">Detail {{ $category->category_title }}</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.category.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-chevron-circle-left"></i> Back
            </a>
            <a href="{{ route('dashboard.category.edit', $category->category_slug) }}" class="btn btn-warning btn-sm">
                <i class="far fa-edit"></i> Edit
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped">
            <tr>
                <th width="30%">Title</th>
                <td>{{ $category->category_title }}</td>
            </tr>
            <tr>
                <th>Short Description</th>
                <td>{{ $category->category_description ?? '-' }}</td>
            </tr>
        </table>

        @if($category->post()->exists())
        <div class="card mt-3">
            <div class="card-header">
                <h1 class="card-title">Post with <u>{{ ucwords($category->category_title) }}</u> category</h1>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover table-striped" id="posts_table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection


@if($category->post()->exists())
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

    let posts_table = $("#posts_table").DataTable({
        order: [3, 'desc'],
        lengthMenu: [5, 10, 25],
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('dashboard.json.datatable.post.category', $category->category_slug) }}",
            type: "GET",
        },
        success: function (result) {
            console.log(result);
        },
        columns: [
            { "data": "post_title" },
            { "data": "author.name" },
            { "data": "" },
            { "data": "created_at" },
            { "data": "" }
        ],
        columnDefs: [
            {
                "targets": 1,
                "render": function(row, type, data){
                    // console.log(row);
                    return (row != undefined ? row : 'Uncategorized');
                }
            }, {
                "targets": 2,
                "searchable": false,
                "sortable": false,
                "render": function(row, type, data){
                    let badge_color;
                    let post_status = ucwords(data.post_status);
                    if(data.post_status == 'draft'){
                        badge_color = 'warning';
                    } else {
                        if(data.post_published > "{{ date('Y-m-d H:i:s') }}"){
                            badge_color = 'info';
                            post_status = "Scheduled - "+moment(data.post_published).format('MMM Do YYYY, H:mm:ss');
                        } else {
                            badge_color = 'success';
                            post_status += " - "+moment(data.post_published).format('MMM Do YYYY, H:mm:ss');
                        }
                    }
                    return '<span class="right badge badge-'+badge_color+'">'+post_status+'</span>';
                }
            }, {
                "targets": 3,
                "render": function(row, type, data){
                    return moment(row).format('MMM Do YYYY, H:mm:ss');
                }
            }, {
                "targets": 4,
                "searchable": false,
                "sortable": false,
                "render": function(row, type, data){
                    // console.log(row);
                    return "<div class='btn-group'>"
                        +"<a href='{{ route('dashboard.post.index') }}/"+data.post_slug+"/edit' class='btn btn-caction btn-warning btn-sm'><i class='far fa-edit'></i></a>"
                        +"<a href='{{ route('dashboard.post.index') }}/"+data.post_slug+"' class='btn btn-caction btn-info btn-sm'><i class='far fa-eye'></i></a>"
                    +"</div>"
                }
            }
        ],
    });
</script>
@endsection
@endif