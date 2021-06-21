@extends('layouts.admin.app')

@section('title', 'Withdraw History')

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
            <table id="data-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Username</th>
                        <th>Amount</th>
                        <th>Charge</th>
                        <th>Total</th>
                        <th>Method</th>
                        <th>H Name</th>
                        <th>AC</th>
                        <th>Status</th>
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
                <h4 class="modal-title">Update Withdraw</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="form-submit">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" id="amount" class="form-control" placeholder="Amount">
                        <small class="form-text text-danger amount"></small>
                    </div>
                    <div class="form-group">
                        <label for="method">Method</label>
                        <select name="method" id="method" class="form-control"></select>
                        <small class="form-text text-danger method"></small>
                    </div>
                    <div class="form-group">
                        <label for="holder_name">Holder Name</label>
                        <input type="text" name="holder_name" id="holder_name" class="form-control" placeholder="Holder name">
                        <small class="form-text text-danger holder_name"></small>
                    </div>
                    <div class="form-group">
                        <label for="account_number">Account Number</label>
                        <input type="number" name="account_number" id="account_number" class="form-control" placeholder="Account number">
                        <small class="form-text text-danger account_number"></small>
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" class="form-control">
                        <small class="form-text text-danger date"></small>
                    </div>

                    <div class="form-group">
                        <label for="charge">Charge (<span id="show_charge"></span>%)</label>
                        <input type="number" id="charge" class="form-control" placeholder="Charge" readonly>
                    </div>

                    <div class="form-group">
                        <label for="after_charge">After Charge</label>
                        <input type="number" id="after_charge" class="form-control" placeholder="After Charge" readonly>
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
                ajax: '{!! route('admin.withdraw.data') !!}',
                columns: [
                    {data: 'DT_RowIndex', searchable: false},
                    {data: 'user.username', name: 'user.username'},
                    {data: 'amount', name: 'amount'},
                    {data: 'charge', name: 'charge'},
                    {data: 'after_charge', name: 'after_charge'},
                    {data: 'method', name: 'method'},
                    {data: 'holder_name', name: 'holder_name'},
                    {data: 'account_number', name: 'account_number'},
                    {data: 'status', name: 'status'},
                    {data: 'date', name: 'date'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // store new data
            $(document).on('submit', '#form-submit', function(e) {
                e.preventDefault();

                let method   = $(this).attr('method');
                let action   = $(this).attr('action');
                var formData = $(this).serialize();

                $.ajax({
                    type: method,
                    url: action,
                    data: formData,
                    dataType: "JSON",
                    processData: false,
                    beforeSend: function () { 
                        $('button[type="submit"]').attr('disabled', true);
                    },
                    success: function (response) {
                        $.toast({
                            heading: response.alert,
                            text: response.message,
                            icon: response.alert.toLowerCase(),
                            position: 'top-right',
                            stack: false
                        })

                        if (response.alert == 'Success') {
                            table.ajax.reload();
                        }
                        $('#modal').modal('hide');
                    },
                    complete: function () { 
                        $('button[type="submit"]').attr('disabled', false);
                    },
                    error: function (xhr) {
                        if (xhr.status == 422) {
                            if (typeof(xhr.responseJSON.errors) !== 'undefined') {
                                
                                $.each(xhr.responseJSON.errors, function (key, error) { 
                                    $('small.'+key+'').text(error);
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
            $(document).on('click', '#editData', function(e) {

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
                            
                            $('#form-submit').trigger("reset").attr('action', '/admin/withdraw/'+response.id);
                            
                            $('#modal').modal('show');
                            $('small.form-text').text('');
                            $('.form-control').removeClass('is-invalid');
                            
                            $('button[type="submit"]').attr('disabled', false).text('Update');
                        
                            // show value in input tag
                            $.each(response, function (key, val) { 
                                $('input#'+key+'').val(val);
                            });
                            
                            let html = '<option value="Bank" '+(response.method== 'Bank' ? 'selected':'')+'>Bank</option>';
                            html += '<option value="Bkash" '+(response.method== 'Bkash' ? 'selected':'')+'>Bkash</option>';
                            html += '<option value="Nagad" '+(response.method== 'Nagad' ? 'selected':'')+'>Nagad</option>';
                            html += '<option value="Rocket" '+(response.method== 'Rocket' ? 'selected':'')+'>Rocket</option>';
                            
                            $('select#method').html(html);

                            let percent = '';
                            if (response.method == 'Bank') {
                                percent = '{!! setting('withdraw_charge_in_bank') !!}';
                            } 
                            else if (response.method == 'Bkash') {
                                percent = '{!! setting('withdraw_charge_in_bkash') !!}';
                            }
                            else if (response.method == 'Nagad') {
                                percent = '{!! setting('withdraw_charge_in_nagad') !!}';
                            }
                            else if (response.method == 'Rocket') {
                                percent = '{!! setting('withdraw_charge_in_rocket') !!}';
                            }
                            $('#show_charge').text(percent);
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

            // Update data status
            $(document).on('click', '#approvedData', function (e) { 
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
                        table.ajax.reload();
                        $.toast({
                            heading: 'Congratulations',
                            text: response.message,
                            icon: response.alert.toLowerCase(),
                            position: 'top-right',
                            stack: false
                        });
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


            $('#amount').on('input', function() {
                calculate();
            });

            function calculate() {
                let method  = $('#method').val();
                let amount  = $('#amount').val();
                let percent = 0;
                
                if (method == 'Bank') {
                    percent = "{{setting('withdraw_charge_in_bank')}}";
                } 
                else if (method == 'Bkash') {
                    percent = "{{setting('withdraw_charge_in_bkash')}}";
                }
                else if (method == 'Nagad') {
                    percent = "{{setting('withdraw_charge_in_nagad')}}";
                }
                else {
                    percent = "{{setting('withdraw_charge_in_rocket')}}";
                }

                let total =  ((percent/ 100) * amount).toFixed(2);
                
                $('#charge').val(total);
                $('#after_charge').val(amount - total);
                $('#show_charge').text(percent);
            }
            $('#method').on('change', function() { calculate() });
        })
    </script>
@endpush