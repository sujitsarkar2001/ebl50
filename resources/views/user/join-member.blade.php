<style>
    .project-tab {
        padding: 10%;
        margin-top: -8%;
    }
    .project-tab #tabs{
        background: #007b5e;
        color: #eee;
    }
    .project-tab #tabs h6.section-title{
        color: #eee;
    }
    .project-tab #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        color: #0062cc;
        background-color: transparent;
        border-color: transparent transparent #f3f3f3;
        border-bottom: 3px solid !important;
        font-size: 16px;
        font-weight: bold;
    }
    .project-tab .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: .25rem;
        border-top-right-radius: .25rem;
        color: #0062cc;
        font-size: 16px;
        font-weight: 600;
    }
    .project-tab .nav-link:hover {
        border: none;
    }
    .project-tab thead{
        background: #f3f3f3;
        color: #333;
    }
    .project-tab a{
        text-decoration: none;
        color: #333;
        font-weight: 600;
    }
</style>
<div class="register">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-basic" data-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">Basic Information</a>
                        <a class="nav-item nav-link" id="nav-contact" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact Information</a>
                        <a class="nav-item nav-link" id="nav-bank" data-toggle="tab" href="#bank" role="tab" aria-controls="bank" aria-selected="false">Bank Information</a>
                        <a class="nav-item nav-link" id="nav-mobile" data-toggle="tab" href="#mobile" role="tab" aria-controls="mobile" aria-selected="false">Mobile Bank Information</a>
                    </div>
                </nav>
            </div>

            <form action="{{route('store.referrer')}}" id="submit" method="post" style="width: 100%">
                @csrf
                <div class="tab-content mt-3" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="nav-basic">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="card p-0">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="placement_id">Placement ID</label>
                                                <input type="number" name="placement_id" id="placement_id" class="form-control" placeholder="Enter Placement ID">
                                                <small class="form-text text-danger placement_id"></small>
                                            </div>
                                            
                                            <div class="form-group col-md-6">
                                                <label for="name">Name <span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control" placeholder="Name">
                                                <small class="form-text text-danger name"></small>
                                            </div>
                                            
                                            <div class="form-group col-md-6">
                                                <label for="username">Username <span class="text-danger">*</span></label>
                                                <input type="text" name="username" class="form-control" placeholder="Username">
                                                <small class="form-text text-danger username"></small>
                                            </div>
                                            
                                            <div class="form-group col-md-6">
                                                <label for="email">Email <span class="text-danger">*</span></label>
                                                <input type="email" name="email" id="email" class="form-control" placeholder="example@gmail.com">
                                                <small class="form-text text-danger email"></small>
                                            </div>
            
                                            <div class="form-group col-md-6">
                                                <label for="post_code">Post Code <span class="text-danger">*</span></label>
                                                <input type="number" name="post_code" id="post_code" class="form-control" maxlength="25" placeholder="Post Code">
                                                <small class="form-text text-danger post_code"></small>
                                            </div>
            
                                            <div class="form-group col-md-6">
                                                <label for="phone">Phone <span class="text-danger">*</span></label>
                                                <input type="text" name="phone" id="phone" class="form-control" maxlength="25" placeholder="Phone Number">
                                                <small class="form-text text-danger phone"></small>
                                            </div>
                                            
                                            <div class="form-group col-md-6">
                                                <label for="country">Country <span class="text-danger">*</span></label>
                                                <input type="text" id='country' name='country' class="form-control" placeholder="Country">
                                                <small class="form-text text-danger country"></small>
                                            </div>
            
                                            <div class="form-group col-md-6">
                                                <label for="direction">Side <span class="text-danger">*</span></label>
                                                <select name="direction" id="direction" class="form-control">
                                                    <option value="">Select Side</option>
                                                    <option value="1">Left Side</option>
                                                    <option value="2">Middle Side</option>
                                                    <option value="3">Right Side</option>
                                                </select>
                                                
                                                <small class="form-text text-danger direction"></small>
                                            </div>
                                        </div>
                                        
                        
                                        <div class="form-group">
                                            <label for="register_package">Register Package <span class="text-danger">*</span></label>
                                            <select name="register_package" id="register_package" class="form-control">
                                                <option value="">Select Package</option>
                                                <option value="{{setting('single_package')}}">Single Package ({{setting('single_package')}})</option>
                                                <option value="{{setting('share_package')}}">Share Package ({{setting('share_package')}})</option>
                                            </select>
                                            
                                            <small class="form-text text-danger register_package"></small>
                                        </div>
        
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="password">Password <span class="text-danger">*</span></label>
                                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                                
                                                <small class="form-text text-danger password"></small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="password-confirm">Retype Password <span class="text-danger">*</span></label>
                                                <input type="password" name="password_confirmation" id="password-confirm" class="form-control" placeholder="Retype Password">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade show" id="contact" role="tabpanel" aria-labelledby="nav-contact">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="card p-0">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="d_o_b">Date of Birth</label>
                                                <input type="date" name="d_o_b" id="d_o_b" class="form-control">
                                                
                                                <small class="form-text text-danger d_o_b"></small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="gender">Gender</label>
                                                <select name="gender" id="gender" class="form-control">
                                                    <option value="">Select Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                                <small class="form-text text-danger gender"></small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="nid">NID</label>
                                                <input type="text" name="nid" id="nid" class="form-control" placeholder="NID">
                                                
                                                <small class="form-text text-danger nid"></small>
                                            </div>
                        
                                            <div class="form-group col-md-6">
                                                <label for="nominee">Nominee</label>
                                                <input type="text" name="nominee" id="nominee" class="form-control" placeholder="Nominee">
                                                
                                                <small class="form-text text-danger education"></small>
                                            </div>
                            
                                            <div class="form-group col-md-6">
                                                <label for="nominee_relation">Nominee Relation</label>
                                                <input type="text" name="nominee_relation" id="nominee_relation" class="form-control" placeholder="Nominee Relation">
                                                
                                                <small class="form-text text-danger nominee_relation"></small>
                                            </div>
                        
                                            <div class="form-group col-md-6">
                                                <label for="profession">Profession</label>
                                                <input type="text" name="profession" id="profession" class="form-control" placeholder="Nominee">
                                                
                                                <small class="form-text text-danger profession"></small>
                                            </div>
    
                                            <div class="form-group col-md-6">
                                                <label for="education">Education</label>
                                                <input type="text" name="education" id="education" class="form-control" placeholder="Education">
                                                
                                                <small class="form-text text-danger education"></small>
                                            </div>
                        
                                            <div class="form-group col-md-6">
                                                <label for="facebook">Facebook</label>
                                                <input type="text" name="facebook" id="facebook" class="form-control" placeholder="Facebook">
                                                
                                                <small class="form-text text-danger facebook"></small>
                                            </div>
                        
                                            <div class="form-group col-md-6">
                                                <label for="present_address">Present Address</label>
                                                <input type="text" id='present_address' name='present_address' class="form-control" placeholder="Present address">
                                                <small class="form-text text-danger present_address"></small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="permanent_address">Permanent Address</label>
                                                <input type="text" id='permanent_address' name='permanent_address' class="form-control" placeholder="Permanent address">
                                                <small class="form-text text-danger permanent_address"></small>
                                            </div>
                                        </div>
                                        

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade show" id="bank" role="tabpanel" aria-labelledby="nav-bank">
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <div class="card p-0">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="bank_name">Bank Name</label>
                                            <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="Bank Name">
                                            
                                            <small class="form-text text-danger bank_name"></small>
                                        </div>
                    
                                        <div class="form-group">
                                            <label for="bank_account_name">Bank Account Name</label>
                                            <input type="text" name="bank_account_name" id="bank_account_name" class="form-control" placeholder="Bank account name">
                                            
                                            <small class="form-text text-danger bank_name"></small>
                                        </div>
                        
                                        <div class="form-group">
                                            <label for="bank_account_number">Bank Account Number</label>
                                            <input type="text" name="bank_account_number" id="bank_account_number" class="form-control" placeholder="Bank account number">
                                            
                                            <small class="form-text text-danger bank_account_number"></small>
                                        </div>
                        
                                        <div class="form-group">
                                            <label for="branch_name">Branch Name</label>
                                            <input type="text" name="branch_name" id="branch_name" class="form-control" placeholder="Branch name">
                                            
                                            <small class="form-text text-danger branch_name"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade show" id="mobile" role="tabpanel" aria-labelledby="nav-mobile">
                        <div class="row">
                            <div class="col-md-6 offset-md-3">
                                <div class="card p-0">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="bkash">Bkash</label>
                                            <input type="number" name="bkash" id="bkash" class="form-control" placeholder="Bkash">
                                            
                                            <small class="form-text text-danger bkash"></small>
                                        </div>
                    
                                        <div class="form-group">
                                            <label for="nagad">Nagad</label>
                                            <input type="number" name="nagad" id="nagad" class="form-control" placeholder="Nagad">
                                            
                                            <small class="form-text text-danger nagad"></small>
                                        </div>
                        
                                        <div class="form-group">
                                            <label for="rocket">Rocket</label>
                                            <input type="number" name="rocket" id="rocket" class="form-control" placeholder="Rocket">
                                            
                                            <small class="form-text text-danger rocket"></small>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <input type="submit" value="Submit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
   </div>
</div>

<script>
    $(document).ready(function () {
        $(document).on('submit', '#submit', function(e) {
            e.preventDefault();
            
            $('small.form-text').text('')
            $('.form-control').removeClass('is-invalid');

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
                    console.log(response);
                    
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
    });
</script>