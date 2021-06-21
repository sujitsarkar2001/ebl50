@extends('layouts.admin.app')

@section('title', 'Approved Member List')

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('/')}}assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endpush

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Approved Member</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Member</li>
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
                    <h3 class="card-title">Approved Member List</h3>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="javascript:void(0)" class="btn btn-success" id="add-btn">
                        <i class="fas fa-plus-circle"></i>
                        Add New Member
                    </a>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="data-table" class="table table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Join</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->    

    <input type="hidden" id="member_status" value="approved">

</section>
<!-- /.content -->

@include('admin.user.form')
@include('admin.user.show')

@endsection

@push('js')
    @include('admin.user.script')
@endpush