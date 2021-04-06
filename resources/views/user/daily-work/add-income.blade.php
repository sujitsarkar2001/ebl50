@extends('layouts.user.app')

@section('title', 'Dashboard')

@push('css')
    
@endpush

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Watch Video</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Watch Video</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-sm-4 offset-sm-4">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daily Work Income</h3>
                    
                    <div class="float-right">
                        <a href="{{route('add.watch',['slug' => $video->slug, 'id' => $video->id])}}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            Add Income
                        </a>
                    </div>
                    
                </div>
                <div class="card-body">
                    <iframe width="100%" height="300px" src="{{$video->link}}"> </iframe>
                            
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    

</section>
<!-- /.content -->

@endsection

@push('js')
    
@endpush