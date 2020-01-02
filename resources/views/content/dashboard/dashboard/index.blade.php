@extends('layouts.dashboard', [
    'wsecond_title' => 'Dashboard',
    'menu' => 'dashboard',
    'sub_menu' => null,
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Dashboard',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => null,
                'text' => 'Dashboard',
                'active' => true
            ]
        ]
    ]
])

@section('content')
<div class="row">
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cache</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0" style="display: block;">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a href="{{ route('dashboard.clear.cache') }}" class="nav-link">
                            Clear System Cache
                            <span class="float-right">
                                <i class="fas fa-trash-alt"></i>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.clear.config') }}" class="nav-link">
                            Clear Configuration Cache
                            <span class="float-right">
                                <i class="far fa-trash-alt"></i>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.clear.view') }}" class="nav-link">
                            Clear View Cache
                            <span class="float-right">
                                <i class="fas fa-trash"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /.card-body -->
          </div>
    </div>
</div>
@endsection