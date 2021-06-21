@extends('auth.layouts.app')

@section('title', 'Register')

@section('content')

<div class="login-form">
    <div class="login-form-header">
        <div class="sv">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
                <path class="elementor-shape-fill" opacity="0.33" d="M473,67.3c-203.9,88.3-263.1-34-320.3,0C66,119.1,0,59.7,0,59.7V0h1000v59.7 c0,0-62.1,26.1-94.9,29.3c-32.8,3.3-62.8-12.3-75.8-22.1C806,49.6,745.3,8.7,694.9,4.7S492.4,59,473,67.3z"></path>
                <path class="elementor-shape-fill" opacity="0.66" d="M734,67.3c-45.5,0-77.2-23.2-129.1-39.1c-28.6-8.7-150.3-10.1-254,39.1 s-91.7-34.4-149.2,0C115.7,118.3,0,39.8,0,39.8V0h1000v36.5c0,0-28.2-18.5-92.1-18.5C810.2,18.1,775.7,67.3,734,67.3z"></path>
                <path class="elementor-shape-fill" d="M766.1,28.9c-200-57.5-266,65.5-395.1,19.5C242,1.8,242,5.4,184.8,20.6C128,35.8,132.3,44.9,89.9,52.5C28.6,63.7,0,0,0,0 h1000c0,0-9.9,40.9-83.6,48.1S829.6,47,766.1,28.9z"></path>
            </svg>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="{{route('register')}}" method="POST" style="width:100%" id="form-submit">
                    @csrf
                    <div class="title">Register</div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="sponsor_id">Sponsor ID</label>
                            <input  type="number" name="sponsor_id" id="sponsor_id" class="form-control mb-0 @error('sponsor_id') is-invalid @enderror" value="{{old('sponsor_id')}}" placeholder="Enter Sponsor ID">
                            @error('sponsor_id')
                                <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
        
                        <div class="form-group col-md-6">
                            <label for="placement_id">Placement ID (optional)</label>
                            <input type="number" name="placement_id" id="placement_id" class="form-control mb-0 @error('placement_id') is-invalid @enderror" value="{{old('placement_id')}}" placeholder="Enter Placement ID">
                            @error('placement_id')
                            <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name">Name</label>
                            <input  type="text" name="name" id="name"class="form-control mb-0 @error('name') is-invalid @enderror" value="{{old('name')}}" placeholder="Name">
                            @error('name')
                                <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
        
                        <div class="form-group col-md-6">
                            <label for="username">Username</label>
                            <input  type="text" name="username" id="username"class="form-control mb-0 @error('username') is-invalid @enderror" value="{{old('username')}}" placeholder="Username">
                            @error('username')
                            <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input  type="email" name="email" id="email" class="form-control mb-0 @error('email') is-invalid @enderror" value="{{old('email')}}" placeholder="example@gmail.com">
                            @error('email')
                            <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
        
                        <div class="form-group col-md-6">
                            <label for="country">Country</label>
                            <input  type="text" id='country' name='country' class="form-control mb-0 @error('country') is-invalid @enderror" placeholder="Country">
                            @error('country')
                            <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
        
                        <div class="form-group col-md-6">
                            <label for="address">Address</label>
                            <input  type="text" id='address' name='address' class="form-control mb-0 @error('address') is-invalid @enderror" placeholder="Address">
                            @error('address')
                            <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
        
                        <div class="form-group col-md-6">
                            <label for="post_code">Post Code</label>
                            <input type="number" name="post_code" id="post_code" class="form-control mb-0 @error('post_code') is-invalid @enderror" value="{{old('post_code')}}" maxlength="25" placeholder="Post Code">
                            @error('post_code')
                            <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control mb-0 @error('phone') is-invalid @enderror" value="{{old('phone')}}" maxlength="25" placeholder="Phone Number">
                            @error('phone')
                            <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
        
                        <div class="form-group col-md-6">
                            <label for="direction">Side</label>
                            <select name="direction" id="direction" class="form-control mb-0 @error('direction') is-invalid @enderror">
                                <option value="">Select Side</option>
                                <option value="1">Left Side</option>
                                <option value="2">Middle Side</option>
                                <option value="3">Right Side</option>
                            </select>
                            
                            @error('direction')
                                <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
        
                        <div class="form-group col-md-12">
                            <label for="register_package">Register Package</label>
                            <select name="register_package" id="register_package" class="form-control mb-0 @error('register_package') is-invalid @enderror">
                                <option value="">Select Package</option>
                                <option value="{{setting('single_package')}}">Single Package ({{setting('single_package')}})</option>
                                <option value="{{setting('share_package')}}">Share Package ({{setting('share_package')}})</option>
                            </select>
                            
                            @error('register_package')
                            <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control mb-0 @error('password') is-invalid @enderror" placeholder="Password">
                            
                            @error('password')
                            <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password-confirm">Retype Password</label>
                            <input type="password" name="password_confirmation" id="password-confirm" class="form-control mb-0" placeholder="Retype Password">
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <input  type="submit" value="Submit" />
                    </div>
                    <div class="form-group text-center">
                        <p><a href="{{route('login')}}">Back to login</a></p>
                    </div>
                    
                </form>
            </div>
        </div>
        
    </div>
</div>

@endsection

@push('js')
    <script>
        $(document).ready(function () {
            
            $(document).on('submit', '#form-submit', function(e) {
                e.preventDefault();

                let method   = $(this).attr('method');
                let action   = $(this).attr('action');
                var formData = $(this).serialize();

                $('small.form-text').text('');
                $('.form-control').removeClass('is-invalid');

                $.ajax({
                    type: method,
                    url: action,
                    data: formData,
                    beforeSend: function () { 
                        $('input[type="submit"]').attr('disabled', true);
                    },
                    success: function (response) {
                        
                        $.toast({
                            heading: response.alert,
                            text: response.message,
                            icon: response.alert.toLowerCase(),
                            position: 'top-right',
                            stack: false
                        });

                        if (response.alert == 'Success') {
                            window.location.replace('/login');
                        }
                    },
                    complete: function () { 
                        $('input[type="submit"]').attr('disabled', false);
                    },
                    error: function (xhr) {
                        if (xhr.status == 422) {
                            if (typeof(xhr.responseJSON.errors) !== 'undefined') {
                                
                                $.each(xhr.responseJSON.errors, function (key, error) { 
                                    $('small.'+key+'').text(error);
                                    $('#'+key+'').addClass('is-invalid');
                                });

                                if (typeof(xhr.responseJSON.message) !== 'undefined') {
                                    $.toast({
                                        heading: 'Error',
                                        text: xhr.responseJSON.message,
                                        icon: 'error',
                                        position: 'top-right',
                                        stack: false
                                    });
                                }
                            }
                        }
                        else {
                            $.toast({
                                heading: xhr.status,
                                text: xhr.responseText,
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        }
                    }
                });

            });
        });
    </script>
@endpush
