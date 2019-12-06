@extends('layouts.dashboard', [
    'wsecond_title' => 'Setting - Edit',
    'menu' => 'setting',
    'sub_menu' => null,
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Setting - Edit',
        'desc' => 'Edit Existing Website Meta Data',
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => route('dashboard.setting.index'),
                'text' => 'Settings',
                'active' => false
            ], [
                'url' => '#',
                'text' => 'Edit',
                'active' => true
            ]
        ]
    ]
])

@section('content')
<form action="{{ route('dashboard.setting.update', $setting->id) }}" method="POST" enctype="multipart/form-data" class="card card-primary card-outline">
    @csrf
    @method('PUT')

    <div class="card-header">
        <h1 class="card-title">Edit Setting</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.setting.index') }}" class="btn btn-warning btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-3">
                <ul class="nav flex-column" id="setting_menu">
                    <li class="nav-item">
                        <a class="nav-link {{ empty($stitle) ? 'disabled' : '' }}" id="nav_link-title" href="{{ $stitle ? route('dashboard.setting.edit', $stitle->id) : 'javascript:void(0)' }}">Title</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ empty($sdesc) ? 'disabled' : '' }}" id="nav_link-description" href="{{ $sdesc ? route('dashboard.setting.edit', $sdesc->id) : 'javascript:void(0)' }}">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ empty($sfavicon) ? 'disabled' : '' }}" id="nav_link-favicon" href="{{ $sfavicon ? route('dashboard.setting.edit', $sfavicon->id) : 'javascript:void(0)' }}">Favicon</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ empty($slogo) ? 'disabled' : '' }}" id="nav_link-logo" href="{{ $slogo ? route('dashboard.setting.edit', $slogo->id) : 'javascript:void(0)' }}">Logo</a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-md-9">
                <input type="hidden" class="d-none" name="setting_key" id="field-setting_key" value="{{ $setting->setting_key }}">

                <div class="form-group">
                    <label for="field-setting_name" class="col-form-label">Name</label>
                    <input type="text" name="setting_name" class="form-control @error('setting_name') is-invalid @enderror" placeholder="Name" id="field-setting_name" value="{{ $setting->setting_name }}">
                    
                    @error('setting_name')
                    <div class='invalid-feedback'>{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="field-setting_description" class="col-form-label">Short Description</label>
                    <input type="text" name="setting_description" class="form-control @error('setting_description') is-invalid @enderror" placeholder="Short Description" id="field-setting_description" value="{{ $setting->setting_description }}">
                    
                    @error('setting_description')
                    <div class='invalid-feedback'>{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="col-form-label">Value</label>

                    @if($setting->setting_key == 'title' || $setting->setting_key == 'description')
                    <input type="text" name="setting_value" class="form-control @error('setting_value') is-invalid @enderror" id="field-setting_value" placeholder="Setting Value" value="{{ $setting->setting_value }}">
                    @else
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('setting_value') is-invalid @enderror" name="setting_value" id="setting_value">
                        <label class="custom-file-label" id="label-setting_value" for="setting_value">Choose file</label>
                    </div>
                    @endif

                    @error('setting_value')
                    <div class='invalid-feedback'>{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10 text-right text-md-right">
                        <button type="reset" class="btn btn-sm btn-danger">Reset</button>
                        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('plugins_js')
<!-- bs-custom-file-input -->
<script src="{{ mix('adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        bsCustomFileInput.init();
    });
</script>
@endsection