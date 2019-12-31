@extends('layouts.dashboard', [
    'wsecond_title' => 'Category',
    'menu' => 'post',
    'sub_menu' => 'category',
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Category',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => null,
                'text' => 'Category',
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
        <h1 class="card-title">List Category</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.category.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover" id="category_table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($category as $item)
                <tr id="rows_{{ $item->id }}">
                    <td>{{ $item->category_title }}</td>
                    <td>{{ $item->category_description ?? '-' }}</td>
                    <td>
                        <div class='btn-group'>
                            <a href="{{ route('dashboard.category.edit', $item->category_slug) }}" class="btn btn-caction btn-warning btn-sm"><i class="far fa-edit"></i></a>
                            <a href="{{ route('dashboard.category.show', $item->category_slug) }}" class="btn btn-caction btn-info btn-sm"><i class="far fa-eye"></i></a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('plugins_js')
<script src="{{ mix('adminlte/js/siaji.js') }}"></script>

<!-- Datatable -->
<script src="{{ mix('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ mix('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
@endsection

@section('inline_js')
<script>
    let category_table = $("#category_table").DataTable({
        order: [0, 'asc'],
        lengthMenu: [5, 10, 25],
        columnDefs: [
            {
                "targets": 2,
                "sortable": false,
                "searchable": false
            }
        ]
    });
</script>
@endsection