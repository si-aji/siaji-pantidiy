@extends('layouts.dashboard', [
    'wsecond_title' => 'Settings',
    'menu' => 'setting',
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Settings',
        'desc' => 'Manage Website Meta Data',
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => '#',
                'text' => 'Settings',
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
<div class="card card-primary card-outline">
    <div class="card-header">
        <h1 class="card-title">Settings</h1>
        @if(empty($wtitle) || empty($wdesc) || empty($wfavicon) || empty($wlogo))
        <div class="card-tools">
            <a href="{{ route('dashboard.setting.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New
            </a>
        </div>
        @endif
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped" id="setting_table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Value</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($settings as $item)
                <tr id="rows_{{ $item->id }}">
                    <td>{{ $item->setting_name }}</td>
                    <td>{{ $item->setting_value }}</td>
                    <td>{{ $item->setting_description ?? '-' }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('dashboard.setting.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="" class="btn btn-primary btn-sm"><i class="fas fa-info-circle"></i></a>
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
<script src="{{ mix('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ mix('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
@endsection

@section('inline_js')
<script>
    $("#setting_table").DataTable();
</script>
@endsection