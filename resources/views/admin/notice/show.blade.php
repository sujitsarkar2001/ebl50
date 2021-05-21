@extends('layouts.admin.app')

@section('title', 'Notice Information')


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Notice Information</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Show Notice</li>
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
                    <h3 class="card-title">Notice Information</h3>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('admin.notice.edit', $notice->id)}}" class="btn btn-info">
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>
                    <a href="{{route('admin.notice.index')}}" class="btn btn-danger">
                        
                        <i class="fas fa-long-arrow-alt-left"></i>
                        Back to List
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <tbody>
                    <tr>
                        <th>Image</th>
                        <td>
                            <img src="/uploads/notice/{{$notice->image}}" alt="{{$notice->title}}" width="150px" height="150px">
                        </td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td>{{$notice->title}}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{!!$notice->description!!}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($notice->status)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Disable</span>
                            @endif    
                        </td>
                    </tr>
                </tbody>
            </table>
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