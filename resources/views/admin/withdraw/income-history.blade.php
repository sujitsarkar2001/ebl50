@extends('layouts.admin.app')

@section('title', 'Income History')

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

        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    Search History
                </div>
                <form action="{{route('admin.withdraw.income.search')}}" method="get">
                    
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <input type="text" name="username" class="form-control" placeholder="Enter username">
                            </div>
                            <div class="form-group col-md-3">
                                <input type="text" name="refer_id" class="form-control" placeholder="Refer ID">
                            </div>
                            <div class="form-group col-md-3">
                                <input type="date" name="from_date" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <input type="date" name="to_date" class="form-control">
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <div class="form-group mb-0">
                            <button class="mt-1 btn btn-primary">
                                <i class="fas fa-search"></i>
                                Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

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
                    <table id="example1" class="table table-bordered table-striped">
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
                        <tbody>
                            @if (session('sponsors'))
                                @foreach (session('sponsors') as $key => $data)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$data->user->username}}</td>
                                        <td>{{$data->user->name}}</td>
                                        <td>{{$data->user->referer_id}}</td>
                                        <td>{{$data->amount}}</td>
                                        <td>{{date('d-m-Y', strtotime($data->date))}}</td>
                                        {{-- <td>
                                            <a href="#" class="btn btn-danger btn-sm"
                                                onclick="event.preventDefault();
                                                alert('Are You Sure Delete This Data!!');
                                                document.getElementById('delete-form-{{$data->id}}').submit();" title="Delete">
                                                <i class="nav-icon fas fa-trash-alt"></i>
                                            </a>
                                            <form id="delete-form-{{$data->id}}" action="" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            @else
                                @foreach ($sponsors as $key => $data)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$data->user->username}}</td>
                                        <td>{{$data->user->name}}</td>
                                        <td>{{$data->user->referer_id}}</td>
                                        <td>{{$data->amount}}</td>
                                        <td>{{date('d-m-Y', strtotime($data->date))}}</td>
                                        {{-- <td>
                                            <a href="#" class="btn btn-danger btn-sm"
                                                onclick="event.preventDefault();
                                                alert('Are You Sure Delete This Data!!');
                                                document.getElementById('delete-form-{{$data->id}}').submit();" title="Delete">
                                                <i class="nav-icon fas fa-trash-alt"></i>
                                            </a>
                                            <form id="delete-form-{{$data->id}}" action="" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            @endif
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SL</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Refer ID</th>
                                <th>Total Amount: 
                                    @if (session('sponsors'))
                                        {{session('sponsors')->sum('amount')}}
                                    @else
                                        {{$sponsors->sum('amount')}}
                                    @endif
                                </th>
                                <th>Date</th>
                            </tr>
                        </tfoot>
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
                    <table id="example2" class="table table-bordered table-striped">
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
                        <tbody>
                            @if (session('generations'))
                                @foreach (session('generations') as $key => $data)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$data->user->username}}</td>
                                        <td>{{$data->user->name}}</td>
                                        <td>{{$data->user->referer_id}}</td>
                                        <td>{{$data->amount}}</td>
                                        <td>{{date('d-m-Y', strtotime($data->date))}}</td>
                                        {{-- <td>
                                            <a href="#" class="btn btn-danger btn-sm"
                                                onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{$data->id}}').submit();" title="Delete">
                                                <i class="nav-icon fas fa-trash-alt"></i>
                                            </a>
                                            <form id="delete-form-{{$data->id}}" action="{{ route('admin.withdraw.destroy', $data->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            @else
                                @foreach ($generations as $key => $data)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$data->user->username}}</td>
                                        <td>{{$data->user->name}}</td>
                                        <td>{{$data->user->referer_id}}</td>
                                        <td>{{$data->amount}}</td>
                                        <td>{{date('d-m-Y', strtotime($data->date))}}</td>
                                        {{-- <td>
                                            <a href="#" class="btn btn-danger btn-sm"
                                                onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{$data->id}}').submit();" title="Delete">
                                                <i class="nav-icon fas fa-trash-alt"></i>
                                            </a>
                                            <form id="delete-form-{{$data->id}}" action="{{ route('admin.withdraw.destroy', $data->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td> --}}
                                    </tr>
                                @endforeach 
                            @endif
                            
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SL</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Refer ID</th>
                                <th>Total Amount: 
                                    @if (session('generations'))
                                        
                                    @else
                                        {{$generations->sum('amount')}}
                                    @endif
                                </th>
                                <th>Date</th>
                            </tr>
                        </tfoot>
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
                    <table id="example3" class="table table-bordered table-striped">
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
                        <tbody>
                            @if (session('levels'))
                                @foreach (session('levels') as $key => $data)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$data->user->username}}</td>
                                        <td>{{$data->user->name}}</td>
                                        <td>{{$data->user->referer_id}}</td>
                                        <td>{{$data->amount}}</td>
                                        <td>{{date('d-m-Y', strtotime($data->date))}}</td>
                                        {{-- <td>
                                            <a href="#" class="btn btn-danger btn-sm"
                                                onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{$data->id}}').submit();" title="Delete">
                                                <i class="nav-icon fas fa-trash-alt"></i>
                                            </a>
                                            <form id="delete-form-{{$data->id}}" action="{{ route('admin.withdraw.destroy', $data->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td> --}}
                                    </tr>
                                @endforeach 
                            @else
                                @foreach ($levels as $key => $data)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$data->user->username}}</td>
                                        <td>{{$data->user->name}}</td>
                                        <td>{{$data->user->referer_id}}</td>
                                        <td>{{$data->amount}}</td>
                                        <td>{{date('d-m-Y', strtotime($data->date))}}</td>
                                        {{-- <td>
                                            <a href="#" class="btn btn-danger btn-sm"
                                                onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{$data->id}}').submit();" title="Delete">
                                                <i class="nav-icon fas fa-trash-alt"></i>
                                            </a>
                                            <form id="delete-form-{{$data->id}}" action="{{ route('admin.withdraw.destroy', $data->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            @endif
                            
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SL</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Refer ID</th>
                                <th>Total Amount: 
                                    @if (session('levels'))
                                        
                                    @else
                                        {{$levels->sum('amount')}}
                                    @endif
                                </th>
                                <th>Date</th>
                            </tr>
                        </tfoot>
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
                    <table id="example4" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (session('dailies'))
                                @foreach (session('dailies') as $key => $data)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$data->username}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{date('d-m-Y', strtotime($data->date))}}</td>
                                        
                                    </tr>
                                @endforeach 
                            @else
                                    @php
                                        $dailies_sum = 0;
                                    @endphp
                                @foreach($users as $user)
                                    @foreach ($dailies[$user->id] as $key => $data)
                                        <tr>
                                            <td>1</td>
                                            <td>{{$user->username}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$data->rate}}</td>
                                            <td>{{date('d-m-Y', strtotime($data->date))}}</td>
                                        </tr>
                                        @php
                                            $dailies_sum += $data->rate;
                                        @endphp
                                    @endforeach
                                @endforeach
                            @endif
                            
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SL</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Total Amount: 
                                    @if (session('dailies'))
                                        {{session('dailies')->sum('rate')}}
                                    @else
                                        {{$dailies_sum}}
                                    @endif
                                </th>
                                <th>Date</th>
                            </tr>
                        </tfoot>
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
                    <table id="example5" class="table table-bordered table-striped">
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
                        <tbody>
                            @if (session('site_incomes'))
                                @foreach (session('site_incomes') as $key => $data)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$data->user->username}}</td>
                                        <td>{{$data->user->name}}</td>
                                        <td>{{$data->user->referer_id}}</td>
                                        <td>{{$data->amount}}</td>
                                        <td>{{date('d-m-Y', strtotime($data->created_at))}}</td>
                                        
                                    </tr>
                                @endforeach 
                            @else
                                @foreach ($site_incomes as $key => $data)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$data->user->username}}</td>
                                        <td>{{$data->user->name}}</td>
                                        <td>{{$data->user->referer_id}}</td>
                                        <td>{{$data->amount}}</td>
                                        <td>{{date('d-m-Y', strtotime($data->created_at))}}</td>
                                        
                                    </tr>
                                @endforeach
                            @endif
                            
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SL</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Refer ID</th>
                                <th>Total Amount: 
                                    @if (session('site_incomes'))
                                        {{session('site_incomes')->sum('amount')}}
                                    @else
                                        {{$site_incomes->sum('amount')}}
                                    @endif
                                </th>
                                <th>Date</th>
                            </tr>
                        </tfoot>
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
            
            $("#example2").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["csv", "excel", "pdf", "print",]
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
            
            $("#example3").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["csv", "excel", "pdf", "print",]
            }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
            
            $("#example4").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["csv", "excel", "pdf", "print",]
            }).buttons().container().appendTo('#example4_wrapper .col-md-6:eq(0)');
            
            $("#example5").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["csv", "excel", "pdf", "print",]
            }).buttons().container().appendTo('#example5_wrapper .col-md-6:eq(0)');
        })
    </script>
@endpush