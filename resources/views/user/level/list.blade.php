@extends('layouts.user.app')

@section('title', ucwords($name) .' Level Members')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ucwords($name)}} Level Members</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">User Level</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        @forelse ($users as $key => $user)
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="media">
                            <img class="align-self-center mr-2" width="50px" src="{{$user->avatar != 'default.png' ? '/uploads/member/'.$user->avatar:'/default/user.jpg'}}" alt="Image">
                            <div class="media-body">
                                <h5 class="m-0">{{$user->name}}</h5>
                                <p class="mb-0">Username: {{$user->username}} </p>
                                <p class="mb-0">Date: {{date('d M Y', strtotime($user->joining_date))}} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12 text-danger">
                <div class="card">
                    <div class="card-body">
                        Members not available
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</section>
<!-- /.content -->

@endsection
