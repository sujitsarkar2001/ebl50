@extends('layouts.admin.app')

@section('title', 'All Money Exchange History')

@push('css')
    <!-- DataTables -->
  <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endpush

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>All Money Exchange History</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">All Money Exchange History</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Money Exchange History</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Amount</th>
                        <th>Charge</th>
                        <th>After Charge</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exchanges as $key => $data)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$data->user->name}}</td>
                            <td>{{$data->user->username}}</td>
                            <td>{{$data->amount}}</td>
                            <td>{{$data->charge}}</td>
                            <td>{{$data->after_charge}}</td>
                            <td>
                                @if ($data->status)
                                    <span class="badge badge-success">Approved</span>
                                @else
                                    <span class="badge badge-danger">Pending</span>
                                @endif  
                            </td>
                            <td>{{date('d-m-Y', strtotime($data->date))}}</td>
                            {{-- <td>

                                @if ($data->status)
                                <a href="#" class="btn btn-warning btn-sm disabled">
                                    <i class="fas fa-thumbs-down"></i>
                                </a>
                                @else
                                <a href="{{ route('admin.withdraw.money.exchange.approved', $data->id) }}" class="btn btn-warning btn-sm" title="Approved">
                                    <i class="fas fa-thumbs-up"></i>
                                </a>
                                @endif

                                <a href="#" class="btn btn-danger btn-sm"
                                    onclick="event.preventDefault();
                                    document.getElementById('delete-form-{{$data->id}}').submit();" title="Delete">
                                    <i class="nav-icon fas fa-trash-alt"></i>
                                </a>
                                <form id="delete-form-{{$data->id}}" action="{{ route('admin.withdraw.money.exchange.destroy', $data->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td> --}}
                        </tr>
                    @endforeach
                    
                </tbody>
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Total: {{$exchanges->sum('amount')}} </th>
                        <th>Total: {{$exchanges->sum('charge')}} </th>
                        <th>Total: {{$exchanges->sum('after_charge')}} </th>
                        <th>Status</th>
                        <th>Date</th>
                </thead>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
      <!-- /.card -->    

</section>
<!-- /.content -->

@endsection

@push('js')
    <!-- DataTables  & Plugins -->
    <script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script>
        $(function () { 
            $("#example1").DataTable();
        })
    </script>
@endpush