@foreach ($user->referrals as $user)
    @if ($user->referrals->count() > 0)
        <li>
            <span class="caret"><a href="{{route('team.profile', $user->id)}}">{{$user->name}}</a></span>
            <ul class="nested">
                @include('user.list-view.one', ['user' => $user])
            </ul>
        </li> 
    @else
    <li>
        <span><a href="{{route('team.profile', $user->id)}}">{{$user->name}}</a></span>
    </li> 
    @endif
    
@endforeach