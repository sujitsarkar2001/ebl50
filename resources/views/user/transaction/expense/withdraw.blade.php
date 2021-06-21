<div class="History">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card p-0">
                    <div class="card-header">
                        <h4 class="card-title">Withdraw History</h4>
                    </div>
                    <div class="card-body">
                        <table id="example" class="table table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Holder Name</th>
                                    <th>Account Number</th>
                                    <th>Method</th>
                                    <th>Amount</th>
                                    <th>Charge</th>
                                    <th>After Charge</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($withdraws as $key => $data)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$data->holder_name}}</td>
                                        <td>{{$data->account_number}}</td>
                                        <td>{{$data->method}}</td>
                                        <td>{{$data->amount}}</td>
                                        <td>{{$data->charge}}</td>
                                        <td>{{$data->after_charge}}</td>
                                        <td>
                                            @if ($data->status)
                                                <span class="badge badge-success">Paid</span>
                                            @else
                                                <span class="badge badge-danger">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{date('d M Y', strtotime($data->date))}}</td>
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