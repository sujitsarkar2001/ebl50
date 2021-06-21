<div class="daily-work">
    <div class="contianer">
        <div class="row">
            @foreach ($notices as $notice)
                <div class="work col-md-4">
                    <div class="card text-center">
                        <a href="{{route('notice.details', $notice->slug)}}" id="view-page">
                            <div class="thumbnail">
                                <img src="{{asset('uploads/notice/'.$notice->image)}}" alt="" height="250px">
                            </div>
                            <h6>{{$notice->title}}</h6>
                        </a>
                    </div>
                </div> 
            @endforeach
            
        </div>
    </div>
</div>