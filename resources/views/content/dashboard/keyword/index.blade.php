@extends('layouts.dashboard', [
    'wsecond_title' => 'Keyword',
    'menu' => 'post',
    'sub_menu' => 'keyword',
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Keyword',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => null,
                'text' => 'Keyword',
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
        <h1 class="card-title">List Keyword</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.keyword.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover" id="keyword_table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($keyword as $item)
                <tr id="rows_{{ $item->id }}">
                    <td>{{ $item->keyword_title }}</td>
                    <td>
                        <div class='btn-group'>
                            <a href="{{ route('dashboard.keyword.edit', $item->keyword_slug) }}" class="btn btn-caction btn-warning btn-sm"><i class="far fa-edit"></i></a>
                            <a href="{{ route('dashboard.keyword.show', $item->keyword_slug) }}" class="btn btn-caction btn-info btn-sm"><i class="far fa-eye"></i></a>
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
    let keyword_table = $("#keyword_table").DataTable({
        order: [0, 'asc'],
        lengthMenu: [5, 10, 25],
        columnDefs: [
            {
                "targets": 1,
                "sortable": false,
                "searchable": false
            }
        ]
    });
</script>
@endsection