@extends('layouts.user.app')

@section('title', 'Live Chat')

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">

<style>
    .container{max-width:1170px; margin:auto;}
    img{ max-width:100%;}
    .inbox_people {
        background: #f8f8f8 none repeat scroll 0 0;
        float: left;
        overflow: hidden;
        width: 40%; border-right:1px solid #c4c4c4;
    }
    .inbox_msg {
        border: 1px solid #c4c4c4;
        clear: both;
        overflow: hidden;
    }
    .top_spac{ margin: 20px 0 0;}


    .recent_heading {float: left; width:40%;}
    .srch_bar {
        display: inline-block;
        text-align: right;
        width: 60%; padding:
    }
    .headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

    .recent_heading h4 {
        color: #05728f;
        font-size: 21px;
        margin: auto;
    }
    .srch_bar input{ 
        border:1px solid #cdcdcd; 
        border-width:0 0 1px 0; 
        width:80%; padding:2px 0 4px 6px; 
        background:none;
    }
    .srch_bar .input-group-addon button {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border: medium none;
        padding: 0;
        color: #707070;
        font-size: 18px;
    }
    .srch_bar .input-group-addon { margin: 0 0 0 -27px;}

    .chat_ib h5{ 
        font-size:15px; 
        color:#464646; 
        margin:0 0 8px 0;
    }
    .chat_ib h5 span{ font-size:13px; float:right;}
    .chat_ib p{ 
        font-size:14px; 
        color:#989898; 
        margin:auto;
        white-space: nowrap;
    }
    .chat_img {
        float: left;
        width: 11%;
    }
    .chat_ib {
        float: left;
        padding: 0 0 0 15px;
        width: 88%;
    }

    .chat_people{ overflow:hidden; clear:both;}
    .chat_list {
        border-bottom: 1px solid #c4c4c4;
        margin: 0;
        padding: 18px 16px 10px;
    }
    .inbox_chat { height: 550px; overflow-y: scroll;}

    .active_chat{ background:#ebebeb;}

    .incoming_msg_img {
        display: inline-block;
        width: 6%;
    }
    .received_msg {
        display: inline-block;
        padding: 0 0 0 10px;
        vertical-align: top;
        width: 92%;
    }
    .received_withd_msg p {
        background: #ebebeb none repeat scroll 0 0;
        border-radius: 3px;
        color: #646464;
        font-size: 14px;
        margin: 0;
        padding: 5px 10px 5px 12px;
        width: 100%;
    }
    .time_date {
        color: #747474;
        display: block;
        font-size: 12px;
    }
    .received_withd_msg { width: 57%;}
    .mesgs {
        float: left;
        padding: 30px 15px 0 25px;
        width: 60%;
    }

    .sent_msg p {
        background: #05728f none repeat scroll 0 0;
        border-radius: 3px;
        font-size: 14px;
        margin: 0; color:#fff;
        padding: 5px 10px 5px 12px;
        width:100%;
    }
    .outgoing_msg{ overflow:hidden; margin:10px 0 10px;}
    .sent_msg {
        float: right;
        width: 46%;
    }
    .input_msg_write input {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border: medium none;
        color: #4c4c4c;
        font-size: 15px;
        min-height: 48px;
        width: 100%;
    }

    .type_msg {border-top: 1px solid #c4c4c4;position: relative;}
    .msg_send_btn {
        background: #05728f none repeat scroll 0 0;
        border: medium none;
        border-radius: 50%;
        color: #fff;
        cursor: pointer;
        font-size: 17px;
        height: 33px;
        position: absolute;
        right: 0;
        top: 11px;
        width: 33px;
    }
    .messaging { padding: 0 0 50px 0;}
    .msg_history {
        height: 516px;
        overflow-y: auto;
    }
</style>
@endpush

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="">Live Chat</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Live Chat</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <div class="card">
                <div class="card-header text-center">
                    <h3 class="card-title">Live Chat</h3>
                </div>
                <div class="card-body">
                    <div class="messaging">
                        <div class="inbox_msg">
                            
                            <div class="mesgs w-100">
                                <div class="msg_history">
                                    
                                </div>
                                <div class="type_msg">
                                    <form method="post">
                                        @csrf
                                        <div class="input_msg_write">
                                            <input type="text" name="message" class="write_msg form-control" placeholder="Type a message" />
                                            <button type="submit" class="msg_send_btn btn" id="submit_form"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
    

</section>
<!-- /.content -->

@endsection

@push('js')

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
            let message = $("input[name='message']").val();
            
            $.ajax({
                type: "POST",
                url: "{{route('connection.store.chat')}}",
                data: {
                    '_token' : token,
                    'message': message
                },
                dataType: "JSON",
                success: function (response) {

                    if (response.alert == 'success') {
                        submitLiveChatForm();
                        $("input[name='message']").val('')
                    }
                    
                },
                error: function(e) {
                    console.log(e);
                }
            });
        })

        function submitLiveChatForm() {
            
            $.ajax({
                type: "GET",
                url: "{{route('connection.live.chat.list')}}",
                dataType: "JSON",
                success: function (response) {
                    
                    if (response != '') {
                        
                        let data = '';

                        $.each(response, function (key, val) { 

                            if (val.user_message_log == 'incoming') {
                                
                                data += '<div class="incoming_msg">';
                                data += '<div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>';
                                data += '<div class="received_msg">';
                                data += '<div class="received_withd_msg">';
                                data += '<p>'+val.message+'</p>';
                                data += '<span class="time_date">'+moment(val.created_at).format('LLL')+'</span>';
                                data += '</div>';
                                data += '</div>';
                                data += '</div>';
                                
                            } else {
                                data += '<div class="outgoing_msg">';
                                data += '<div class="sent_msg">';
                                data += '<p>'+val.message+'</p>';
                                data += '<span class="time_date">'+moment(val.created_at).format('LLL')+'</span> ';
                                data += '</div>';
                                data += '</div>';
                            }  
                        });
                        $('.msg_history').html(data);
                        
                    }
                }
            });
            
        }

        setInterval(function () {
            submitLiveChatForm();
        }, 5000);
    });

        
</script>

@endpush