@extends('layouts.admin.app')

@section('title', 'Income History')

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
                <h1>Income History</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Income History</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="card-title">Sponsor Income History</h3>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="sponsor" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Refer ID</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
              <!-- /.card -->
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="card-title">Generation Income History</h3>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="generation" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Refer ID</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
              <!-- /.card -->
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="card-title">Level Income History</h3>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="level" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Refer ID</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
              <!-- /.card -->
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="card-title">Daily Income History</h3>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="daily" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Refer ID</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
              <!-- /.card -->
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="card-title">Site Income History</h3>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="site" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Refer ID</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
              <!-- /.card -->
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="card-title">Share Income History</h3>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="share" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Refer ID</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
              <!-- /.card -->
        </div>

    </div>

    <!-- /.card -->

</section>
<!-- /.content -->

@endsection

@push('js')
    <!-- DataTables  & Plugins -->
    <script src="{{asset('/')}}assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('/')}}assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{asset('/')}}assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{asset('/')}}assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script>
        $(function () {

            $('#sponsor').DataTable({
                processing: true,
                serverSide: true,
                "responsive": true,
                "autoWidth": false,
                ajax: '{!! route('admin.sponsor.income.data') !!}',
                columns: [
                    {data: 'DT_RowIndex', searchable: false},
                    {data: 'user.name', name: 'user.name'},
                    {data: 'user.username', name: 'user.username'},
                    {data: 'user.referer_id', name: 'user.referer_id'},
                    {data: 'amount', name: 'amount'},
                    {data: 'date', name: 'date'}
                ]
            });

            $('#generation').DataTable({
                processing: true,
                serverSide: true,
                "responsive": true,
                "autoWidth": false,
                ajax: '{!! route('admin.generation.income.data') !!}',
                columns: [
                    {data: 'DT_RowIndex', searchable: false},
                    {data: 'user.name', name: 'user.name'},
                    {data: 'user.username', name: 'user.username'},
                    {data: 'user.referer_id', name: 'user.referer_id'},
                    {data: 'amount', name: 'amount'},
                    {data: 'date', name: 'date'}
                ]
            });

            $('#daily').DataTable({
                processing: true,
                serverSide: true,
                "responsive": true,
                "autoWidth": false,
                ajax: '{!! route('admin.daily.income.data') !!}',
                columns: [
                    {data: 'DT_RowIndex', searchable: false},
                    {data: 'user.name', name: 'user.name'},
                    {data: 'user.username', name: 'user.username'},
                    {data: 'user.referer_id', name: 'user.referer_id'},
                    {data: 'amount', name: 'amount'},
                    {data: 'date', name: 'date'}
                ]
            });

            $('#level').DataTable({
                processing: true,
                serverSide: true,
                "responsive": true,
                "autoWidth": false,
                ajax: '{!! route('admin.level.income.data') !!}',
                columns: [
                    {data: 'DT_RowIndex', searchable: false},
                    {data: 'user.name', name: 'user.name'},
                    {data: 'user.username', name: 'user.username'},
                    {data: 'user.referer_id', name: 'user.referer_id'},
                    {data: 'amount', name: 'amount'},
                    {data: 'date', name: 'date'}
                ]
            });

            $('#site').DataTable({
                processing: true,
                serverSide: true,
                "responsive": true,
                "autoWidth": false,
                ajax: '{!! route('admin.site.income.data') !!}',
                columns: [
                    {data: 'DT_RowIndex', searchable: false},
                    {data: 'user.name', name: 'user.name'},
                    {data: 'user.username', name: 'user.username'},
                    {data: 'user.referer_id', name: 'user.referer_id'},
                    {data: 'amount', name: 'amount'},
                    {data: 'date', name: 'date'}
                ]
            });

            $('#share').DataTable({
                processing: true,
                serverSide: true,
                "responsive": true,
                "autoWidth": false,
                ajax: '{!! route('admin.share.income.data') !!}',
                columns: [
                    {data: 'DT_RowIndex', searchable: false},
                    {data: 'user.name', name: 'user.name'},
                    {data: 'user.username', name: 'user.username'},
                    {data: 'user.referer_id', name: 'user.referer_id'},
                    {data: 'amount', name: 'amount'},
                    {data: 'date', name: 'date'}
                ]
            });
        })
    </script>
@endpush
