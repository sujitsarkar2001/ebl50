<style>
    .project-tab {
        padding: 10%;
        margin-top: -8%;
    }
    .project-tab #tabs{
        background: #007b5e;
        color: #eee;
    }
    .project-tab #tabs h6.section-title{
        color: #eee;
    }
    .project-tab #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        color: #0062cc;
        background-color: transparent;
        border-color: transparent transparent #f3f3f3;
        border-bottom: 3px solid !important;
        font-size: 16px;
        font-weight: bold;
    }
    .project-tab .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: .25rem;
        border-top-right-radius: .25rem;
        color: #0062cc;
        font-size: 16px;
        font-weight: 600;
    }
    .project-tab .nav-link:hover {
        border: none;
    }
    .project-tab thead{
        background: #f3f3f3;
        color: #333;
    }
    .project-tab a{
        text-decoration: none;
        color: #333;
        font-weight: 600;
    }
</style>
<div class="History">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-send" data-toggle="tab" href="#send" role="tab" aria-controls="send" aria-selected="true">Send</a>
                        <a class="nav-item nav-link" id="nav-receive" data-toggle="tab" href="#receive" role="tab" aria-controls="receive" aria-selected="false">Receive</a>
                    </div>
                </nav>
            </div>
            <div class="col-12">
                <div class="tab-content mt-3" id="nav-tabContent">
                    
                    <div class="tab-pane fade show active" id="send" role="tabpanel" aria-labelledby="nav-send">
                        <div class="card p-0">
                            <div class="card-header">
                                <h4 class="card-title">Send Shop Balance History</h4>
                            </div>
                            <div class="card-body">
                                <table id="example" class="table table-bordered table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($send_shop_balances as $key => $data)
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>{{$data->user->name}}</td>
                                                <td>{{$data->user->username}}</td>
                                                <td>{{$data->amount}}</td>
                                                <td>{{date('d M Y', strtotime($data->created_at))}}</td>
                                                
                                            </tr>
                                        @endforeach
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-right">Total: </th>
                                            <th>{{$send_shop_balances->sum('amount')}} </th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade show" id="receive" role="tabpanel" aria-labelledby="nav-receive">
                        <div class="card p-0">
                            <div class="card-header">
                                <h4 class="card-title">Receive Shop Balance History</h4>
                            </div>
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($receive_shop_balances as $key => $data)
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>{{$data->parent_user->name}}</td>
                                                <td>{{$data->parent_user->username}}</td>
                                                <td>{{$data->amount}}</td>
                                                
                                                <td>{{date('d M Y', strtotime($data->created_at))}}</td>
                                                
                                            </tr>
                                        @endforeach
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-right">Total: </th>
                                            <th>{{$receive_shop_balances->sum('amount')}} </th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
   </div>
</div>

<script>
    $('#example').DataTable( {
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
    });

    $('#example2').DataTable( {
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
    });
</script>