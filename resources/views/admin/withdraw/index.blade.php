@extends('layouts.admin.app')

@section('title', 'Withdraw History')

@push('css')
    <!-- DataTables -->
  <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Username</th>
                        <th>Amount</th>
                        <th>Charge</th>
                        <th>Total</th>
                        <th>Method</th>
                        <th>Holder Name</th>
                        <th>AC</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($withdraws as $key => $data)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$data->user->username}}</td>
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
                            <td>{{date('d-m-Y', strtotime($data->date))}}</td>
                            
                            <td>

                                @if ($data->status == 0)
                                <a href="{{ route('admin.withdraw.approved', $data->id) }}" class="btn btn-warning btn-sm" title="Approved">
                                    <i class="fas fa-thumbs-up"></i>
                                </a>
                                @else
                                <a href="#" class="btn btn-warning btn-sm disabled">
                                    <i class="fas fa-thumbs-down"></i>
                                </a>
                                @endif
                                
                                @if($data->status == false)
                                    <a href="{{ route('admin.withdraw.edit', $data->id) }}" class="btn btn-info btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                                
                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th>SL</th>
                        <th class="text-right">Total:</th>
                        <th>{{$withdraws->sum('amount')}}</th>
                        <th>{{$withdraws->sum('charge')}}</th>
                        <th>{{$withdraws->sum('after_charge')}}</th>
                        <th></th>
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
    <script src="/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/assets/plugins/jszip/jszip.min.js"></script>
    <script src="/assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="/assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
        $(function () { 
            $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["csv", "excel", "pdf", "print",]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        })
    </script>
@endpush