@extends('layouts.admin.app')

@section('title', 'Settings')

@push('css')
    <style>
        .imageThumb {
            max-height: 75px;
            border: 2px solid;
            padding: 1px;
            cursor: pointer;
        }
        .pip {
            display: inline-block;
            margin: 10px 10px 0 0;
        }
        .remove_photo {
            display: block;
            background: #444;
            border: 1px solid black;
            color: white;
            text-align: center;
            cursor: pointer;
        }
        .remove_photo:hover {
            background: white;
            color: black;
        }
    </style>
@endpush

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Setting</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">My Profile</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Application Settings</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header bg-success">
                            <h3 class="card-title">Application Images</h3>
                        </div>
                        <form action="{{route('admin.update.logo')}}" method="post" enctype="multipart/form-data" id="image-submit">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="logo">Logo:</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                          <input type="file" class="custom-file-input" id="logo" name="logo">
                                          <label class="custom-file-label" for="logo">Choose file</label>
                                        </div>
                                    </div>
                                    
                                    <div class="pip-area logo">
                                        <span class="pip">
                                            <img class="imageThumb" src="{{asset('uploads/setting/'.setting('logo'))}}" title="Logo">
                                        </span>
                                    </div>
                                    <small class="form-text text-danger logo"></small>
                                    
                                </div>
                                <div class="form-group">
                                    <label for="auth_logo">Login Logo:</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                          <input type="file" class="custom-file-input" id="auth_logo" name="auth_logo">
                                          <label class="custom-file-label" for="auth_logo">Choose file</label>
                                        </div>
                                    </div>
                                    <div class="pip-area auth_logo">
                                        <span class="pip">
                                            <img class="imageThumb" src="{{asset('uploads/setting/'.setting('auth_logo'))}}" title="Login Logo">
                                        
                                        </span>
                                    </div>
                                    <small class="form-text text-danger auth_logo"></small>
                                </div>
                                <div class="form-group">
                                    <label for="favicon">Favicon:</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                          <input type="file" class="custom-file-input" id="favicon" name="favicon">
                                          <label class="custom-file-label" for="favicon">Choose file</label>
                                        </div>
                                    </div>
                                    <div class="pip-area favicon">
                                        <span class="pip">
                                            <img class="imageThumb" src="{{asset('uploads/setting/'.setting('favicon'))}}" title="Favicon">
                                        
                                        </span>
                                    </div>
                                    <small class="form-text text-danger favicon"></small>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success bnt-block">
                                    <i class="fas fa-arrow-circle-up"></i>
                                    Update
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="col-sm-8">
                    <!-- Default box -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Setting</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{route('admin.setting.update')}}" method="POST" id="submit-form">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-row">
                                    @foreach ($settings as $key => $setting)
                                        @php
                                            $name = str_replace('_', ' ', $setting->name)
                                        @endphp
                                        @if($setting->name == 'copy_right_text')
                                            <div class="form-group col-md-12 {{$setting->name}}">
                                                <label for="{{$setting->name}}" class="text-capitalize">{{$name}}</label>
                                                <input type="text" class="form-control" name="{{$setting->name}}" value="{{$setting->value}}">
                                                @error($setting->name)
                                                    <small class="form-text text-danger">{{$message}}</small>
                                                @enderror
                                            </div>
                                        @else
                                            <div class="form-group col-md-6 {{$setting->name}}">
                                                <label for="{{$setting->name}}" class="text-capitalize">{{$name}} (<span class="text-danger">TK</span>) </label>
                                                <input type="text" class="form-control" name="{{$setting->name}}" value="{{$setting->value}}">
                                                @error($setting->name)
                                                    <small class="form-text text-danger">{{$message}}</small>
                                                @enderror
                                            </div>
                                        @endif


                                    @endforeach
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-arrow-circle-up"></i>
                                    Update
                                </button>
                            </div>
                            <!-- /.card-footer -->
                        </form>

                        {{-- <form action="{{route('admin.setting.update')}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label for="single_package">Single Package (<span class="text-danger">TK</span>) </label>
                                        <input type="number" class="form-control" id="single_package" name="single_package" value="{{setting('single_package')}}">
                                        @error('single_package')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="share_package">Share Package (<span class="text-danger">TK</span>) </label>
                                        <input type="number" class="form-control" id="share_package" name="share_package" value="{{setting('share_package')}}">
                                        @error('share_package')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="share_package_bonus">Share Package Bonus (<span class="text-danger">TK</span>) </label>
                                        <input type="number" class="form-control" id="share_package_bonus" name="share_package_bonus" value="{{setting('share_package_bonus')}}">
                                        @error('share_package_bonus')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="money_exchange_charge">Money Exchange Charge (<span class="text-danger">TK</span>) </label>
                                        <input type="number" class="form-control" id="money_exchange_charge" name="money_exchange_charge" value="{{setting('money_exchange_charge')}}">
                                        @error('money_exchange_charge')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="withdraw_charge_in_bank">Withdraw Charge in Bank (<span class="text-danger">TK</span>) </label>
                                        <input type="number" class="form-control" id="withdraw_charge_in_bank" name="withdraw_charge_in_bank" value="{{setting('withdraw_charge_in_bank')}}">
                                        @error('withdraw_charge_in_bank')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="withdraw_charge_in_bkash">Withdraw Charge in Bkash (<span class="text-danger">%</span>) </label>
                                        <input type="number" class="form-control" id="withdraw_charge_in_bkash" name="withdraw_charge_in_bkash" value="{{setting('withdraw_charge_in_bkash')}}">
                                        @error('withdraw_charge_in_bkash')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="withdraw_charge_in_nagad">Withdraw Charge in Nagad (<span class="text-danger">%</span>) </label>
                                        <input type="number" class="form-control" id="withdraw_charge_in_nagad" name="withdraw_charge_in_nagad" value="{{setting('withdraw_charge_in_nagad')}}">
                                        @error('withdraw_charge_in_nagad')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="withdraw_charge_in_rocket">Withdraw Charge in Rocket (<span class="text-danger">%</span>) </label>
                                        <input type="number" class="form-control" id="withdraw_charge_in_rocket" name="withdraw_charge_in_rocket" value="{{setting('withdraw_charge_in_rocket')}}">
                                        @error('withdraw_charge_in_rocket')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="generation_one_income">Generation One Income (<span class="text-danger">TK</span>) </label>
                                        <input type="number" class="form-control" id="generation_one_income" name="generation_one_income" value="{{setting('generation_one_income')}}">
                                        @error('generation_one_income')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="generation_one_plus_income">Generation One Plus Income (<span class="text-danger">TK</span>) </label>
                                        <input type="number" class="form-control" id="generation_one_plus_income" name="generation_one_plus_income" value="{{setting('generation_one_plus_income')}}">
                                        @error('generation_one_plus_income')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="level_one_bonus">Level One Bonus (<span class="text-danger">TK</span>) </label>
                                        <input type="number" class="form-control" id="level_one_bonus" name="level_one_bonus" value="{{setting('level_one_bonus')}}">
                                        @error('level_one_bonus')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="level_two_bonus">Level Two Bonus (<span class="text-danger">TK</span>) </label>
                                        <input type="number" class="form-control" id="level_two_bonus" name="level_two_bonus" value="{{setting('level_two_bonus')}}">
                                        @error('level_two_bonus')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="level_three_bonus">Level Three Bonus (<span class="text-danger">TK</span>) </label>
                                        <input type="number" class="form-control" id="level_three_bonus" name="level_three_bonus" value="{{setting('level_three_bonus')}}">
                                        @error('level_three_bonus')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="level_four_bonus">Level Four Bonus (<span class="text-danger">TK</span>) </label>
                                        <input type="number" class="form-control" id="level_four_bonus" name="level_four_bonus" value="{{setting('level_four_bonus')}}">
                                        @error('level_four_bonus')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="level_five_bonus">Level Five Bonus (<span class="text-danger">TK</span>) </label>
                                        <input type="number" class="form-control" id="level_five_bonus" name="level_five_bonus" value="{{setting('level_five_bonus')}}">
                                        @error('level_five_bonus')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="level_six_bonus">Level Six Bonus (<span class="text-danger">TK</span>) </label>
                                        <input type="number" class="form-control" id="level_six_bonus" name="level_six_bonus" value="{{setting('level_six_bonus')}}">
                                        @error('level_six_bonus')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="level_seven_bonus">Level Seven Bonus (<span class="text-danger">TK</span>) </label>
                                        <input type="number" class="form-control" id="level_seven_bonus" name="level_seven_bonus" value="{{setting('level_seven_bonus')}}">
                                        @error('level_seven_bonus')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="level_eight_bonus">Level Eight Bonus (<span class="text-danger">TK</span>) </label>
                                        <input type="number" class="form-control" id="level_eight_bonus" name="level_eight_bonus" value="{{setting('level_eight_bonus')}}">
                                        @error('level_eight_bonus')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="level_nine_bonus">Level Nine Bonus (<span class="text-danger">TK</span>) </label>
                                        <input type="number" class="form-control" id="level_nine_bonus" name="level_nine_bonus" value="{{setting('level_nine_bonus')}}">
                                        @error('level_nine_bonus')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="level_ten_bonus">Level Ten Bonus (<span class="text-danger">TK</span>) </label>
                                        <input type="number" class="form-control" id="level_ten_bonus" name="level_ten_bonus" value="{{setting('level_ten_bonus')}}">
                                        @error('level_ten_bonus')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="level_eleven_bonus">Level Eleven Bonus (<span class="text-danger">TK</span>) </label>
                                        <input type="number" class="form-control" id="level_eleven_bonus" name="level_eleven_bonus" value="{{setting('level_eleven_bonus')}}">
                                        @error('level_eleven_bonus')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="copy_right_text">Copy Right Text </label>
                                        <input type="text" class="form-control" id="copy_right_text" name="copy_right_text" value="{{setting('copy_right_text')}}">
                                        @error('copy_right_text')
                                            <small class="form-text text-danger"></small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-arrow-circle-up"></i>
                                    Update
                                </button>
                            </div>
                            <!-- /.card-footer -->
                        </form> --}}
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>



