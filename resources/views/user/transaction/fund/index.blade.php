<div class="History">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card p-0">
                    <div class="card-header">
                        <h4 class="card-title">Add Fund History</h4>
                    </div>
                    <div class="card-body">
                        <table id="example" class="table table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Date</th>
                                    <th>Method</th>
                                    <th>Trans ID</th>
                                    <th>Number</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($funds as $key => $data)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{date('d M Y', strtotime($data->created_at))}}</td>
                                        <td>{{$data->method}}</td>
                                        <td>{{$data->transaction_id}}</td>
                                        <td>{{$data->number}}</td>
                                        <td>{{$data->amount}}</td>
                                        <td>
                                            @if ($data->status)
                                                <span class="badge badge-success">Approved</span>
                                            @else
                                                <span class="badge badge-danger">Pending</span>
                                            @endif
                                        </td>
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