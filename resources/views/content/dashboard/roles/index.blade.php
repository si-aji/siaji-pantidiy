@extends('layouts.dashboard', [
    'wsecond_title' => 'Roles Setting',
    'menu' => 'roles',
    'sub_menu' => null,
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Roles Setting',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => '#',
                'text' => 'Roles Setting',
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
        <h1 class="card-title">List Roles</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.roles-setting.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover" id="role_table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $item)
                <tr id="rows_{{ $item->id }}">
                    <td>{{ $item->name }}</td>
                    <td>
                        <div class='btn-group'>
                            <a href="{{ route('dashboard.roles-setting.edit', $item->id) }}" class="btn btn-caction btn-warning btn-sm"><i class="far fa-edit"></i></a>
                            <a href="{{ route('dashboard.roles-setting.show', $item->id) }}" class="btn btn-caction btn-info btn-sm"><i class="far fa-eye"></i></a>
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
    let role_table = $("#role_table").DataTable({
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