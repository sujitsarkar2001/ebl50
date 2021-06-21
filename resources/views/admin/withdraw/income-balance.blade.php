@extends('layouts.admin.app')

@section('title', 'Income Balance History')

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('/')}}assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endpush

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Income Balance History</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Income Balance History</li>
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
                    <h3 class="card-title">Income Balance History</h3>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="javascript:void(0)" class="btn btn-success" id="add-btn">
                        <i class="fas fa-plus-circle"></i>
                        Send Income Balance
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
                        <th>Name</th>
                        <th>UserName</th>
                        <th>Amount</th>
                        <th>Date</th>
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
            <form action="{{route('admin.withdraw.income.balance.store')}}" method="post" id="form-submit">
                @csrf
                <input type="hidden" id="method">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="type">User Type</label>
                        <select id="type" name="type" class="form-control">
                            <option value="">Select User Type</option>
                            <option value="Individual">Individual User</option>
                            <option value="All">All User</option>
                        </select>
                    </div>
                    <div id="users">
                        
                    </div>
                    
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" required id="amount" class="form-control" placeholder="Amount">
                        <small class="form-text text-danger amount"></small>
                    </div>
                    
                    <div class="form-group">
                        <label for="details">Details</label>
                        <textarea name="details" id="details" rows="3" class="form-control" placeholder="Details"></textarea>
                        <small class="form-text text-danger details"></small>
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

<!-- add/update modal -->
<div class="modal fade" id="show-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            
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
    <script src="{{asset('/')}}assets/plugins/select2/js/select2.full.min.js"></script>
    <script>
        $(document).ready(function () {

            $('.select2').select2()

            // show all data in table
            let table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                "responsive": true,
                "autoWidth": false,
                ajax: '{!! route('admin.income.balance.data') !!}',
                columns: [
                    {data: 'DT_RowIndex', searchable: false},
                    {data: 'user.name', name: 'user.name'},
                    {data: 'user.username', name: 'user.username'},
                    {data: 'amount', name: 'amount'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', searchable: false, orderable: false}
                ]
            });

            $(document).on('change', 'select#type', function(e) {

                let type = $(this).val();

                if (type == 'Individual') {
                     $.ajax({
                        type: 'GET',
                        url: '{!! route('admin.withdraw.income.balance.info') !!}',
                        dataType: "JSON",
                        success: function (response) {
                            
                            let html = '';
                            html += '<label for="username">Select User</label>';
                            html += '<select name="username[]" id="username" class="form-control" multiple="multiple">';
                            html += '<option value="Select User">Select User</option>';
                            $.each(response, function (key, val) { 
                                html += '<option value="'+val.id+'">'+val.username+'</option>';
                            });
                            html += '</select>';

                            $('#users').html(html).addClass('mb-2');
                            $('select#username').select2();
                        }
                    });
                } else {
                    $('#users').empty().removeClass('mb-2'); 
                }
               
            });

            // add new data
            $(document).on('click', '#add-btn', function(e) {
                e.preventDefault();

                $('#modal').modal('show');
                $('.modal-title').text('Send Income Balance');
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
                        $('#modal').modal('hide');
                        table.ajax.reload();

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
                            $('#show-modal .modal-title').text('Details');

                            $('#show-modal .modal-body').text(response.details);
                        }
                    },
                    complete: function () { 
                        $('div.loader').removeClass('d-block').addClass('d-none');
                    },
                    error: function (xhr) {
                        $.toast({
                            heading: xhr.status,
                            text: xhr.statusText,
                            icon: 'error',
                            position: 'top-right',
                            stack: false
                        });
                    }
                });
                });

        });
    </script>
@endpush