@extends('auth.layouts.app')

@section('content')

<div class="login-box">
    <div class="login-logo">
        <img src="/uploads/setting/{{setting('auth_logo')}}" alt="Logo" width="200px" height="75px">
    </div>
    <p class="login-box-msg pb-2" style="font-weight: normal; font-size:17px; text-align: center;">To reset your password, please enter your valid email address</p>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            
            
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="form-group">
                    @if (session('error'))
                        <div class="alert alert-danger">{{session('error')}}</div>
                    @endif
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    @error('username')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-2">
                    <button type="submit" class="btn btn-primary btn-block">Request new password</button>
                </div>
            </form>
            <div class="text-center py-3 text-bold">
                <a href="{{route('login')}}">Go back to sign in</a>
            </div>
        </div>
      <!-- /.login-card-body -->
    </div>
</div>

@endsection
