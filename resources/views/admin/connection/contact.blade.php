@extends('layouts.admin.app')

@section('title', 'Contact')

@push('css')
    <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('/')}}assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{asset('/')}}assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{asset('/')}}assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Contact</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Contact</li>
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
                    <h3 class="card-title">Contact List</h3>
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
                        <th>Username</th>
                        <th>Email</th>
                        <th>Subject</th>
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

    <!-- show modal -->
    <div class="modal fade" id="reply-modal">
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
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="from">From</label>
                            <input type="email" name="from" class="form-control" readonly value="{{config('mail.from.address')}}">
                            
                        </div>
                        <div class="form-group">
                            <label for="to">To</label>
                            <input type="email" name="to" id="to" class="form-control" readonly>
                            <small class="form-text text-danger to"></small>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea name="message" id="message" class="form-control" rows="7"></textarea>
                            <small class="form-text text-danger message"></small>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="mt-1 btn btn-primary">
                            <i class="fas fa-location-arrow"></i>
                            Reply
                        </button>
                    </div>
                    </div>
                </form>
                
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- show modal -->
    <div class="modal fade" id="show-modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <table class="table table-bordered table-hover">
                        <tbody>
                            <tr>
                                <th width="15%">Name</th>
                                <td class="name"></td>
                                <th>Username</th>
                                <td class="username"></td>
                            </tr>
                            <tr>
                                <th>Refer Code</th>
                                <td class="referer_id"></td>
                                <th>Email</th>
                                <td class="email"></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td class="status"></td>
                                <th>Subject</th>
                                <td class="subject"></td>
                            </tr>
                            <tr>
                                <th>Message</th>
                                <td class="message" colspan="3"></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-hover" id="replies">
                        <tbody>
                            
                        </tbody>
                    </table>
                    
                </div>
                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

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

            // show all data in table
            let table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                "responsive": true,
                "autoWidth": false,
                ajax: '{!! route('admin.contact.data') !!}',
                columns: [
                    {data: 'DT_RowIndex', searchable: false},
                    {data: 'user.name', name: 'user.name'},
                    {data: 'user.username', name: 'user.username'},
                    {data: 'email', name: 'email'},
                    {data: 'subject', name: 'subject'},
                    {data: 'status', name: 'status'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
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
                            $('#show-modal .modal-title').text('Contact Message Information');

                            $('td.name').text(response.user.name);
                            $('td.username').text(response.user.username);
                            $('td.referer_id').text(response.user.referer_id);
                            $('td.email').text(response.email);
                            $('td.subject').text(response.subject);
                            $('td.message').text(response.message);
                            
                            let status = '';
                            if (response.status) {
                                status += '<span class="badge badge-success">Seen</span>';
                            } else {
                                status += '<span class="badge badge-danger">Pending</span>';
                            }
                            $('td.status').html(status);

                            let html = '<tr><th colspan="2">Reply Message</th></tr>';
                            $.each(response.contact_replies, function (key, val) { 
                                html += '<tr>';
                                html += '<th>Message</th>';
                                html += '<td>'+val.message+'</td>';
                                html += '</tr>';
                            });
                            
                            $('#replies tbody').html(html);
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

            // edit specific data
            $(document).on('click', '#replyData', function(e) {

                e.preventDefault();

                let url = $(this).attr('href');

                $('small.form-text').text('');
                $('.form-control').removeClass('is-invalid');

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "JSON",
                    beforeSend: function () { 
                        $('div.loader').removeClass('d-none').addClass('d-block');
                    },
                    success: function (response) {
                        $('#form-submit').trigger("reset").attr('action', '/admin/connection/reply/contact/'+response.id);
                        $('#reply-modal').modal('show');
                        $('#reply-modal .modal-title').text('Reply Contact');

                        $('#to').val(response.email);
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

            // store new data
            $(document).on('submit', '#form-submit', function(e) {
                e.preventDefault();

                let method   = $(this).attr('method');
                let action   = $(this).attr('action');
                var formData = $(this).serialize();

                $('small.form-text').text('');
                $('.form-control').removeClass('is-invalid');

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
                        table.ajax.reload();
                        $.toast({
                            heading: 'Congratulations',
                            text: response.message,
                            icon: response.alert.toLowerCase(),
                            position: 'top-right',
                            stack: false
                        })
                        $('#reply-modal').modal('hide');
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
                        }
                        else {
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
                        $.toast({
                            heading: 'Congratulations',
                            text: response.message,
                            icon: response.alert.toLowerCase(),
                            position: 'top-right',
                            stack: false
                        })
                        table.ajax.reload();
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
        })
    </script>
@endpush