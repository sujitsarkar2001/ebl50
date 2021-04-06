<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
      <i class="far fa-comments"></i>
      <span class="badge badge-danger navbar-badge">{{$chats->count()}}</span>
    </a>
    
    @if (auth()->user()->is_admin)
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
            <a href="javascript:void(0)" class="dropdown-item">

                @foreach ($chats as $chat)
                <!-- Message Start -->
                <div class="media mb-1">
                    
                    <img src="{{$chat->user->avatar != 'default.png' ? '/uploads/member/'.$chat->user->avatar:'https://ptetutorials.com/images/user-profile.png'}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                    <div class="media-body">
                        <h3 class="dropdown-item-title">
                            {{$chat->user->name}}
                            <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                        </h3>
                            <p class="text-sm">{{$chat->message}}</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{$chat->created_at->diffForHumans()}}</p>
                    </div>
                </div>
                <!-- Message End -->

                @endforeach
                
            </a>
            <div class="dropdown-divider"></div>
            @if (auth()->user()->is_admin)
                @php
                    $route = route('admin.connection.live.chat');
                @endphp
            @else
                @php
                    $route = route('connection.live.chat');
                @endphp
            @endif
            <a href="{{$route}}" class="dropdown-item dropdown-footer">See All Messages</a>
        </div> 
    @endif
    
</li>