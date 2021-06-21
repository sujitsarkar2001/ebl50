@extends('auth.layouts.app')

@section('title', 'Password Update')

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
        <form action="{{route('password.update')}}" method="POST" id="form-submit">
            @csrf
            <div class="title">Password Update</div>
            <input type="hidden" name="username" id="username" class="form-control mb-0 @error('username')is-invalid @enderror" required  value="{{ $username ?? old('username') }}"/>
            <div class="form-group">
                <label for="password">New Password</label>
                <input  type="password" name="password" id="password" class="form-control mb-0 @error('password')is-invalid @enderror" required />
                <small class="form-text text-danger password"></small>
                @error('password')
                    <small class="form-text text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Confirm Password</label>
                <input  type="password" name="password_confirmation" id="password-confirm" class="form-control mb-0" required />

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
