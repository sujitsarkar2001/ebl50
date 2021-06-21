@extends('layouts.admin.app')

@section('title', 'Staff List')

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
                <h1>Staff</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Staff</li>
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
                    <h3 class="card-title">Staff List</h3>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('admin.staff.create')}}" class="btn btn-success" id="add-btn">
                        <i class="fas fa-plus-circle"></i>
                        Add New Staff
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
                        <th>Action</th>
                    </tr>
                </thead>
                
            </table>
        </div>
        <!-- /.card-body -->
    </div>
      <!-- /.card -->    

</section>
<!-- /.content -->

<!-- add/update modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="form-submit">
                @csrf
                <input type="hidden" id="method">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="name">Name</label>
                            <input required type="text" name="name" id="name" class="form-control" placeholder="Name">
                            <small class="form-text text-danger name"></small>
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label for="username">Username</label>
                            <input required type="text" name="username" id="username" class="form-control" placeholder="Username" @isset($user) readonly @endisset>
                            <small class="form-text text-danger username"></small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="email">Email</label>
                            <input required type="email" name="email" id="email" class="form-control" placeholder="example@gmail.com">
                            <small class="form-text text-danger email"></small>
                        </div>
        
                        <div class="form-group col-sm-6">
                            <label for="phone">Phone</label>
                            <input required type="text" name="phone" id="phone" class="form-control" maxlength="25" placeholder="Phone Number">
                            <small class="form-text text-danger phone"></small>
                        </div>
                    </div>

                    <div class="form-row pass">
                        
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"></button>
                </div>
            </form>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


@endsection

