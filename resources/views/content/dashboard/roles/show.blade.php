@extends('layouts.dashboard', [
    'wsecond_title' => 'Roles Setting - Detail',
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
                'url' => route('dashboard.roles-setting.index'),
                'text' => 'Roles Setting',
                'active' => true
            ], [
                'url' => '#',
                'text' => 'Detail',
                'active' => true
            ]
        ]
    ]
])

@section('content')
<div class="card">
    <div class="card-header card-primary card-outline">
        <h1 class="card-title">Detail {{ $role->name }}</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.roles-setting.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-chevron-circle-left"></i> Back
            </a>
            <a href="{{ route('dashboard.roles-setting.edit', $role->id) }}" class="btn btn-warning btn-sm">
                <i class="far fa-edit"></i> Edit
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover table-bordered">
            <tbody>
                <tr>
                    <th>Role Name</th>
                    <td>{{ $role->name }}</td>
                </tr>
                <tr>
                    <th>Permission{{ count($old_options) > 1 ? 's' : '' }}</th>
                    <td>
                        @foreach($old_options as $val)
                        <label class="badge badge-secondary p-2">{{ $val }}</label>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection