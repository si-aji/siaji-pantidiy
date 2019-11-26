@extends('layouts.auth', [
    'extra_class' => 'register-page',
])

@section('content')
<div class="register-box">
    <div class="register-logo">
        <a href="{{ route('public.index') }}">{{ $wtitle ?? 'SIAJI' }}</a>
    </div>
      
    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Register a new membership</p>
      
            <form action="{{ route('public.register') }}" method="post">
                @csrf

                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Full name">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    @error('name')
                    <div class='invalid-feedback'>{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                    <div class='invalid-feedback'>{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    @error('username')
                    <div class='invalid-feedback'>{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                    <div class='invalid-feedback'>{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Retype password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>

            <div class="text-left mt-3">
                <small class="mb-0 d-block">
                    <a href="{{ route('public.login') }}" class="text-center">i already have a membership</a>
                </small>
            </div>
        </div>
    </div>
</div>
@endsection