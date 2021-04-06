@extends('layouts.admin.app')

@section('title', 'User Information')

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
                <h1>Setting</h1>
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
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Application Settings</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header bg-success">
                            <h3 class="card-title">Application Images</h3>
                        </div>
                        <form action="{{route('admin.update.logo')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <label for="logo">Logo</label>
                                <input type="file" name="logo" id="logo"class="form-control @error('logo') is-invalid @enderror" data-default-file="{{'/uploads/setting/'.setting('logo')}}">
                                @error('logo')
                                    <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="card-body">
                                <label for="auth_logo">Login Logo</label>
                                <input type="file" name="auth_logo" id="auth_logo"class="form-control @error('auth_logo') is-invalid @enderror" data-default-file="{{'/uploads/setting/'.setting('auth_logo')}}">
                                @error('auth_logo')
                                    <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="card-body">
                                <label for="favicon">Favicon</label>
                                <input type="file" name="favicon" id="favicon"class="form-control @error('favicon') is-invalid @enderror" data-default-file="{{'/uploads/setting/'.setting('favicon')}}">
                                @error('favicon')
                                    <div class="invalid-feedback text-danger d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-arrow-circle-up"></i>
                                    Update
                                </button>
                            </div>
                        </form>
                        
                    </div>
                </div>
                <div class="col-sm-8">
                    <!-- Default box -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Setting</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{route('admin.setting.update')}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-row">
                                    @foreach ($settings as $key => $setting)
                                        @php
                                            $name = str_replace('_', ' ', $setting->name);
                                        @endphp
                                        <div class="form-group col-md-6 {{$setting->name}}">
                                            <label for="{{$setting->name}}" class="text-capitalize">{{$name}}</label>
                                            <input type="text" class="form-control" id="{{$setting->name}}" name="{{$setting->name}}" placeholder="{{$name}}" value="{{$setting->value}}"> 
                                        </div>
                                        
                                    @endforeach
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-arrow-circle-up"></i>
                                    Update
                                </button>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
    
    

</section>
<!-- /.content -->

@endsection

@push('js')
    <script src="{{ asset('/assets/plugins/dropify/dropify.min.js') }}"></script>
    <script>
        
        $(document).ready(function() {
            $('input[type="file"]').dropify();
            $('.col-md-6.logo').remove();
            $('.col-md-6.auth_logo').remove();
            $('.col-md-6.favicon').remove();
        });

    </script>
@endpush