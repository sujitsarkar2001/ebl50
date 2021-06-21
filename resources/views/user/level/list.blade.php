<div class="register">
    <div class="container">
        <div class="row">
            @forelse ($users as $key => $user)
                <div class="col-md-3 mb-2">
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="media">
                                <img class="align-self-center mr-2" width="50px" src="{{$user->avatar != 'default.png' ? '/uploads/member/'.$user->avatar:'/default/user.jpg'}}" alt="Image">
                                <div class="media-body">
                                    <h5 class="m-0">{{$user->name}}</h5>
                                    <p class="mb-0">Username: {{$user->username}} </p>
                                    <p class="mb-0">Levelup Date: {{date('d M Y', strtotime($user->level_up_date))}} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12 text-danger">
                    <div class="card">
                        <div class="card-body">
                            Members not available
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
   </div>
</div>
