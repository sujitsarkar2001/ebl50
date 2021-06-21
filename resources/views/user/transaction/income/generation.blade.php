<div class="History">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card p-0">
                    <div class="card-header">
                        <h4 class="card-title">Generation Income History</h4>
                    </div>
                    <div class="card-body">
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($generation_incomes as $key => $data)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$data->amount}}</td>
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