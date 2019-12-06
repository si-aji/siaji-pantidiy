@extends('layouts.dashboard', [
    'wsecond_title' => 'Profile',
    'menu' => 'profile',
    'sub_menu' => null,
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Profile',
        'desc' => 'Change how your profile looks',
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => '#',
                'text' => 'Profile',
                'active' => true
            ]
        ]
    ]
])

@section('content')
<div class="row">
    <div class="col-12 col-md-3">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('adminlte/img/user4-128x128.jpg') }}" alt="User profile picture">
                </div>
      
                <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>
                <p class="text-muted text-center">Software Engineer</p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Followers</b> <a class="float-right">1,322</a>
                    </li>
                    <li class="list-group-item">
                        <b>Following</b> <a class="float-right">543</a>
                    </li>
                    <li class="list-group-item">
                        <b>Friends</b> <a class="float-right">13,287</a>
                    </li>
                </ul>      
                
                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="col-12 col-md-9">
        {{-- Profile Form --}}
        <form id="profileForm" action="{{ route('dashboard.profile.index') }}" method="POST" class="card">
            @csrf
            @method('PUT')

            <div class="card-header">
                <h1 class="card-title">Profile Form</h1>

                <div class="card-tools">
                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-password">
                        <i class="fas fa-lock"></i> Change Password
                    </button>
                </div>
            </div>

            <div class="card-body form-horizontal">
                <div class="form-group row">
                    <label for="field-name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" id="field-name" value="{{ auth()->user()->name }}">
                        @error('name')
                        <div class='invalid-feedback'>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="field-email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" id="field-email" value="{{ auth()->user()->email }}">
                        @error('email')
                        <div class='invalid-feedback'>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="field-username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username" id="field-username" value="{{ auth()->user()->username }}">
                        @error('username')
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
        </form>
    </div>
</div>
@endsection

@section('content_modal')
{{-- Password Modal --}}
<form class="modal fade" tabindex="-1" role="dialog" id="modal-password">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Password Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @method('PUT')
                <p>Change password, new password apply on next login attempt</p>
                <div class="form-group" id="field-password">
                    <label>Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                </div>
                <div class="form-group" id="field-password_confirmation">
                    <label>Password Confirmation</label>
                    <input type="password" class="form-control" id="password_confirmation" placeholder="Re-type Password" name="password_confirmation">
                </div>
                <div class="form-group" id="field-old_password">
                    <label>Password Old Password</label>
                    <input type="password" class="form-control" id="old_password" placeholder="Old Password" name="old_password">
                </div>
            </div>
            <div class="modal-footer br">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-sm btn-danger" id="password-reset" onclick="removeInvalid()">Reset</button>
                <button type="submit" class="btn btn-sm btn-primary" onclick="removeInvalid()">Save changes</button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('plugins_js')
<script src="{{ mix('adminlte/js/siaji.js') }}"></script>
@endsection

@section('inline_js')
<script>
    $("#modal-password").submit(function(e){
        e.preventDefault();
        // Form Data
        let form_data = $(e.target).serialize();
        console.log(form_data);

        let el = $(this).closest('.modal');
        el.addClass('modal-progress');

        $.post("{{ route('dashboard.profile.update.password') }}", form_data, function(result){
            console.log(result);
            $('<blockquote class="mx-0 mt-0">'
                +'<button type="button" class="close as-close" aria-hidden="true">×</button>'
                +'<p>Action: '+result.action+'</p>'
                +'<small>Message: '+result.message+'</small>'
            +'</blockquote>').appendTo($('#alert_section'));

            $("#modal-password").modal('hide');
        }).always(function(result){
            el.removeClass('modal-progress');
        }).fail(function(jqXHR, textStatus, errorThrown){
            console.log("Ajax Fail");
            console.log(jqXHR);
            $.each(jqXHR.responseJSON.errors, function(key, result){
                $("#"+key).addClass('is-invalid');
                $("#field-"+key).append("<div class='invalid-feedback'>"+result+"</div>");
            });
        });
    });
    $("#modal-password").on('hide.bs.modal', function(){
        console.log("Modal is being hide");
        $("#password-reset").click();
    });
</script>
@endsection