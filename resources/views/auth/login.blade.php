@extends('auth.layouts.app')

@section('title', 'Login')

@section('content')

<div id="login_page_landing" class="login-page">
    <div class="login-page_landing">
        <div class="login_page_title">
            <h1>WELCOME !</h1>
        </div>
        <div class="logo-area text-center">
            
            <img src="{{asset('/')}}uploads/setting/{{setting('auth_logo')}}" alt="" class="m-auto">
        </div>
        <div class="get_start text-center">
            <p class="start_button">GET START <i class="fas fa-arrow-right"></i></p>
        </div>
    </div>
</div>

<div class="login-form" id="form">
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
        <form action="{{route('login')}}" method="POST" id="form-submit">
            @csrf
            <div class="title">Login</div>
            <div class="form-group">
                <label for="username">Your Username</label>
                <input type="text" name="username" id="username" class="form-control mb-0" required value="{{old('username')}}"/>
                <small class="form-text text-danger username"></small>
                @error('username')
                    <small class="form-text text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Your Password</label>
                <input  type="password" name="password" id="password" class="form-control mb-0" required />
                <small class="form-text text-danger password"></small>
                @error('password')
                    <small class="form-text text-danger">{{$message}}</small>
                @enderror
            </div>
            <div style="display: flex;" class="form-group">
                <div class="rem">
                    <input style="width: initial;opacity: 0;" type="checkbox" name="remember" id="remember">
                    <label class="check" for="remember">REMEMBER ME</label>
                </div>
                <div class="forget">
                    <a href="{{route('password.request')}}">FORGET PASSWORD</a>
                </div>
            </div>
            <div class="form-group">
                <input type="submit" value="Submit" />
            </div>
            <p>Don't haven't account <a href="{{route('register')}}">create a account</a></p>
        </form>
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
                            window.location.replace(response.redirect);
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