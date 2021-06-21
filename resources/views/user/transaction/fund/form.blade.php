<div class="register">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card p-0">
                    <div class="card-header">
                        <h4 class="card-title">Add Fund</h4>
                    </div>
                    <form action="{{route('store.fund')}}" method="POST" id="submit">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <select name="method" id="method" required class="form-control">
                                    <option value="">Select Method</option>
                                    <option value="Bkash">Bkash</option>
                                    <option value="Nagad">Nagad</option>
                                    <option value="Rocket">Rocket</option>
                                </select>
                                <small class="form-text text-danger method"></small>
                            </div>
                            <div class="form-group">
                                <input type="text" name="transaction_id" id="transaction_id"  placeholder="Transaction Id" required/>
                                <small class="form-text text-danger transaction_id"></small>
                            </div>
                            <div class="form-group">
                                <input type="number" name="amount" id="amount"  placeholder="Amount" required/>
                                <small class="form-text text-danger amount"></small>
                            </div>
                            <div class="form-group">
                                <input type="number" name="number" id="number"  placeholder="Number" required/>
                                <small class="form-text text-danger number"></small>
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

            let method   = $(this).attr('method');
            let action   = $(this).attr('action');
            let formData = $(this).serialize();

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
        });
    });
</script>
