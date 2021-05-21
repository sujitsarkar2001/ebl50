@extends('layouts.user.app')

@section('title', 'Dashboard')

@push('css')
    <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@endpush

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12 text-right">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{$notice->title}}</h3> <br>
                    <strong>{{$notice->created_at->toFormattedDateString()}}</strong>
                </div>
                <div class="card-body">
                    <div class="media">
                        <img class="mr-3" width="30%" src="/uploads/notice/{{$notice->image}}" alt="Generic placeholder image">
                        <div class="media-body">
                            {!! $notice->description !!}
                        </div>
                      </div>
                </div>
            </div>
        </div>
        
    </div>

</section>
<!-- /.content -->

@endsection

@push('js')
    
@endpush