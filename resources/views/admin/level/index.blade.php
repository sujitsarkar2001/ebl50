@extends('layouts.admin.app')

@section('title', 'User Level')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>User Level</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">User Level</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Level List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SL Number</th>
                                <th>Level</th>
                                <th>Member</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($levels as $key => $level)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td> <a href="{{route('admin.level.user', $level['slug'])}}" id="btn-modal">{{$level['name']}}</a> </td>
                                    <td>{{$level['members']}}</td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

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
            
            <div class="modal-body" id="level-data">
                
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

<script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            
            $(document).on('click', '#btn-modal', function (e) {
                e.preventDefault();

                let url  = $(this).attr('href');
                let name = $(this).text();

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "JSON",
                    beforeSend: function () { 
                        $('div.loader').removeClass('d-none').addClass('d-block');
                    },
                    success: function (response) {
                        console.log(response);
                        $('#show-modal').modal('show');
                        $('.modal-title').text(name+' Level Members');
                        
                        let html = '';
                        if (response.length > 0) {
                            html += '<div class="row">';
                            $.each(response, function (key, val) {
                                html += '<div class="col-md-3">';
                                html += '<div class="card">';
                                html += '<div class="card-body p-2">';
                                html += '<div class="media">';
                                    if (val.avatar != 'default.png') {
                                        html += '<img class="align-self-center mr-2" width="50px" src="/uploads/member/'+val.avatar+'" alt="Image">';
                                    } else {
                                        html += '<img class="align-self-center mr-2" width="50px" src="/default/user.jpg" alt="Image">';
                                    }
                                html += '<div class="media-body">';
                                html += '<h5 class="m-0">'+val.name+'</h5>';
                                html += '<p class="mb-0">Username: '+val.username+'</p>';
                                html += '<p class="mb-0">Levelup Date: '+moment(val.level_up_date).format('ll')+'</p>';
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';
                            });
                            html += '</div>';

                        } else {
                            html += '<h2>Members not available</h2>';
                        }
                        
                        $('#level-data').html(html);
                        
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
        });
    </script>
@endpush
