@extends('layouts.admin.app')

@section('title', 'Add Service')

@push('css')
    <!-- summernote -->
   <link rel="stylesheet" href="/assets/plugins/summernote/summernote-bs4.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" />
   <style>
        input[type="file"] {
            display: block;
        }
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
        .remove_photo, .remove_video {
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
        .remove_video:hover {
            background: white;
            color: black;
        }
   </style>
@endpush

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Service</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active"> Add Service</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    @if($errors->any())
        {{ implode('', $errors->all('<div>:message</div>')) }}
    @endif

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="card-title">Add New Service</h3>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('admin.service.index')}}" class="btn btn-danger">
                        
                        <i class="fas fa-long-arrow-alt-left"></i>
                        Back to List
                    </a>
                </div>
            </div>
        </div>
        <form action="{{ route('admin.service.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">

                <div class="form-group">
                    <label for="contents">Contents:</label>
                    <textarea name="contents" id="contents" class="form-control @error('contents') is-invalid @enderror"></textarea>
                    
                    @error('contents')
                        <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="photo">Photo:</label>
                    <input type="file" name="photos[]" multiple id="photo" class="form-control @error('photos') is-invalid @enderror" accept="image/*">
                    @error('photos')
                        <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="video">Video:</label>
                    <input type="file" name="videos[]" multiple id="video" class="form-control @error('videos') is-invalid @enderror" accept="video/*">
                    @error('videos')
                        <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                    @enderror
                </div>
                
            </div>
            <div class="card-footer">
                <div class="form-group">
                    <button class="mt-1 btn btn-primary">
                        <i class="fas fa-plus-circle"></i>
                        Submit
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
            $('#contents').summernote({
                height: 200
            })
            
            if (window.File && window.FileList && window.FileReader) {
                
                $("#photo").on("change", function(e) {
                    var files = e.target.files,
                    filesLength = files.length;

                    for (var i = 0; i < filesLength; i++) {
                        var f = files[i]
                        var fileReader = new FileReader();
                        fileReader.onload = (function(e) {
                            var file = e.target;
                            $("<span class=\"pip\">" +
                                "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                                "<br/><span class=\"remove_photo\">Remove image</span>" +
                                "</span>").insertAfter("#photo");
                            $(".remove_photo").click(function(){
                                $(this).parent(".pip").remove();
                            });
                            
                            // Old code here
                            /*$("<img></img>", {
                                class: "imageThumb",
                                src: e.target.result,
                                title: file.name + " | Click to remove"
                            }).insertAfter("#files").click(function(){$(this).remove();});*/
                        
                        });
                        fileReader.readAsDataURL(f);
                    }
                });

                $("#video").on("change", function(e) {
                    var files = e.target.files,
                    filesLength = files.length;

                    for (var i = 0; i < filesLength; i++) {
                        var f = files[i]
                        var fileReader = new FileReader();
                        fileReader.onload = (function(e) {
                            var file = e.target;
                            let html = '';
                            html += '<span class="pip">';
                            html += '<video width="400" controls="controls" preload="metadata">';
                            html += '<source src="'+e.target.result+'" type="video/mp4">';
                            html += '</video>';
                            html += '<br/><span class="remove_video">Remove Video</span>';
                            html += '</span>';
                            
                            $(html).insertAfter("#video");
                            $(".remove_video").click(function(){
                                $(this).parent(".pip").remove();
                            });
                        });
                        fileReader.readAsDataURL(f);
                    }
                });

            } else {
                alert("Your browser doesn't support to File API")
            }
        });
    </script>
@endpush