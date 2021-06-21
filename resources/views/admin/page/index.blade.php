@extends('layouts.admin.app')

@section('title', 'Page')

@push('css')
    <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('/')}}assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{asset('/')}}assets/plugins/summernote/summernote-bs4.min.css">
@endpush

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Page</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Page</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="card-title">Page List</h3>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="" class="btn btn-success" id="add-btn">
                                <i class="fas fa-plus-circle"></i>
                                Add Page
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
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
              <!-- /.card -->  
        </div>
    </div>
</section>
<!-- /.content -->

<!-- add/update modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="form-submit" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="method">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="">Page Name:</label>
                        <input type="text" name="name" id="name" placeholder="Enter page name" class="form-control" required>
                        <small class="form-text text-danger name"></small>
                    </div>
    
                    <div class="form-group">
                        <label for="body" class="">Body:</label>
                        <textarea name="body" id="body" class="form-control"></textarea>
                        <small class="form-text text-danger body"></small>
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
                            <th width="15%">Page Name</th>
                            <td class="name"></td>
                        </tr>
                        <tr>
                            <th>Body</th>
                            <td class="body"></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td class="status"></td>
                        </tr>
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

@endsection

@push('js')
    <!-- DataTables  & Plugins -->
    <script src="{{asset('/')}}assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('/')}}assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{asset('/')}}assets/plugins/summernote/summernote-bs4.min.js"></script>

    <script>
        $(function () {

            // show all data in table
            let table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.page.data') !!}',
                columns: [
                    {data: 'DT_RowIndex', searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // add new data
            $(document).on('click', '#add-btn', function(e) {

                e.preventDefault();

                $('#modal').modal('show');
                $('.modal-title').text('Add New Page');

                $('#form-submit').trigger("reset").attr('action', '{!! route('admin.page.store') !!}');
                $('input#method').removeAttr('name').val('');
                $('form small.form-text').text('');
                $('button[type="submit"]').attr('disabled', false).text('Submit');
                
                $('textarea#body').summernote('code', '');
            });

            // store new data
            $(document).on('submit', '#form-submit', function(e) {
                e.preventDefault();

                let method   = $(this).attr('method');
                let action   = $(this).attr('action');
                var formData = $(this).serialize();

                $('small.form-text').text('')

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
                                text: 'The requested page not found. [404]',
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
                        else if (xhr.status == 422) {
                            if (typeof(xhr.responseJSON.errors) !== 'undefined') {
                                
                                $.each(xhr.responseJSON.errors, function (key, error) { 
                                    $('small.'+key+'').text(error)
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
                            return ('Uncaught Error.\n' + xhr.responseText);
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
                            $('#show-modal .modal-title').text('Page Information');
                            
                            $('td.name').text(response.name);
                            $('td.body').html(response.body);
                            
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

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "JSON",
                    beforeSend: function () { 
                        $('div.loader').removeClass('d-none').addClass('d-block');
                    },
                    success: function (response) {
                        if (response != '') {
                            
                            $('#form-submit').trigger("reset").attr('action', '/admin/page/'+response.id);
                            $('input#method').attr('name', '_method').val('PUT');
                            
                            $('#modal').modal('show');
                            $('form small.form-text').text('');
                            $('.modal-title').text('Update Page');
                            
                            $('button[type="submit"]').attr('disabled', false).text('Update');
                            
                            // show value in input tag
                            $('input#name').val(response.name);
                            $('textarea#body').summernote('code', response.body);
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
                
            })

            // Update data status
            $(document).on('click', '#dataStatus', function (e) { 
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
                
            })

            $('#body').summernote({
                height: 150,
                toolbar: [
                    [ 'style', [ 'style' ] ],
                    [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                    [ 'fontname', [ 'fontname' ] ],
                    [ 'fontsize', [ 'fontsize' ] ],
                    [ 'color', [ 'color' ] ],
                    [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                    [ 'table', [ 'table' ] ],
                    [ 'insert', [ 'link'] ],
                    [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
                ]
            });

        })
    </script>
@endpush