@push('js')
    <!-- DataTables  & Plugins -->
    <script src="{{asset('/')}}assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('/')}}assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{asset('/')}}assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{asset('/')}}assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script>
        $(function () {

            // show all data in table
            let table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                "responsive": true,
                "autoWidth": false,
                ajax: '{!! route('admin.staff.data') !!}',
                columns: [
                    {data: 'DT_RowIndex', searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'username', name: 'username'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // add new data
            $(document).on('click', '#add-btn', function(e) {
                e.preventDefault();

                $('#modal').modal('show');
                $('.modal-title').text('Add New Staff');
                $('#form-submit').trigger("reset").attr('action', '{!! route('admin.staff.store') !!}');
                $('input#method').removeAttr('name').val('');
                $('form small.form-text').text('');
                $('.form-control').removeClass('is-invalid');
                $('button[type="submit"]').attr('disabled', false).text('Submit');
                

                let pass = '<div class="form-group col-md-6">';
                pass += '<label for="password">Password</label>';
                pass += '<input required type="password" name="password" id="password" class="form-control" placeholder="******">';
                pass += '<small class="form-text text-danger password"></small>';
                pass += '</div>';
                pass += '<div class="form-group col-md-6">';
                pass += '<label for="password_confirmation">Password</label>';
                pass += '<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password">';
                pass += '</div>';
                $('.pass').html(pass);
            });

            // edit specific data
            $(document).on('click', '#showData', function(e) {

                e.preventDefault();

                let url = $(this).attr('href');

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "JSON",
                    beforeSend: function () { 
                        $('div.loader').removeClass('d-none').addClass('d-block');
                    },
                    success: function (response) {
                        if (response != '') {

                            $('#show-modal').modal('show');
                            $('#show-modal .modal-title').text('Notice Information');

                            $('td.image img').attr('src', '/uploads/notice/'+ response.image);
                            $('td.title').text(response.title);
                            $('td.title').text(response.title);
                            $('td.description').html(response.description);
                            
                            let status = '';
                            if (response.status) {
                                status += '<span class="badge badge-success">Active</span>';
                            } else {
                                status += '<span class="badge badge-danger">Disable</span>';
                            }
                            $('td.status').html(status);
                        }
                    },
                    complete: function () { 
                        $('div.loader').removeClass('d-block').addClass('d-none');
                    },
                    error: function (xhr) {
                        if (xhr.status === 0) {
                            $.toast({
                                heading: 'Error',
                                text: 'Not connected Please verify your network connection.',
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        } 
                        else if (xhr.status == 404) {
                            $.toast({
                                heading: 'Error',
                                text: 'The requested data not found. [404]',
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        } 
                        else if (xhr.status == 500) {
                            $.toast({
                                heading: 'Error',
                                text: 'Internal Server Error [500].',
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        } 
                        else if (xhr === 'parsererror') {
                            $.toast({
                                heading: 'Error',
                                text: 'Requested JSON parse failed.',
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        } 
                        else if (xhr === 'timeout') {
                            $.toast({
                                heading: 'Error',
                                text: 'Requested Time out.',
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        } 
                        else if (xhr === 'abort') {
                            $.toast({
                                heading: 'Error',
                                text: 'Request aborted.',
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        } 
                        else {
                            return ('Uncaught Error.\n' + xhr.responseText);
                        }
                    }
                });
            });

            // edit specific data
            $(document).on('click', '#editData', function(e) {

                e.preventDefault();

                let url = $(this).attr('href');
                $('.pass').empty();

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "JSON",
                    beforeSend: function () { 
                        $('div.loader').removeClass('d-none').addClass('d-block');
                    },
                    success: function (response) {
                        if (response != '') {
                            
                            $('#form-submit').trigger("reset").attr('action', '/admin/staff/'+response.id);
                            $('input#method').attr('name', '_method').val('PUT');
                            $('form small.form-text').text('');
                            $('.form-control').removeClass('is-invalid');

                            $('#modal').modal('show');
                            $('.modal-title').text('Update Staff');
                            $('button[type="submit"]').attr('disabled', false).text('Update');

                            // show value in input tag
                            $.each(response, function (key, val) { 
                                $('input#'+key+'').val(val);
                            });
                            
                        }
                    },
                    complete: function () { 
                        $('div.loader').removeClass('d-block').addClass('d-none');
                    },
                    error: function (xhr) {
                        if (xhr.status === 0) {
                            $.toast({
                                heading: 'Error',
                                text: 'Not connected Please verify your network connection.',
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        } 
                        else if (xhr.status == 404) {
                            $.toast({
                                heading: 'Error',
                                text: 'The requested data not found. [404]',
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        } 
                        else if (xhr.status == 500) {
                            $.toast({
                                heading: 'Error',
                                text: 'Internal Server Error [500].',
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        } 
                        else if (xhr === 'parsererror') {
                            $.toast({
                                heading: 'Error',
                                text: 'Requested JSON parse failed.',
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        } 
                        else if (xhr === 'timeout') {
                            $.toast({
                                heading: 'Error',
                                text: 'Requested Time out.',
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        } 
                        else if (xhr === 'abort') {
                            $.toast({
                                heading: 'Error',
                                text: 'Request aborted.',
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        } 
                        else {
                            return ('Uncaught Error.\n' + xhr.responseText);
                        }
                    }
                });
            });

            // Delete Data
            $(document).on('click', '#deleteData', function (e) { 
                e.preventDefault();

                let url = $(this).attr('href');
                let csrf = $('meta[name="csrf-token"').attr('content');
                if (!confirm('Are you sure delete this data?')) return;
                $.ajax({
                    type: "DELETE",
                    url: url,
                    data: {
                        '_method' : 'DELETE',
                        '_token'  : csrf
                    },
                    dataType: "JSON",
                    beforeSend: function () { 
                        $('div.loader').removeClass('d-none').addClass('d-block');
                    },
                    success: function (response) {
                        if (response.alert == 'Success') {
                            $.toast({
                                heading: 'Congratulations',
                                text: response.message,
                                icon: response.alert.toLowerCase(),
                                position: 'top-right',
                                stack: false
                            })
                            table.ajax.reload();
                        }
                    },
                    complete: function () { 
                        $('div.loader').removeClass('d-block').addClass('d-none');
                    },
                    error: function (xhr) { 
                        if (xhr.status === 0) {
                            $.toast({
                                heading: 'Error',
                                text: 'Not connected Please verify your network connection.',
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        } 
                        else if (xhr.status == 404) {
                            $.toast({
                                heading: 'Error',
                                text: 'The requested data not found. [404]',
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        } 
                        else if (xhr.status == 500) {
                            $.toast({
                                heading: 'Error',
                                text: 'Internal Server Error [500].',
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        } 
                        else if (xhr === 'parsererror') {
                            $.toast({
                                heading: 'Error',
                                text: 'Requested JSON parse failed.',
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        } 
                        else if (xhr === 'timeout') {
                            $.toast({
                                heading: 'Error',
                                text: 'Requested Time out.',
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        } 
                        else if (xhr === 'abort') {
                            $.toast({
                                heading: 'Error',
                                text: 'Request aborted.',
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        } 
                        else {
                            return ('Uncaught Error.\n' + xhr.responseText);
                        }
                    }
                }); 
                
            });

            // store/update data
            $(document).on('submit', '#form-submit', function(e) {
                e.preventDefault();

                let method   = $(this).attr('method');
                let action   = $(this).attr('action');
                var formData = $(this).serialize();

                $('small.form-text').text('')
                $('.form-control').removeClass('is-invalid');

                $.ajax({
                    type: method,
                    url: action,
                    data: formData,
                    dataType: "JSON",
                    beforeSend: function () { 
                        $('button[type="submit"]').attr('disabled', true);
                    },
                    success: function (response) {
                        
                        if (response.alert == 'Success') {
                            
                            $.toast({
                                heading: 'Congratulations',
                                text: response.message,
                                icon: response.alert.toLowerCase(),
                                position: 'top-right',
                                stack: false
                            })

                            $('#modal').modal('hide');

                            table.ajax.reload();
                        }
                    },
                    complete: function () { 
                        $('button[type="submit"]').attr('disabled', false);
                    },
                    error: function (xhr) {
                        if (xhr.status == 422) {
                            if (typeof(xhr.responseJSON.errors) !== 'undefined') {
                                
                                $.each(xhr.responseJSON.errors, function (key, error) { 
                                    $('small.'+key+'').text(error)
                                    $('#'+key+'').addClass('is-invalid');
                                });

                                if (typeof(xhr.responseJSON.message) !== 'undefined') {
                                    $.toast({
                                        heading: 'Error',
                                        text: xhr.responseJSON.message,
                                        icon: 'error',
                                        position: 'top-right',
                                        stack: false
                                    });
                                }
                            }
                            
                        } else {
                            $.toast({
                                heading: xhr.status,
                                text: xhr.statusText,
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        }
                    }
                });

            });
        })
    </script>
@endpush