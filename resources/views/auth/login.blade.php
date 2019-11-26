@extends('layouts.auth', [
    'extra_class' => 'login-page',
])

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ route('public.index') }}">{{ $wtitle ?? 'SIAJI' }}</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>
      
            <form action="{{ route('public.login') }}" method="post">
                @csrf

                <div class="input-group mb-3">
                    <input type="text" name="email" class="form-control @error('username') is-invalid @enderror" placeholder="Email">
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
                    <input type="password" name="password" class="form-control @error('username') is-invalid @enderror" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('email')
                    <div class='invalid-feedback'>{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </form>
      
            <div class="text-left mt-3">
                <small class="mb-1 d-block">
                    <a href="{{ route('public.password.request') }}">I forgot my password</a>
                </small>
                <small class="mb-0 d-block">
                    <a href="{{ route('public.register') }}" class="text-center">Register a new membership</a>
                </small>
            </div>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
@endsection