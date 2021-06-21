<div class="History">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card p-0">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">Company Send Shop Balance History</h4>
                        <div>
                            <a href="{{route('general-ledger')}}" id="view-page" class="btn btn-danger">
                                <p><i class="fas fa-long-arrow-alt-left"></i><span class="ml-1">Go Back</span></p>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Member Name</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($balances as $key => $data)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$data->user->name}}</td>
                                        <td>{{$data->amount}}</td>
                                        <td>{{date('d M Y', strtotime($data->created_at))}}</td>
                                    </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
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
</script>