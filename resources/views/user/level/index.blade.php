@extends('layouts.user.app')

@section('title', 'User Level')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>User Level</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">User Level</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Level List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SL Number</th>
                                <th>Level</th>
                                <th>Member</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($levels as $key => $level)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td> <a href="{{route('level.user', $level['slug'])}}">{{$level['name']}}</a> </td>
                                    <td>{{$level['members']}}</td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

@endsection
