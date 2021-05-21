@extends('auth.layouts.app')

@push('css')
    <style>
        span.select2.select2-container{width: 100% !important}
        .login-box, .register-box {
            width: 450px !important;
        }
        @media (max-width: 576px) {
            .login-box, .register-box {
                margin-top: .5rem;
                width: 90% !important;
            }
        }
    </style>
@endpush

@section('content')

<div class="register-box">
    <div class="register-logo">
        <img src="/uploads/setting/{{setting('auth_logo')}}" alt="Logo" width="200px" height="75px">
        
    </div>
    <p class="login-box-msg pb-2" style="font-weight: normal; font-size:20px; text-align: center;">Please complete the registration</p>
    <div class="card">
        <div class="card-body register-card-body">
            
            @if (session('wrong'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Opps!!</strong> {{session('wrong')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @elseif (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success </strong> {{session('success')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <form action="{{route('register')}}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="sponsor_id">Sponsor ID</label>
                    <input type="number" name="sponsor_id" id="sponsor_id" class="form-control @error('sponsor_id') is-invalid @enderror" value="{{old('sponsor_id')}}" placeholder="Enter Sponsor ID">
                    @error('sponsor_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="placement_id">Placement ID (optional)</label>
                    <input type="number" name="placement_id" id="placement_id" class="form-control @error('placement_id') is-invalid @enderror" value="{{old('placement_id')}}" placeholder="Enter Placement ID">
                    @error('placement_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" placeholder="Name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{old('username')}}" placeholder="Username">
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" placeholder="example@gmail.com">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" id='country' name='country' class="form-control @error('country') is-invalid @enderror" placeholder="Country">
                    @error('country')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id='address' name='address' class="form-control @error('address') is-invalid @enderror" placeholder="Address">
                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="post_code">Post Code</label>
                    <input type="number" name="post_code" id="post_code" class="form-control @error('post_code') is-invalid @enderror" value="{{old('post_code')}}" maxlength="25" placeholder="Post Code">
                    @error('post_code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{old('phone')}}" maxlength="25" placeholder="Phone Number">
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="direction">Side</label>
                    <select name="direction" id="direction" class="form-control @error('direction') is-invalid @enderror">
                        <option value="">Select Side</option>
                        <option value="1">Left Side</option>
                        <option value="2">Middle Side</option>
                        <option value="3">Right Side</option>
                    </select>
                    
                    @error('direction')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="register_package">Register Package</label>
                    <select name="register_package" id="register_package" class="form-control @error('register_package') is-invalid @enderror">
                        <option value="">Select Package</option>
                        <option value="{{setting('single_package')}}">Single Package ({{setting('single_package')}})</option>
                        <option value="{{setting('share_package')}}">Share Package ({{setting('share_package')}})</option>
                    </select>
                    
                    @error('register_package')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                        
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password-confirm">Retype Password</label>
                        <input type="password" name="password_confirmation" id="password-confirm" class="form-control" placeholder="Retype Password">
                        
                    </div>
                </div>
                
                <div class="form-group mb-2">
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </div>
            </form>

            <div class="text-center text-bold">
                <a href="{{route('login')}}" class="text-center">Already have account? Login here</a>
            </div>
            
        </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
</div>

@endsection
