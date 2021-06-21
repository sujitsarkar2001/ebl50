@extends('layouts.admin.app')

@section('title', 'Shop Balance History')

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
                <h1>Shop Balance History</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Shop Balance History</li>
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
                    <h3 class="card-title">Shop Balance History</h3>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="javascript:void(0)" class="btn btn-success" id="add-btn">
                        <i class="fas fa-plus-circle"></i>
                        Send Shop Balance
                    </a>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="data-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Receiver Name</th>
                        <th>Sender Name</th>
                        <th>Amount</th>
                        <th>Date</th>
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
            <form action="{{route('admin.withdraw.shop.balance.store')}}" method="post" id="form-submit">
                @csrf
                <input type="hidden" id="method">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" required id="username" class="form-control" placeholder="Username">
                        <small class="form-text text-danger username"></small>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" required id="amount" class="form-control" placeholder="Amount">
                        <small class="form-text text-danger amount"></small>
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
        $(document).ready(function () {

            // show all data in table
            let table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                "responsive": true,
                "autoWidth": false,
                ajax: '{!! route('admin.shop.balance.data') !!}',
                columns: [
                    {data: 'DT_RowIndex', searchable: false},
                    {data: 'user.username',
                        render: function ( data, type, row ) {
                            return row.user.name + ' (' + row.user.username + ')';
                        }
                    },
                    {data: 'parent_user.username',
                        render: function ( data, type, row ) {
                            return row.parent_user.name + ' (' + row.parent_user.username + ')';
                        }
                    },
                    {data: 'amount', name: 'amount'},
                    {data: 'date', name: 'date'}
                ]
            });

            // add new data
            $(document).on('click', '#add-btn', function(e) {
                e.preventDefault();

                $('#modal').modal('show');
                $('.modal-title').text('Send Shop Balance');
                $('#form-submit').trigger("reset");
                $('form small.form-text').text('');
                $('.form-control').removeClass('is-invalid');
                $('button[type="submit"]').attr('disabled', false).text('Submit');
                
            });

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
                            $('#modal').modal('hide');
                            table.ajax.reload();
                        }

                        $.toast({
                            heading: response.alert,
                            text: response.message,
                            icon: response.alert.toLowerCase(),
                            position: 'top-right',
                            stack: false
                        })
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

        });
    </script>
@endpush