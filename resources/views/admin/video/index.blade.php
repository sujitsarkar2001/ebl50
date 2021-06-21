@extends('layouts.admin.app')

@section('title', 'Video')

@push('css')
    <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('/')}}assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{asset('/')}}assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
                    <a href="javascript:void(0)" class="btn btn-success" id="add-btn">
                        <i class="fas fa-plus-circle"></i>
                        Add New Video
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
                        <th>Title</th>
                        <th>Link</th>
                        <th>Views</th>
                        <th>Rate</th>
                        <th>Added</th>
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
    <div class="modal-dialog modal-lg">
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
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="title" placeholder="Enter video title" class="form-control" >
                        <small class="form-text text-danger title"></small>
                    </div>
                    <div class="form-group">
                        <label for="link">Video Link:</label>
                        <input type="text" name="link" id="link" placeholder="Enter video link" class="form-control" >
                        <small class="form-text text-danger link"></small>
                    </div>
                    <div class="rate-area">

                    </div>
    
                    <div class="form-group">
                        <label for="thumbnail">Thumbnail:</label>
                        <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail">
                              <label class="custom-file-label" for="thumbnail">Choose file</label>
                            </div>
                        </div>
                        <div class="pip-area"></div>
                        <small class="form-text text-danger thumbnail"></small>
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
    <script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script>
        $(function () {

            // show all data in table
            let table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                "responsive": true,
                "autoWidth": false,
                ajax: '{!! route('admin.video.data') !!}',
                columns: [
                    {data: 'DT_RowIndex', searchable: false},
                    {data: 'title', name: 'title'},
                    {data: 'link', name: 'link'},
                    {data: 'views', name: 'views'},
                    {data: 'rate', name: 'rate'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // add new data
            $(document).on('click', '#add-btn', function(e) {

                e.preventDefault();

                $('#modal').modal('show');
                $('.modal-title').text('Add New Video');

                $('#form-submit').trigger("reset").attr('action', '{!! route('admin.video.store') !!}');
                $('input#method').removeAttr('name').val('');
                $('small.form-text').text('');
                $('.form-control, .custom-file-input').removeClass('is-invalid');
                $('button[type="submit"]').attr('disabled', false).text('Submit');
                $('.pip-area').empty();
                $('.rate-area').empty();
                
            });

            // store new data
            $(document).on('submit', '#form-submit', function(e) {
                e.preventDefault();

                let method   = $(this).attr('method');
                let action   = $(this).attr('action');
                var formData = new FormData($(this)[0]);

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
                        $.toast({
                            heading: 'Congratulations',
                            text: response.message,
                            icon: response.alert.toLowerCase(),
                            position: 'top-right',
                            stack: false
                        })

                        $('#modal').modal('hide');

                        table.ajax.reload();
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
                            
                            $('#form-submit').trigger("reset").attr('action', '/admin/video/'+response.id);
                            $('input#method').attr('name', '_method').val('PUT');
                            
                            $('#modal').modal('show');
                            $('small.form-text').text('');
                            $('.form-control, .custom-file-input').removeClass('is-invalid');
                            $('.modal-title').text('Update Video');
                            
                            $('button[type="submit"]').attr('disabled', false).text('Update');
                        
                            // show value in input tag
                            $('input#title').val(response.title);
                            $('input#link').val(response.link);
                            
                            let html = '<span class="pip">';
                                html += '<img class="imageThumb" src="/uploads/video/'+ response.thumbnail+'"/>';
                                html += '</span>';
                            
                            let rate = '<div class="form-group">';
                                rate += '<label for="rate">Video Rate:</label>';
                                rate += '<input type="number" name="rate" id="rate" value="'+response.rate+'" placeholder="Enter video rate" class="form-control" >';
                                rate += '<small class="form-text text-danger rate"></small>';
                                rate += '</div>';
                            
                            $('.rate-area').html(rate);
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

            if (window.File && window.FileList && window.FileReader) {
                
                $("#thumbnail").on("change", function(e) {
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
                                $("#thumbnail").val('');
                            });
                        });
                        fileReader.readAsDataURL(f);
                    }
                });
            }
        })
    </script>
@endpush