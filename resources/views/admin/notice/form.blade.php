@extends('layouts.admin.app')

@section('title')
    @isset($notice)
        Edit Notice 
    @else 
        Add Notice
    @endisset
@endsection


@push('css')
    <!-- summernote -->
   <link rel="stylesheet" href="/assets/plugins/summernote/summernote-bs4.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" />
   <style>
       .dropify-wrapper .dropify-message p {
           font-size: initial;
       }
   </style>
@endpush

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    @isset($notice)
                        Edit Notice 
                    @else 
                        Add Notice
                    @endisset
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">
                        @isset($notice)
                            Edit Notice 
                        @else 
                            Add Notice
                        @endisset
                    </li>
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
                    <h3 class="card-title">
                        @isset($notice)
                            Edit Notice Details
                        @else 
                            Add New Notice
                        @endisset
                    </h3>
                </div>
                <div class="col-sm-6 text-right">
                    @isset($notice)
                        <a href="{{route('admin.notice.show', $notice->id)}}" class="btn btn-info">
                            <i class="fas fa-eye"></i>
                            Show
                        </a>
                    @endisset
                    <a href="{{route('admin.notice.index')}}" class="btn btn-danger">
                        
                        <i class="fas fa-long-arrow-alt-left"></i>
                        Back to List
                    </a>
                </div>
            </div>
        </div>
        <form action="{{ isset($notice) ? route('admin.notice.update', $notice->id) : route('admin.notice.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @isset($notice)
                @method('PUT')
            @endisset
            <div class="card-body">
                <div class="form-group">
                    <label for="title" class="">Title:</label>
                    <input type="text" name="title" id="title" placeholder="Enter notice title" class="form-control @error('title') is-invalid @enderror" value="{{$notice->title ?? old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="">Description:</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ $notice->description ?? old('description') }}</textarea>
                    
                    @error('description')
                        <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="file" name="image" id="image"class="form-control @error('image') is-invalid @enderror" data-default-file="@isset($notice) /uploads/notice/{{$notice->image}}@enderror">
                    @error('image')
                        <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                    @enderror
                </div>

            </div>
            <div class="card-footer">
                <div class="form-group">
                    <button class="mt-1 btn btn-primary">
                        @isset($notice)
                            <i class="fas fa-arrow-circle-up"></i>
                            Update
                        @else
                            <i class="fas fa-plus-circle"></i>
                            Submit
                        @endisset
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

@endsection

@push('js')
    <!-- Summernote -->
    <script src="/assets/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="{{ asset('/assets/plugins/dropify/dropify.min.js') }}"></script>
    <script>
        $(function () {
            $('#description').summernote();
            $('#image').dropify();
        });
    </script>
@endpush