<div class="teams">
    <div class="container">
        <div class="team row">
            <div class="card col-md-6 offset-md-3">
                <div class="profile">
                    <img src="{{asset('/')}}{{$member->avatar == 'default.png' ? 'default/user.jpg':'uploads/member/'.$member->avatar}}" alt="">
                </div>
                <div class="ledger">
                    <table>
                        <tr>
                            <th>Name</th>
                            <td>{{$member->name}}</td>
                        </tr>
                        <tr>
                            <th>Refer Id</th>
                            <td>{{$member->referer_id}}</td>
                        </tr>
                        <tr>
                            <th>Refer</th>
                            <td>{{$member->referrals->count()}}</td>
                        </tr>
                        <tr>
                            <th>Refer By</th>
                            <td>{{$member->sponsor->name ?? ''}}</td>
                        </tr>
                        <tr>
                            <th>Rank</th>
                            <td>{{$member->level}}</td>
                        </tr>
                        <tr>
                            <th>Joining</th>
                            <td>{{date('d M Y', strtotime($member->joining_date))}}</td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
        <div class="team row">
            @forelse($member->orderByChildren() as $key => $data)
                <div class="card col-md-6 offset-md-3">
                    <a href="{{route('team.tree.view.username', $data->username)}}" id="view-page">
                        <div class="profile">
                            <img src="{{asset('/')}}{{$data->avatar == 'default.png' ? 'default/user.jpg':'uploads/member/'.$data->avatar}}" alt="">
                        </div>
                        <div class="ledger">
                            <table>
                                <tr>
                                    <th>Name</th>
                                    <td>{{$data->name}}</td>
                                </tr>
                                <tr>
                                    <th>Refer Id</th>
                                    <td>{{$data->referer_id}}</td>
                                </tr>
                                <tr>
                                    <th>Refer</th>
                                    <td>{{$data->referrals->count()}}</td>
                                </tr>
                                <tr>
                                    <th>Refer By</th>
                                    <td>{{$data->sponsor->name}}</td>
                                </tr>
                                <tr>
                                    <th>Rank</th>
                                    <td>{{$data->level}}</td>
                                </tr>
                                <tr>
                                    <th>Joining</th>
                                    <td>{{date('d M Y', strtotime($data->joining_date))}}</td>
                                </tr>

                            </table>
                        </div>
                    </a>
                </div>
            @empty
                <div class="card col-md-6 offset-md-3">
                    <div class="card-body">
                        Referer Member Not Available
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
