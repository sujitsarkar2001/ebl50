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
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="user-profile">
                                <div class="row">
                
                                    <div class="col-lg-12">
                
                                        <h4 class="card-title">Basic information</h4>
                                        <br>
                                        <div class="user-photo m-b-30">
                                            <img src="{{Auth::user()->avatar != 'default.png' ? '/uploads/member/'.Auth::user()->avatar:'/default/user.jpg'}}" class="img-fluid" alt="User Image"> 
                                                
                                        </div>
                                        <div class="mb-1">
                                            <span class="contact-title">Username:</span>
                                            <span>{{Auth::user()->username}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Name:</span>
                                            <span>{{Auth::user()->name}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Phone:</span>
                                            <span>{{Auth::user()->phone}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Email:</span>
                                            <span>{{Auth::user()->email}}</span>
                                        </div>
                                        
                                        
                                        <div class="">
                                            <span class="contact-title">Status:</span>
                                            @if (Auth::user()->status)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Disable</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group">
                                <a href="{{route('admin.profile.update')}}" class="mt-1 btn btn-primary">
                                    
                                    <i class="fas fa-arrow-circle-up"></i>
                                    Update
                                </a>
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

@endsection

@push('js')
    <!-- Summernote -->
    <script src="/assets/plugins/summernote/summernote-bs4.min.js"></script>
    <script>
        $(function () {
            $('#body').summernote()
        });
    </script>
@endpush