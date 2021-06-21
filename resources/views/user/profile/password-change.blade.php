<div class="register">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card p-0">
                    <div class="card-header">
                        <h4 class="card-title">Update your password</h4>
                    </div>
                    <form action="{{ route('profile.password.update') }}" method="POST" id="submit">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="current_password" class="">Current Password:</label>
                                <input required type="password" name="current_password" id="current_password" placeholder="Current Password" class="form-control @error('current_password') is-invalid @enderror">
                                <small class="form-text text-danger current_password"></small>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="">New Password:</label>
                                <input required type="password" name="password" id="password" placeholder="New Password" class="form-control @error('password') is-invalid @enderror">
                                <small class="form-text text-danger password"></small>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation" class="">Confirm Password:</label>
                                <input required type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" class="form-control">
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="form-group">
                                <button class="mt-1 btn btn-primary">
                                    <i class="fas fa-arrow-circle-up"></i>
                                    Change Password
                                </button>
                            </div>
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
            $('.form-control').removeClass('is-invalid')

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
                    if (response.alert == 'Success') {
                        window.location.replace("/login");
                    }
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
    });
</script>
