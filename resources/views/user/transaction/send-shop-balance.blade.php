<div class="register">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card p-0">
                    <div class="card-header">
                        <h4 class="card-title">Send Shop Balance</h4>
                    </div>
                    <form action="{{route('store.shop.balance')}}" method="POST" id="submit">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <input type="username" name="username" id="username" class="form-control mb-0"  placeholder="Enter receiver username" required/>
                                <small class="form-text text-danger username"></small>
                            </div>

                            <div class="form-group">
                                <input type="number" name="amount" id="amount" class="form-control mb-0" placeholder="Amount" required/>
                                <small class="form-text text-danger amount"></small>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input  type="submit" value="Submit"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
   </div>
</div>

<script>
    $(document).ready(function () {

        $(document).on('submit', '#submit', function(e) {
            e.preventDefault();
            
            $('small.form-text').text('')

            let method   = $(this).attr('method')
            let action   = $(this).attr('action')
            var formData = $(this).serialize();
            
            $.ajax({
                type: method,
                url: action,
                data: formData,
                dataType: "JSON",
                beforeSend: function() {
                    $('#loading-image').removeClass('d-none').addClass('d-block')
                },
                success: function (response) {
                    $('#submit').trigger("reset");

                    $.toast({
                        heading: response.alert,
                        text: response.message,
                        icon: response.alert.toLowerCase(),
                        position: 'top-right',
                        stack: false
                    });
                },
                complete: function() {
                    $('#loading-image').addClass('d-none').removeClass('d-block')
                },
                error: function (xhr) {
                    if (xhr.status === 0) {
                        $.toast({
                            heading: 'Error',
                            text: 'Not connected Please verify your network connection.',
                            icon: 'error',
                            position: 'top-right',
                            stack: false
                        });

                    } else if (xhr.status == 404) {
                        $.toast({
                            heading: 'Error',
                            text: 'The requested data not found. [404]',
                            icon: 'error',
                            position: 'top-right',
                            stack: false
                        });

                    } else if (xhr.status == 500) {
                        $.toast({
                            heading: 'Error',
                            text: 'Internal Server Error [500].',
                            icon: 'error',
                            position: 'top-right',
                            stack: false
                        });

                    } else if (xhr === 'parsererror') {
                        $.toast({
                            heading: 'Error',
                            text: 'Requested JSON parse failed.',
                            icon: 'error',
                            position: 'top-right',
                            stack: false
                        });

                    } else if (xhr === 'timeout') {
                        $.toast({
                            heading: 'Error',
                            text: 'Requested Time out.',
                            icon: 'error',
                            position: 'top-right',
                            stack: false
                        });

                    } else if (xhr === 'abort') {
                        $.toast({
                            heading: 'Error',
                            text: 'Request aborted.',
                            icon: 'error',
                            position: 'top-right',
                            stack: false
                        });

                    } else if (xhr.status == 422) {
                        if (typeof(xhr.responseJSON.errors) !== 'undefined') {
                            
                            $.each(xhr.responseJSON.errors, function (key, error) { 
                                $('small.'+key+'').text(error);
                            });
                            
                            if (typeof(xhr.responseJSON.message) !== 'undefined') {
                                $.toast({
                                    heading: 'Error',
                                    text: xhr.responseJSON.message,
                                    icon: 'error',
                                    position: 'top-right',
                                    stack: false
                                });
                            }
                        }

                    } else {
                        return ('Uncaught Error.\n' + xhr.responseText);
                    }
                }
            });
        })
    });
</script>