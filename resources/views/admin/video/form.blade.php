@extends('layouts.admin.app')

@section('title')
    @isset($video)
        Edit Video 
    @else 
        Add Video
    @endisset
@endsection


@push('css')
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
                    @isset($video)
                        Edit Video 
                    @else 
                        Add Video
                    @endisset
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">
                        @isset($video)
                            Edit Video 
                        @else 
                            Add Video
                        @endisset
                    </li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-sm-6 @isset($video) @else offset-sm-3 @endisset">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="card-title">
                                @isset($video)
                                    Edit Video Details
                                @else 
                                    Add New Video
                                @endisset
                            </h3>
                        </div>
                        <div class="col-sm-6 text-right">
                            @isset($page)
                                <a href="{{route('admin.video.show', $video->id)}}" class="btn btn-info">
                                    <i class="fas fa-eye"></i>
                                    Edit
                                </a>
                            @endisset
                            <a href="{{route('admin.video.index')}}" class="btn btn-danger">
                                
                                <i class="fas fa-long-arrow-alt-left"></i>
                                Back to List
                            </a>
                        </div>
                    </div>
                </div>
                <form action="{{ isset($video) ? route('admin.video.update', $video->id) : route('admin.video.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @isset($video)
                        @method('PUT')
                    @endisset
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label for="title" class="">Title:</label>
                            <input type="title" name="title" id="title" placeholder="Enter title" class="form-control @error('title') is-invalid @enderror" value="{{ $video->title ?? old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="link" class="">Video Link:</label>
                            <input type="text" name="link" id="link" placeholder="Enter video link" class="form-control @error('link') is-invalid @enderror" value="{{ $video->link ?? old('link') }}" required>
                            @error('link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="thumbnail" class="">Thumbnail:</label>
                            <input type="file" name="thumbnail" id="thumbnail"class="form-control @error('thumbnail') is-invalid @enderror" data-default-file="@isset($video){{'/uploads/video/'.$video->thumbnail}}@endisset">
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group">
                            <button class="mt-1 btn btn-primary">
                                @isset($video)
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
        </div>

        @isset($video)
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Video</h3>
                </div>
                <div class="card-body">
                    <iframe width="100%" height="300px" src="{{$video->link}}"> </iframe>
                </div>
                <div class="card-footer">
                    <a href="{{$video->link}}" class="btn" target="_blank" rel="noopener noreferrer">Go Link</a>
                </div>
            </div>
        </div>
        @endisset
        
    </div>

</section>
<!-- /.content -->

@endsection

@push('js')
    <script src="{{ asset('/assets/plugins/dropify/dropify.min.js') }}"></script>
    <script>
        
        $(document).ready(function() {
            $('#thumbnail').dropify();
        });

    </script>
@endpush