@extends('layouts.admin.app')

@section('title', 'Notice List')

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('/')}}assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/plugins/summernote/summernote-bs4.min.css">

    <style>
        .imageThumb {
            max-height: 75px;
            border: 2px solid;
            padding: 1px;
            cursor: pointer;
        }
        .pip {
            display: inline-block;
            margin: 10px 10px 0 0;
        }
        .remove_photo {
            display: block;
            background: #444;
            border: 1px solid black;
            color: white;
            text-align: center;
            cursor: pointer;
        }
        .remove_photo:hover {
            background: white;
            color: black;
        }
    </style>

@endpush

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Notice</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Notice</li>
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
                    <h3 class="card-title">Notice List</h3>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('admin.notice.create')}}" class="btn btn-success" id="add-btn">
                        <i class="fas fa-plus-circle"></i>
                        Add New Notice
                    </a>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="data-table" class="table table-bordered table-striped" width="100%">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Status</th>
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
                        <label for="title" class="">Title:</label>
                        <input type="text" name="title" id="title" placeholder="Enter notice title" class="form-control" required>
                        <small class="form-text text-danger title"></small>
                    </div>
    
                    <div class="form-group">
                        <label for="description" class="">Description:</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                        <small class="form-text text-danger description"></small>
                    </div>
    
                    <div class="form-group">
                        <label for="image" class="">Image:</label>
                        <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="image" name="image">
                              <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>
                        <div class="pip-area"></div>
                        <small class="form-text text-danger image"></small>
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
                            <th>Image</th>
                            <td class="image">
                                <img src="" alt="" width="150px" height="150px">
                            </td>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <td class="title"></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td class="description"></td>
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
    <script src="{{asset('/')}}assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{asset('/')}}assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{asset('/')}}assets/plugins/summernote/summernote-bs4.min.js"></script>

    <script>
        $(function () {

            // show all data in table
            let table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                "responsive": true,
                "autoWidth": false,
                ajax: '{!! route('admin.notice.data') !!}',
                columns: [
                    {data: 'DT_RowIndex', searchable: false},
                    {data: 'photo', name: 'photo'},
                    {data: 'title', name: 'title'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // add new data
            $(document).on('click', '#add-btn', function(e) {

                e.preventDefault();

                $('#modal').modal('show');
                $('.modal-title').text('Add New Notice');

                $('#form-submit').trigger("reset").attr('action', '{!! route('admin.notice.store') !!}');
                $('input#method').removeAttr('name').val('');
                $('form small.form-text').text('');
                $('button[type="submit"]').attr('disabled', false).text('Submit');
                $('.pip-area').empty();
                $('textarea#description').summernote('code', '');
            });

            // store new data
            $(document).on('submit', '#form-submit', function(e) {
                e.preventDefault();

                let method   = $(this).attr('method');
                let action   = $(this).attr('action');
                var formData = new FormData($(this)[0]);

                $('small.form-text').text('')

                $.ajax({
                    type: method,
                    url: action,
                    data: formData,
                    dataType: "JSON",
                    async: false,
                    cache: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    processData: false,
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

            // show specific data
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
                            
                            $('#form-submit').trigger("reset").attr('action', '/admin/notice/'+response.id);
                            $('input#method').attr('name', '_method').val('PUT');
                            
                            $('#modal').modal('show');
                            $('form small.form-text').text('');
                            $('.modal-title').text('Update Notice');
                            
                            $('button[type="submit"]').attr('disabled', false).text('Update');
                            
                            

                            // show value in input tag
                            $('input#title').val(response.title);
                            $('textarea#description').summernote('code', response.description);
                            
                            let html = '<span class="pip">';
                            html += '<img class="imageThumb" src="/uploads/notice/'+ response.image+'"/>';
                            html += '</span>';
                            
                            $('.pip-area').html(html);
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
                        $.toast({
                            heading: xhr.status,
                            text: xhr.statusText,
                            icon: 'error',
                            position: 'top-right',
                            stack: false
                        });
                    }
                }); 
                
            })

            $('#description').summernote({
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

            if (window.File && window.FileList && window.FileReader) {
                
                $("#image").on("change", function(e) {
                    var files = e.target.files,
                    filesLength = files.length;

                    $(".pip").remove();

                    for (var i = 0; i < filesLength; i++) {
                        var f = files[i]
                        var fileReader = new FileReader();
                        fileReader.onload = (function(e) {
                            var file = e.target;
                            $('.pip-area').html("<span class=\"pip\">" +
                                "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                                "<br/><span class=\"remove_photo\">Remove image</span>" +
                                "</span>");
                            
                            $(".remove_photo").click(function(){
                                $(this).parent(".pip").remove();
                                $("#image").val('');
                            });
                        });
                        fileReader.readAsDataURL(f);
                    }
                });
            }
        })
    </script>
@endpush