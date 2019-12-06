@extends('layouts.dashboard', [
    'wsecond_title' => 'Setting - Create',
    'menu' => 'setting',
    'sub_menu' => null,
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Setting - Create',
        'desc' => 'Create New Website Meta Data',
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
                'text' => 'Create',
                'active' => true
            ]
        ]
    ]
])

@section('content')
<form action="{{ route('dashboard.setting.store') }}" method="POST" enctype="multipart/form-data" class="card card-primary card-outline">
    @csrf

    <div class="card-header">
        <h1 class="card-title">Create new Setting</h1>
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
                    @if(empty($wtitle))
                    <li class="nav-item">
                        <a class="nav-link" id="nav_link-title" onclick="event.preventDefault();setSettingKey('title')" href="javascript:void(0)">Title</a>
                    </li>
                    @endif
                    @if(empty($wdesc))
                    <li class="nav-item">
                        <a class="nav-link" id="nav_link-description" onclick="event.preventDefault();setSettingKey('description')" href="javascript:void(0)">Description</a>
                    </li>
                    @endif
                    @if(empty($wfavicon))
                    <li class="nav-item">
                        <a class="nav-link" id="nav_link-favicon" onclick="event.preventDefault();setSettingKey('favicon')" href="javascript:void(0)">Favicon</a>
                    </li>
                    @endif
                    @if(empty($wlogo))
                    <li class="nav-item">
                        <a class="nav-link" id="nav_link-logo" onclick="event.preventDefault();setSettingKey('logo')" href="javascript:void(0)">Logo</a>
                    </li>
                    @endif
                </ul>
            </div>

            <div class="col-12 col-md-9">
                <input type="hidden" class="d-none" name="setting_key" id="field-setting_key" value="{{ old('setting_key') }}">

                <div class="form-group">
                    <label for="field-setting_name" class="col-form-label">Name</label>
                    <input type="text" name="setting_name" class="form-control @error('setting_name') is-invalid @enderror" placeholder="Name" id="field-setting_name" value="{{ old('setting_name') }}">
                    
                    @error('setting_name')
                    <div class='invalid-feedback'>{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="field-setting_description" class="col-form-label">Short Description</label>
                    <input type="text" name="setting_description" class="form-control @error('setting_description') is-invalid @enderror" placeholder="Short Description" id="field-setting_description" value="{{ old('setting_description') }}">
                    
                    @error('setting_description')
                    <div class='invalid-feedback'>{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="col-form-label">Value</label>

                    <div class="d-none">
                        <input type="text" name="setting_value" class="form-control @error('setting_value') is-invalid @enderror" id="field-setting_value" placeholder="Setting Value" value="{{ old('setting_value') }}">
                        @error('setting_value')
                        <div class='invalid-feedback'>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('setting_value_file') is-invalid @enderror" name="setting_value_file" id="setting_value_file">
                        <label class="custom-file-label" id="label-setting_value_file" for="setting_value_file">Choose file</label>
                        @error('setting_value_file')
                        <div class='invalid-feedback'>{{ $message }}</div>
                        @enderror
                    </div>
                    
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

        @if(empty(old('setting_key')))
        let type_elements = $("#setting_menu .nav-link");
        type_elements[0].click();
        @else
        setSettingKey("{{ old('setting_key') }}");
        @endif
    });

    function setSettingKey(value){
        console.log("Set Setting Key Function is running, value : "+value);

        // Remove Active Class
        $("#setting_menu .nav-link").removeClass('active');
        // Add Active Class
        $("#setting_menu #nav_link-"+value).addClass('active');

        $("#field-setting_key").val(value);
        setSettingValue();
    }

    function setSettingValue(){
        let setting_key = $("#field-setting_key").val();

        if(setting_key == 'title' || setting_key == 'description'){
            $("#field-setting_value").parent().removeClass('d-none').addClass('d-block');
            $("#setting_value_file").val('').parent().removeClass('d-block').addClass('d-none');
            $("#label-setting_value_file").text('Choose file');
        } else {
            $("#field-setting_value").parent().removeClass('d-block').addClass('d-none');
            $("#setting_value_file").val('').parent().removeClass('d-none').addClass('d-block');
            $("#label-setting_value_file").text('Choose file');
        }
    }
</script>
@endsection