@extends('layouts.admin.app')

@section('title', 'Reply Contact')


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Reply Contact</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Reply Contact</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="card-title">Reply Contact</h3>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <form action="{{route('admin.connection.reply.contact')}}" method="post">
            @csrf
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="from">From</label>
                        <input type="email" name="from" class="form-control @error('from') is-invalid @enderror" value="{{config('mail.from.address')}}" readonly>
                        @error('from')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="to">To</label>
                        <input type="email" name="to" id="to" class="form-control @error('to') is-invalid @enderror" value="{{$contact->email}}" readonly>
                        
                        @error('to')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea name="message" id="message" class="form-control @error('message') is-invalid @enderror" rows="7"></textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <input type="hidden" name="contact_id" value="{{$contact->id}}">
                <button class="mt-1 btn btn-primary">
                    <i class="fas fa-location-arrow"></i>
                    Reply
                </button>
            </div>
        </form>
        
        
    </div>
      <!-- /.card -->    

</section>
<!-- /.content -->

@endsection
