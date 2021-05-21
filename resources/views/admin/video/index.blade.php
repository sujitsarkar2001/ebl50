@extends('layouts.admin.app')

@section('title', 'Video')

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
                <h1>Video</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Video</li>
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
                    <h3 class="card-title">Video List</h3>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('admin.video.create')}}" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i>
                        Add
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
                        <th>Title</th>
                        <th>Link</th>
                        <th>Views</th>
                        <th>Status</th>
                        <th>Rate</th>
                        <th>Added</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($videos as $key => $data)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{Str::words($data->title, 5, '...')}}</td>
                            <td>
                                <a href="{{$data->link}}" target="_blank" rel="noopener noreferrer">{{$data->link}}</a>
                            </td>
                            <td>{{$data->users->count()}}</td>
                            <td>
                                @if ($data->status)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Disable</span>
                                @endif  
                            </td>
                            <td>{{$data->rate}}</td>
                            <td>{{$data->created_at->diffForHumans()}}</td>
                            <td>
                                @if ($data->status)
                                <a href="{{ route('admin.video.show', $data->id) }}" class="btn btn-warning btn-sm" title="Disable">
                                    <i class="fas fa-thumbs-down"></i>
                                </a>
                                @else
                                <a href="{{ route('admin.video.show', $data->id) }}" class="btn btn-warning btn-sm" title="Enable">
                                    <i class="fas fa-thumbs-up"></i>
                                </a>
                                @endif
                                

                                <a href="{{ route('admin.video.edit', $data->id) }}" class="btn btn-info btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="#" class="btn btn-danger btn-sm"
                                    onclick="event.preventDefault();
                                    document.getElementById('delete-form-{{$data->id}}').submit();" title="Delete">
                                    <i class="nav-icon fas fa-trash-alt"></i>
                                </a>
                                <form id="delete-form-{{$data->id}}" action="{{ route('admin.video.destroy', $data->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>

                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th>SL</th>
                        <th>Title</th>
                        <th>Link</th>
                        <th>Views</th>
                        <th>Status</th>
                        <th>Rate</th>
                        <th>Added</th>
                        <th>Action</th>
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
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        })
    </script>
@endpush