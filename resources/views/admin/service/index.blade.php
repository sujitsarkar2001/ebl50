@extends('layouts.admin.app')

@section('title', 'Service')

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
                <h1>Service</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Service</li>
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
                    <h3 class="card-title">Service List</h3>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('admin.service.create')}}" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i>
                        Add Service
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
                        <th>Contents</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $key => $data)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{!! Str::words($data->contents, 30, '...') !!}</td>
                            <td>
                                @if ($data->status)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Disable</span>
                                @endif  
                            </td>
                            <td>
                                
                                <a href="{{ route('admin.service.show', $data->id) }}" class="btn btn-success btn-sm mb-1">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('admin.service.edit', $data->id) }}" class="btn btn-info btn-sm mb-1">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="{{ route('admin.service.destroy', $data->id) }}" class="btn btn-danger btn-sm"
                                    onclick="event.preventDefault();
                                    document.getElementById('delete-form-{{$data->id}}').submit();">
                                    <i class="nav-icon fas fa-trash-alt"></i>
                                </a>
                                <form id="delete-form-{{$data->id}}" action="{{ route('admin.service.destroy', $data->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>

                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>
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
    <script src="{{asset('/')}}assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('/')}}assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{asset('/')}}assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{asset('/')}}assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script>
        $(function () { 
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
            });
        })
    </script>
@endpush