@extends('layouts.user.app')

@section('title', 'Withdraw History')

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
                <h1>Withdraw History</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Withdraw History</li>
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
                    <h3 class="card-title">Withdraw History</h3>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('withdraw.create')}}" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i>
                        Withdraw Now
                    </a>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Amount</th>
                        <th>Charge</th>
                        <th>After Charge</th>
                        <th>Method</th>
                        <th>Holder Name</th>
                        <th>Account Number</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($withdraws as $key => $data)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$data->amount}}</td>
                            <td>{{$data->charge}}</td>
                            <td>{{$data->after_charge}}</td>
                            <td>{{$data->method}}</td>
                            <td>{{$data->holder_name}}</td>
                            <td>{{$data->account_number}}</td>
                            <td>
                                @if ($data->status)
                                    <span class="badge badge-success">Paid</span>
                                @else
                                    <span class="badge badge-danger">Pending</span>
                                @endif  
                            </td>
                            <td>{{date('d-m-y', strtotime($data->date))}}</td>
                            
                            {{-- <td>

                                <a href="{{ route('withdraw.edit', $data->id) }}" class="btn btn-info btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td> --}}
                        </tr>
                    @endforeach
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total:</th>
                        <th>{{$withdraws->sum('amount')}}</th>
                        <th>{{$withdraws->sum('charge')}}</th>
                        <th>{{$withdraws->sum('after_charge')}}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
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