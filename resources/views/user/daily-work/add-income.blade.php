<div class="daily-work">
    <div class="contianer">
        <div class="row">
            <div class="col-sm-4 offset-sm-4">
                <!-- Default box -->
                <div class="card p-0">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title">Daily Work Income</h5>
                        
                        <div>
                            <a href="{{route('add.watch',['slug' => $video->slug, 'id' => $video->id])}}" class="btn btn-primary" id="add-income">
                                <i class="fas fa-plus"></i>
                                Add Income <span id="time"></span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <iframe width="100%" height="300px" src="{{$video->link}}"> </iframe>
                                
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '#add-income', function(e) {
        e.preventDefault();
        let url = $(this).attr('href')
        
        $.ajax({
            type: 'GET',
            url: url,
            dataType: "HTML",
            beforeSend: function() {
                $('#loading-image').removeClass('d-none').addClass('d-block')
            },
            success: function (response) {
                
                $('#main-content').empty()
                $('#main-content').html(response)
            },
            complete: function() {
                $('#loading-image').addClass('d-none').removeClass('d-block')
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    })

    $('#add-income').addClass('disabled');
    var timeleft = 10;
    var clickTimer = setInterval(function(){

        if(timeleft <= 0){
            clearInterval(clickTimer);
            $('#add-income').removeClass('disabled');
            document.getElementById("time").innerHTML = "";
        
        } else {
            document.getElementById("time").innerHTML = timeleft;
        }

        timeleft -= 1;

    }, 1000);
    

</script>
