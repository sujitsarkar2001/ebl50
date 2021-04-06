@extends('layouts.admin.app')

@section('title')
    @isset($page)
        Edit Page 
    @else 
        Add Page
    @endisset
@endsection


@push('css')
    <!-- summernote -->
   <link rel="stylesheet" href="/assets/plugins/summernote/summernote-bs4.min.css">
@endpush

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    @isset($page)
                        Edit Page 
                    @else 
                        Add Page
                    @endisset
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">
                        @isset($page)
                            Edit Page 
                        @else 
                            Add Page
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
                        @isset($page)
                            Edit Page Details
                        @else 
                            Add New Page
                        @endisset
                    </h3>
                </div>
                <div class="col-sm-6 text-right">
                    @isset($page)
                        <a href="{{route('admin.page.show', $page->id)}}" class="btn btn-info">
                            <i class="fas fa-eye"></i>
                            Edit
                        </a>
                    @endisset
                    <a href="{{route('admin.page.index')}}" class="btn btn-danger">
                        
                        <i class="fas fa-long-arrow-alt-left"></i>
                        Back to List
                    </a>
                </div>
            </div>
        </div>
        <form action="{{ isset($page) ? route('admin.page.update', $page->id) : route('admin.page.store') }}" method="POST">
            @csrf
            @isset($page)
                @method('PUT')
            @endisset
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="">Name:</label>
                    <input type="text" name="name" id="name" placeholder="Enter Page Name" class="form-control @error('name') is-invalid @enderror" value="{{ $page->name ?? old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="body" class="">Body:</label>
                    <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror">{{ $page->body ?? old('body') }}</textarea>
                    
                    @error('body')
                        <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="meta_description" class="">Meta Description (optional):</label>
                    <textarea name="meta_description" id="meta_description" class="form-control @error('meta_description') is-invalid @enderror">{{ $page->meta_description ?? old('meta_description') }}</textarea>
                    
                    @error('meta_description')
                    <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="meta_keywords" class="">Meta Keywords (optional):</label>
                    <textarea name="meta_keywords" id="meta_keywords" class="form-control @error('meta_keywords') is-invalid @enderror">{{ $page->meta_keywords ?? old('meta_keywords') }}</textarea>
                    
                    @error('meta_keywords')
                    <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="status" id="status" @isset ($page) {{ $page->status == true ? 'checked':'' }}  @endisset >
                        <label class="custom-control-label" for="status">Status</label>
                    </div>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <div class="form-group">
                    <button class="mt-1 btn btn-primary">
                        @isset($page)
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
    <script>
        $(function () {
            $('#body').summernote()
        });
    </script>
@endpush