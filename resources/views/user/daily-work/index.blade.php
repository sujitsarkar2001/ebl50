<div class="daily-work">
    <div class="contianer">
        <div class="row">
            <div class="col-12">
                @isset($success)
                    <div class="alert alert-primary">{{$success}}</div>
                @endisset

                @isset($error)
                    <div class="alert alert-danger">{{$error}}</div>
                @endisset
                
            </div>

            @forelse ($notWatchedVideos as $video)
                <div class="work col-md-4">
                    <div class="card text-center">
                        <a href="{{route('watch.daily.work', ['slug' => $video->slug, 'id' => $video->id])}}" id="view-page">
                            <div class="thumbnail">
                                <img src="{{$video->thumbnail == NULL ? 'https://via.placeholder.com/150':asset('/').'uploads/video/'.$video->thumbnail}}" height="220px">
                            </div>
                            <h6>{{$video->title}}</h6>
                        </a>
                    </div>
                </div>
            @empty
                <div class="work col-sm-12">
                    <div class="card text-center">
                        <h6>Daily work not available</h6>
                    </div>
                </div>
            @endforelse
            
        </div>
    </div>
</div>
