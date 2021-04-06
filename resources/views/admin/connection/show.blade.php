@extends('layouts.admin.app')

@section('title', 'Contact Information')


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Contact Information</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Contact Information</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="card-title">Contact Information</h3>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td>{{$contact->user->name}}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{$contact->user->username}}</td>
                    </tr>
                    <tr>
                        <th>Refer Code</th>
                        <td>{{$contact->user->referer_id}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{$contact->email}}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($contact->status)
                                <span class="badge badge-success">Seen</span>
                            @else
                                <span class="badge badge-danger">Pending</span>
                            @endif  
                        </td>
                    </tr>
                    <tr>
                        <th>Subject</th>
                        <td>{{$contact->subject}}</td>
                    </tr>
                    <tr>
                        <th>Message</th>
                        <td>{{$contact->message}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
      <!-- /.card -->

    @foreach ($contact->contact_replies as $contact_reply)
    
    <div class="card">
        <div class="card-header">
            Reply Message
        </div>
        <div class="card-body">
            {{$contact_reply->message}}
        </div>
        
    </div>
    
    @endforeach
    

</section>
<!-- /.content -->

@endsection
