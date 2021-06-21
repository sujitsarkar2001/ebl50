<div class="register">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card p-0">
                    <div class="card-header">
                        <h4 class="card-title">Contact us</h4>
                    </div>
                    <form action="{{route('connection.store.contact')}}" method="post" id="contact">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input required type="email" name="email" id="email" class="form-control" placeholder="example@gmail.com">
                                <small class="form-text text-danger email"></small>
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input required type="text" name="subject" id="subject" class="form-control" placeholder="Enter subject">
                                <small class="form-text text-danger subject"></small>
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea required name="message" id="message" rows="6" class="form-control"></textarea>
                                <small class="form-text text-danger message"></small>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <input type="submit" value="Submit" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<script>

    $(document).on('submit', '#contact', function(e) {
        e.preventDefault();

        $('small.form-text').text('');
        $('.form-control').removeClass('is-invalid');

        let method   = $(this).attr('method');
        let action   = $(this).attr('action');
        let formData = $(this).serialize();

        console.log(formData)

        $.ajax({
            type: method,
            url: action,
            data: formData,
            dataType: "JSON",
            beforeSend: function() {
                $('#loading-image').removeClass('d-none').addClass('d-block')
            },
            success: function (response) {
                $('#contact').trigger("reset");

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
                            $('#'+key+'').addClass('is-invalid');
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
</script>
