<div class="daily-work">
    <div class="contianer">
        <div class="row">
            <div class="work col-md-12">
                <div class="card p-0">
                    <div class="card-header text-center">
                        {{$notice->title}}
                    </div>
                    <img src="{{asset('uploads/notice/'.$notice->image)}}" alt="" height="250px">
                    
                    <div class="card-body">
                        {!! $notice->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>