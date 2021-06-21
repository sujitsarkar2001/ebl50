<div class="main-area massanger" id="main">
    <div class="main-top-backgroud">
        <div class="sv">
            <div class="herobanner__footer" ><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="2400px" height="32px" viewBox="0 0 2400 32" xml:space="preserve" preserveAspectRatio="none" class="herobanner__footer-mask" ><path d="M0,0c0,0,563,30,1200,30c706,0,1200-30,1200-30v32H0V0z" class="herobanner__footer-mask-curve"></path></svg></div>
        </div>
    </div>
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100">
            
            <div class="col-md-8 col-xl-6 chat">
                <div class="card">
                    <div class="card-header msg_head">
                        <div class="d-flex bd-highlight">
                            <div class="img_cont">
                                <img src="/uploads/setting/{{setting('auth_logo')}}" class="rounded-circle user_img">
                                <span class="online_icon"></span>
                            </div>
                            <div class="user_info">
                                <span>Chat with {{config('app.name')}}</span>
                                <p>{{$messages}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body msg_card_body">

                    </div>
                    <div class="card-footer">
                        <form action="{{route('connection.store.chat')}}" method="post">
                            @csrf
                            <div class="input-group">
                                <textarea name="message" id="message" class="form-control type_msg" placeholder="Type your message..."></textarea>
                                <div class="input-group-append" id="submit_form">
                                    <span class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></span>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>

<script>

    $(document).ready(function () {
        
        $(document).on('submit', '#contact', function (e) {
            e.preventDefault();
            let data = $(this).serialize();
            $('small.form-text').text('');
            $('.card-footer button').addClass('disabled')
            $.ajax({
                type: "POST",
                url: "{{ route('connection.store.contact') }}",
                data: data,
                dataType: "JSON",
                success: function (response) {
                    if (response.alert == 'success') {
                        $('.alert-message').removeClass('d-none')
                        $('input.form-control').val('')
                        $('textarea.form-control').val('')
                        $('.card-footer button').removeClass('disabled')
                    }
                },
                error: function(e) {
                    $('.card-footer button').removeClass('disabled')
                    if (typeof e.responseJSON.errors.email != 'undefined') {
                        $('small.email-error').text(e.responseJSON.errors.email[0])
                    }
                    if (typeof e.responseJSON.errors.subject != 'undefined') {
                        $('small.subject-error').text(e.responseJSON.errors.subject[0])
                    }
                    if (typeof e.responseJSON.errors.message != 'undefined') {
                        $('small.message-error').text(e.responseJSON.errors.message[0])
                    }
                }
            });
        })

        $(document).on('click', '#submit_form', function (e) {
            e.preventDefault();
            let token   = $("input[name='_token']").val();
            let message = $("textarea[name='message']").val();
            
            if (message != '') {

                $.ajax({
                    type: 'POST',
                    url: '{!! route('connection.store.chat') !!}',
                    data: {
                        '_token' : token,
                        'message': message
                    },
                    dataType: "JSON",
                    success: function (response) {

                        if (response.alert == 'success') {
                            submitLiveChatForm();
                            $("textarea[name='message']").val('')
                        }
                        
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
                            if (typeof(xhr.responseJSON.message) !== 'undefined') {
                                $.toast({
                                    heading: 'Error',
                                    text: xhr.responseJSON.message,
                                    icon: 'error',
                                    position: 'top-right',
                                    stack: false
                                });
                            }

                        } else {
                            return ('Uncaught Error.\n' + xhr.responseText);
                        }
                    }
                });
            }
        })

        function submitLiveChatForm() {
            let auth_img = $('.img_cont img').attr('src')

            $('.msg_card_body').empty('');

            $.ajax({
                type: "GET",
                url: "{{route('connection.live.chat.list')}}",
                dataType: "JSON",
                success: function (response) {
                    
                    if (response != '') {
                        
                        let data = '';

                        $.each(response, function (key, val) { 

                            if (val.user_message_log == 'incoming') {
                                
                                data += '<div class="d-flex justify-content-start mb-4">';
                                data += '<div class="img_cont_msg">';
                                data += '<img src="'+auth_img+'" class="rounded-circle user_img_msg">';
                                data += '</div>';
                                data += '<div class="msg_cotainer">';
                                data += val.message;
                                data += '<span class="msg_time">'+moment(val.created_at).format('LLL')+'</span>';
                                data += '</div>';
                                data += '</div>';
                                
                            } else {
                                data += '<div class="d-flex justify-content-end mb-4">';
                                data += '<div class="img_cont_msg">';
                                data += '<img src="/uploads/member/'+val.user.avatar+'" class="rounded-circle user_img_msg">';
                                data += '</div>';
                                data += '<div class="msg_cotainer">';
                                data += val.message;
                                data += '<span class="msg_time">'+moment(val.created_at).format('LLL')+'</span>';
                                data += '</div>';
                                data += '</div>';
                            }  
                        });
                        $('.msg_card_body').append(data);
                        
                    }
                }
            });
            
        }
        submitLiveChatForm();
        setInterval(function () {
            submitLiveChatForm();
        }, 10000);
    });

        
</script>
