@extends('layouts.admin.app')

@section('title', 'Page Information')


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Page Information</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Show Page</li>
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
                    <h3 class="card-title">Page Information</h3>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('admin.page.edit', $page->id)}}" class="btn btn-info">
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>
                    <a href="{{route('admin.page.index')}}" class="btn btn-danger">
                        
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
                        <th>Name</th>
                        <td>{{$page->name}}</td>
                    </tr>
                    <tr>
                        <th>Body</th>
                        <td>{!! $page->body !!}</td>
                    </tr>
                    <tr>
                        <th>Meta Description</th>
                        <td>{{$page->meta_description}}</td>
                    </tr>
                    <tr>
                        <th>Meta Keywords</th>
                        <td>{{$page->meta_keywords}}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($page->status)
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