@extends('layouts.admin.app')

@section('title', 'User Information')

@push('css')
    <style>
        .contact-title {
            display: inline-block;
            padding-bottom: 9px;
            width: 170px;
            font-size: 14px;
            color: #868e96;
        }
        <style>
        .imageThumb {
            max-height: 75px;
            border: 2px solid;
            padding: 1px;
            cursor: pointer;
        }
        .pip {
            display: inline-block;
            margin: 10px 10px 0 0;
        }
        .remove_photo {
            display: block;
            background: #444;
            border: 1px solid black;
            color: white;
            text-align: center;
            cursor: pointer;
        }
        .remove_photo:hover {
            background: white;
            color: black;
        }
    </style>
    </style>
@endpush

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>My Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">My Profile</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="card-title">My Profile</h3>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h3 class="card-title">Your Information</h3>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <a href="javascript:void(0)" class="mt-1 btn btn-primary" id="btn-profile">
                                        <i class="fas fa-arrow-circle-up"></i>
                                        Update
                                    </a>
                                    <a href="javascript:void(0)" class="mt-1 btn btn-danger" id="btn-password">
                                        <i class="fas fa-key nav-icon"></i>
                                        Change Password
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="user-profile">
                                <div class="row">
                
                                    <div class="col-lg-12">
                
                                        <h4 class="card-title">Basic information</h4>
                                        <br>
                                        <div class="user-photo m-b-30">
                                              
                                        </div>
                                        <div class="mb-1">
                                            <span class="contact-title">Username:</span>
                                            <span class="username"></span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Name:</span>
                                            <span class="name"></span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Phone:</span>
                                            <span class="phone"></span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Email:</span>
                                            <span class="email"></span>
                                        </div>
                                        
                                        
                                        <div class="">
                                            <span class="contact-title">Status:</span>
                                            <span class="status"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<!-- add/update modal -->
<div class="modal fade" id="profile-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Profile Information</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.profile.update.info')}}" method="post" id="form-profile" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{auth()->user()->name}}" placeholder="Name">
                        <small class="form-text text-danger name"></small>
                    </div>
                    
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" value="{{auth()->user()->username}}" placeholder="Username">
                        <small class="form-text text-danger username"></small>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{auth()->user()->email}}" placeholder="example@gmail.com">
                        <small class="form-text text-danger email"></small>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" maxlength="25" value="{{auth()->user()->phone}}" placeholder="Phone Number">
                        <small class="form-text text-danger phone"></small>
                    </div>
                    <div class="form-group">
                        <label for="avatar">Avatar</label>
                        <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="avatar" name="avatar">
                              <label class="custom-file-label" for="avatar">Choose file</label>
                            </div>
                        </div>
                        <small class="form-text text-danger avatar"></small>
                        <div class="pip-area"></div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- add/update modal -->
<div class="modal fade" id="passowrd-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Profile Information</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.profile.password.update')}}" method="post" id="form-passowrd">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="current_password" class="">Current Password:</label>
                        <input type="password" name="current_password" id="current_password" placeholder="Current Password" class="form-control">
                        <small class="form-text text-danger current_password"></small>
                        
                    </div>
    
                    <div class="form-group">
                        <label for="password" class="">New Password:</label>
                        <input type="password" name="password" id="password" placeholder="New Password" class="form-control">
                        <small class="form-text text-danger password"></small>
                    </div>
    
                    <div class="form-group">
                        <label for="password_confirmation" class="">Confirm Password:</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" class="form-control"> 
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection

@push('js')
    <script>
        $(document).ready(function () {

            $(document).on('click', '#btn-profile', function (e) {
                e.preventDefault();

                $('#profile-modal').modal('show');

                $('small.form-text').text('');
                $('.form-control, .custom-file-input').removeClass('is-invalid');

            });

            $(document).on('click', '#btn-password', function (e) {
                e.preventDefault();

                $('#passowrd-modal').modal('show');

                $('small.form-text').text('');
                $('.form-control').removeClass('is-invalid');

            });
            
            $(document).on('submit', '#form-profile', function(e) {
                e.preventDefault();

                let method   = $(this).attr('method');
                let action   = $(this).attr('action');
                var formData = new FormData($(this)[0]);

                $('small.form-text').text('');
                $('.form-control, .custom-file-input').removeClass('is-invalid');

                $.ajax({
                    type: method,
                    url: action,
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    beforeSend: function () { 
                        $('button[type="submit"]').attr('disabled', true);
                    },
                    success: function (response) {
                        $.toast({
                            heading: 'Congratulations',
                            text: response.message,
                            icon: response.alert.toLowerCase(),
                            position: 'top-right',
                            stack: false
                        });
                        getAdminInformation();
                        $('#profile-modal').modal('hide');

                    },
                    complete: function () { 
                        $('button[type="submit"]').attr('disabled', false);
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
            
            $(document).on('submit', '#form-passowrd', function(e) {
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
                        $('button[type="submit"]').attr('disabled', true);
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
                            $('#profile-modal').modal('hide');
                            // window.location.replace("/login");
                            location.reload();
                        }
                    },
                    complete: function () { 
                        $('button[type="submit"]').attr('disabled', false);
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

            function getAdminInformation()
            {
                $.ajax({
                    type: "GET",
                    url: '{!! route('admin.profile.get.info') !!}',
                    dataType: "JSON",
                    success: function (response) {
                        console.log(response);
                        $.each(response, function (key, val) { 
                            if (key != 'avatar') {
                                $('span.'+key+'').text(val);
                                $('input#'+key+'').val(val);
                            }
                            
                        });

                        if (response.status) {
                            $('span.status').html('<span class="badge badge-success">Active</span>');
                        } else {
                            $('span.status').html('<span class="badge badge-danger">Disable</span>');
                        }

                        let img = '';
                        if (response.avatar != 'default.png') {
                            
                            img += '<img src="/uploads/member/'+response.avatar+'">';

                        } else {
                            img += '<img src="/default/user.jpg">';
                        }

                        $( '.user-photo').html(img);
                    },
                    error: function (xhr) {
                        $.toast({
                            heading: xhr.status,
                            text: xhr.responseText,
                            icon: 'error',
                            position: 'top-right',
                            stack: false
                        });
                    }
                });
            }
            getAdminInformation();


            if (window.File && window.FileList && window.FileReader) {
                
                $("#avatar").on("change", function(e) {
                    var files = e.target.files,
                    filesLength = files.length;

                    $(".pip").remove();

                    for (var i = 0; i < filesLength; i++) {
                        var f = files[i]
                        var fileReader = new FileReader();
                        fileReader.onload = (function(e) {
                            var file = e.target;
                            $('.pip-area').html("<span class=\"pip\">" +
                                "<img width=\"100%\" height=\"200px\" class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/ >" +
                                "<br/><span class=\"remove_photo\">Remove image</span>" +
                                "</span>");
                            
                            $(".remove_photo").click(function(){
                                $(this).parent(".pip").remove();
                                $("#avatar").val('');
                            });
                        });
                        fileReader.readAsDataURL(f);
                    }
                });
            }
        });
    </script>
@endpush