</section>
<!-- /.content -->

@endsection

@push('js')
    <script>

        $(document).ready(function() {
            $('.col-md-6.logo').remove();
            $('.col-md-6.auth_logo').remove();
            $('.col-md-6.favicon').remove();

            $('label[for="share_package_bonus"] span').text('%');
            $('label[for="withdraw_charge_in_bank"] span').text('%');
            $('label[for="withdraw_charge_in_rocket"] span').text('%');
            $('label[for="withdraw_charge_in_bkash"] span').text('%');
            $('label[for="withdraw_charge_in_nagad"] span').text('%');
            $('label[for="money_exchange_charge"] span').text('%');


            // store new data
            $(document).on('submit', '#image-submit', function(e) {
                e.preventDefault();

                let method   = $(this).attr('method');
                let action   = $(this).attr('action');
                var formData = new FormData($(this)[0]);

                $('small.form-text').text('');
                $('.custom-file-input').removeClass('is-invalid');

                $.ajax({
                    type: method,
                    url: action,
                    data: formData,
                    dataType: "JSON",
                    async: false,
                    cache: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    beforeSend: function () { 
                        $('button[type="submit"]').attr('disabled', true);
                    },
                    success: function (response) {
                        
                        if (response.alert == 'Success') {
                            
                            $.toast({
                                heading: 'Congratulations',
                                text: response.message,
                                icon: response.alert.toLowerCase(),
                                position: 'top-right',
                                stack: false
                            })
                        }
                    },
                    complete: function () { 
                        $('button[type="submit"]').attr('disabled', false);
                    },
                    error: function (xhr) {
                        if (xhr.status == 422) {
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
                        }
                        else {
                            $.toast({
                                heading: xhr.status,
                                text: xhr.responseText,
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        }
                    }
                });

            });


            $(document).on('submit', '#submit-form', function(e) {
                e.preventDefault();

                let method   = $(this).attr('method');
                let action   = $(this).attr('action');
                var formData = $(this).serialize();

                $('small.form-text').text('');
                $('.form-control').removeClass('is-invalid');

                $.ajax({
                    type: method,
                    url: action,
                    data: formData,
                    beforeSend: function () { 
                        $('button[type="submit"]').attr('disabled', true);
                    },
                    success: function (response) {
                        $.toast({
                            heading: 'Congratulations',
                            text: response.message,
                            icon: response.alert.toLowerCase(),
                            position: 'top-right',
                            stack: false
                        });
                    },
                    complete: function () { 
                        $('button[type="submit"]').attr('disabled', false);
                    },
                    error: function (xhr) {
                        if (xhr.status == 422) {
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
                        }
                        else {
                            $.toast({
                                heading: xhr.status,
                                text: xhr.responseText,
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        }
                    }
                });

            });

            if (window.File && window.FileList && window.FileReader) {
                
                $("#logo").on("change", function(e) {
                    var files = e.target.files,
                    filesLength = files.length;

                    $(".logo .pip").remove();

                    for (var i = 0; i < filesLength; i++) {
                        var f = files[i]
                        var fileReader = new FileReader();
                        fileReader.onload = (function(e) {
                            var file = e.target;
                            $('.pip-area.logo').html("<span class=\"pip\">" +
                                "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                                "<br/><span class=\"remove_photo\">Remove image</span>" +
                                "</span>");
                            
                            $(".remove_photo").click(function(){
                                $(this).parent(".pip").remove();
                                $("#logo").val('');
                            });
                        });
                        fileReader.readAsDataURL(f);
                    }
                });
                
                $("#auth_logo").on("change", function(e) {
                    var files = e.target.files,
                    filesLength = files.length;

                    $(".auth_logo .pip").remove();

                    for (var i = 0; i < filesLength; i++) {
                        var f = files[i]
                        var fileReader = new FileReader();
                        fileReader.onload = (function(e) {
                            var file = e.target;
                            $('.pip-area.auth_logo').html("<span class=\"pip\">" +
                                "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                                "<br/><span class=\"remove_photo\">Remove image</span>" +
                                "</span>");
                            
                            $(".remove_photo").click(function(){
                                $(this).parent(".pip").remove();
                                $("#auth_logo").val('');
                            });
                        });
                        fileReader.readAsDataURL(f);
                    }
                });
                
                $("#favicon").on("change", function(e) {
                    var files = e.target.files,
                    filesLength = files.length;

                    $(".favicon .pip").remove();

                    for (var i = 0; i < filesLength; i++) {
                        var f = files[i]
                        var fileReader = new FileReader();
                        fileReader.onload = (function(e) {
                            var file = e.target;
                            $('.pip-area.favicon').html("<span class=\"pip\">" +
                                "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                                "<br/><span class=\"remove_photo\">Remove image</span>" +
                                "</span>");
                            
                            $(".remove_photo").click(function(){
                                $(this).parent(".pip").remove();
                                $("#favicon").val('');
                            });
                        });
                        fileReader.readAsDataURL(f);
                    }
                });
            }

        });

    </script>
@endpush
