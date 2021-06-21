@foreach ($member->referrals as $data)
    @if ($member->referrals->count() > 0)
        <li>
            <span class="caret">
                <a href="{{route('team.profile', $data->username)}}" id="view-page">{{$data->name}} ({{$data->username}})</a>
            </span>
            <ul class="nested">
                @include('user.list-view.one', ['member' => $data])
            </ul>
        </li>
    @else
    <li>
        <span>
            <a href="{{route('team.profile', $data->username)}}" id="view-page">{{$data->name}} ({{$data->username}})</a>
        </span>
    </li>
    @endif

@endforeach
