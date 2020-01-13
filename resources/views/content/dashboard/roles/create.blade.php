@extends('layouts.dashboard', [
    'wsecond_title' => 'Roles Setting - Create',
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
<form class="card" method="POST" action="{{ route('dashboard.roles-setting.store') }}">
    @csrf
    
    <div class="card-header card-primary card-outline">
        <h1 class="card-title">Add new Roles</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.roles-setting.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-chevron-circle-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group" id="form-roles_name">
            <label for="field-roles_name">Name{!! printRequired() !!}</label>
            <input type="text" name="roles_name" id="field-roles_name" class="form-control @error('roles_name') is-invalid @enderror" placeholder="Roles Name" value="{{ old('roles_name') }}">
            @error('roles_name')
            <div class='invalid-feedback'>{{ $message }}</div>
            @enderror
        </div>

        <table class="table table-hover table-bordered mb-3">
            <thead>
                <tr>
                    <th>Field</th>
                    <th>
                        Access
                        <div class="btn-group float-right">
                            <button type="button" class="btn btn-xs btn-warning" id="allow_all" onclick="checkAll();" style="display:none">Check All</button>
                            <button type="button" class="btn btn-xs btn-info" id="notallow_all" onclick="uncheckAll();" style="display:none">Un-Check All</button>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($options as $key => $item)
                    <tr>
                        <td>{{ ucwords(str_replace('_', ' - ', $key)) }}</td>
                        <td>
                            <div class="form-row">
                                @foreach($item as $value)
                                <div class="col-12 col-lg-3">
                                    <div class="custom-control custom-checkbox d-block d-lg-inline">
                                        <input class="custom-control-input" type="checkbox" name="permission[]" value="{{ $key.'-'.$value }}" id="{{ $key.'-'.$value }}" {!! $value != 'list' ? 'disabled' : "onchange=listCheck('".$key."')" !!}>
                                        <label for="{{ $key.'-'.$value }}" class="custom-control-label">{{ ucwords($value) }}</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10 text-right text-md-right">
                <button type="reset" id="btn-reset" class="btn btn-sm btn-danger">Reset</button>
                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('inline_js')
<script>
    var key_list = [
        @foreach($options as $key => $value)
        '{{ $key }}',
        @endforeach
    ]

    @if(old('permission'))
    var key_old = [];
    @foreach(old('permission') as $permission)
    key_old.push("{{ $permission }}");
    @endforeach
    @endif

    $(document).ready(function(){
        key_list.forEach(function(obj){
            @if(old('permission'))
                if(key_old.includes(obj+'-list')){
                    $("#"+obj+'-list').prop('checked', true);
                }
            @endif

            listCheck(obj);
        });
        checkboxCheck();
    });

    function listCheck(permission){
        console.log("Check Permission is running...");

        if($("#"+permission+"-list").prop('checked') === true){
            $("#"+permission+'-create').attr('disabled', false);
            $("#"+permission+'-edit').attr('disabled', false);
            $("#"+permission+'-delete').attr('disabled', false);

            @if(old('permission'))
            if(key_old.includes(permission+'-create')){
                $("#"+permission+'-create').prop('checked', true);
            } else {
                $("#"+permission+'-create').prop('checked', false);
            }

            if(key_old.includes(permission+'-edit')){
                $("#"+permission+'-edit').prop('checked', true);
            } else {
                $("#"+permission+'-edit').prop('checked', false);
            }

            if(key_old.includes(permission+'-delete')){
                $("#"+permission+'-delete').prop('checked', true);
            } else {
                $("#"+permission+'-delete').prop('checked', false);
            }
            @endif
        } else {
            $("#"+permission+'-create').prop('checked', false).attr('disabled', true);
            $("#"+permission+'-edit').prop('checked', false).attr('disabled', true);
            $("#"+permission+'-delete').prop('checked', false).attr('disabled', true);
        }
    }

    $("input[name='permission[]']").change(function(){
        checkboxCheck();
    });

    function checkboxCheck(){
        let avail_option = $("input[name='permission[]']").length;
        let selected_option = $("input[name='permission[]']:checked").length;

        // console.log("Avail Option "+avail_option);
        // console.log("Selected Option "+selected_option);
        if(selected_option >= avail_option){
            $("#allow_all").attr('disabled', true).hide();
            $("#notallow_all").attr('disabled', false).show();
        } else {
            $("#allow_all").attr('disabled', false).show();
            $("#notallow_all").attr('disabled', true).hide();
        }
    }
    function checkAll(){
        $("input[name='permission[]']").prop('disabled', false).prop('checked', true);
        checkboxCheck();
    }
    function uncheckAll(){
        $("input[name='permission[]']").prop('checked', false);
        key_list.forEach(function(obj){
            listCheck(obj);
        });
        checkboxCheck();
    }

    $("#btn-reset").click(function(){
        key_list.forEach(function(obj){
            $("#"+obj+"-list").prop('checked', false);
            listCheck(obj);
        });
        checkboxCheck();
    });
</script>
@endsection