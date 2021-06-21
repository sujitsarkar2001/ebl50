<div class="register">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                
                <div class="card p-0">
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
                                        <td> <a href="{{route('level.user', $level['slug'])}}" id="view-page">{{$level['name']}}</a> </td>
                                        <td>{{$level['members']}}</td>
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

