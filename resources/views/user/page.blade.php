@extends('layouts.user.app')

@section('title', $page->name)

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="">{{$page->name}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">{{$page->name}}</li>
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
            <h3 class="card-title">{{$page->name}}</h3>

        </div>
        <div class="card-body">
            {!! $page->body !!}
        </div>
        <!-- /.card-body -->
        
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

@endsection