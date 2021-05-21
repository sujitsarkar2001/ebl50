@extends('layouts.admin.app')

@section('title')
    @isset($user)
        Edit Member 
    @else 
        Add Member
    @endisset
@endsection


@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    
@endpush

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    @isset($user)
                        Edit Member 
                    @else 
                        Add Member
                    @endisset
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">
                        @isset($user)
                            Edit Member 
                        @else 
                            Add Member
                        @endisset
                    </li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="card-title">
                        @isset($user)
                            Edit Member Details
                        @else 
                            Create a New Member
                        @endisset
                    </h3>
                </div>
                <div class="col-sm-6 text-right">
                    @isset($user)
                        <a href="{{route('admin.user.show', $user->id)}}" class="btn btn-info">
                            <i class="fas fa-eye"></i>
                            Show
                        </a>
                    @endisset
                    <a href="{{route('admin.user.index')}}" class="btn btn-danger">
                        
                        <i class="fas fa-long-arrow-alt-left"></i>
                        Back to List
                    </a>
                </div>
            </div>
        </div>
        <form action="{{ isset($user) ? route('admin.user.update', $user->id) : route('admin.user.store') }}" method="POST">
            @csrf
            @isset($user)
                @method('PUT')
            @endisset
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <h4 class="card-title">Basic Information</h4>
                            </div>
                            <div class="card-body">
                                
                                <div class="form-group">
                                    <label for="sponsor_id">Sponsor ID (optional)</label>
                                    <input type="number" name="sponsor_id" id="sponsor_id" class="form-control @error('sponsor_id') is-invalid @enderror" value="{{$user->sponsor->referer_id ?? old('sponsor_id')}}" placeholder="Enter Sponsor ID" @isset($user) readonly @endisset>
                                    @error('sponsor_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="placement_id">Placement ID (optional)</label>
                                    <input type="number" name="placement_id" id="placement_id" class="form-control @error('placement_id') is-invalid @enderror" value="{{$user->sponsor->placement_id ?? old('placement_id')}}" placeholder="Enter Sponsor ID" @isset($user) readonly @endisset>
                                    @error('placement_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{$user->name ?? old('name')}}" placeholder="Name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{$user->username ?? old('username')}}" placeholder="Username">
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{$user->email ?? old('email')}}" placeholder="example@gmail.com">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="post_code">Post Code</label>
                                    <input type="number" name="post_code" id="post_code" class="form-control @error('post_code') is-invalid @enderror" maxlength="25" value="{{$user->userInfo->post_code ?? old('post_code')}}" placeholder="Post Code">
                                    @error('post_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" maxlength="25" value="{{$user->phone ?? old('phone')}}" placeholder="Phone Number">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" id='country' name='country' class="form-control @error('country') is-invalid @enderror" value="{{$user->userInfo->country ?? old('country')}}" placeholder="Country">
                                    @error('country')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="direction">Side</label>
                                    <select name="direction" id="direction" class="form-control @error('direction') is-invalid @enderror" @isset($user) disabled @endisset>
                                        <option value="">Select Side</option>
                                        <option value="1" @isset($user) {{$user->direction == 1 ? 'selected':''}} @endisset>Left Side</option>
                                        <option value="2" @isset($user) {{$user->direction == 2 ? 'selected':''}} @endisset>Middle Side</option>
                                        <option value="3" @isset($user) {{$user->direction == 3 ? 'selected':''}} @endisset>Right Side</option>
                                    </select>
                                    
                                    @error('direction')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="register_package">Register Package</label>
                                    <select name="register_package" id="register_package" class="form-control @error('register_package') is-invalid @enderror">
                                        <option value="">Select Package</option>
                                        <option value="{{setting('single_package')}}" @isset($user) {{$user->register_package == setting('single_package') ? 'selected':''}} @endisset>Single Package ({{setting('single_package')}})</option>
                                        <option value="{{setting('share_package')}}" @isset($user) {{$user->register_package == setting('share_package') ? 'selected':''}} @endisset>Share Package ({{setting('share_package')}})</option>
                                    </select>
                                    
                                    @error('register_package')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                
                                @isset($user)

                                @else
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                                            
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="password-confirm">Retype Password</label>
                                            <input type="password" name="password_confirmation" id="password-confirm" class="form-control" placeholder="Retype Password">
                                            
                                        </div>
                                    </div>
                                @endisset
                
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Contact Information (All field is optional)</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="d_o_b">Date of Birth</label>
                                    <input type="date" name="d_o_b" id="d_o_b" class="form-control @error('d_o_b') is-invalid @enderror" value="{{$user->userInfo->d_o_b ?? old('d_o_b')}}">
                                    
                                    @error('d_o_b')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="male" name="gender" @isset($user) {{$user->userInfo->gender == 'Male' ? 'checked':''}} @endisset value="Male" class="custom-control-input">
                                                <label for="male" class="custom-control-label">Male</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="female" name="gender" @isset($user) {{$user->userInfo->gender == 'Female' ? 'checked':''}} @endisset value="Female" class="custom-control-input">
                                                <label for="female" class="custom-control-label">Female</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="custom" name="gender" @isset($user) {{$user->userInfo->gender == 'Custom' ? 'checked':''}} @endisset value="Custom" class="custom-control-input">
                                                <label for="custom" class="custom-control-label">Custom</label>
                                            </div>
                                        </div>
                                    </div>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nid">NID</label>
                                    <input type="text" name="nid" id="nid" class="form-control @error('nid') is-invalid @enderror" placeholder="NID" value="{{$user->userInfo->nid ?? old('nid')}}">
                                    
                                    @error('nid')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
            
                                <div class="form-group">
                                    <label for="nominee">Nominee</label>
                                    <input type="text" name="nominee" id="nominee" class="form-control @error('nominee') is-invalid @enderror" placeholder="Nominee" value="{{$user->userInfo->nominee ?? old('nominee')}}">
                                    
                                    @error('nominee')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                
                                <div class="form-group">
                                    <label for="nominee_relation">Nominee Relation</label>
                                    <input type="text" name="nominee_relation" id="nominee_relation" class="form-control @error('nominee_relation') is-invalid @enderror" placeholder="Nominee Relation" value="{{$user->userInfo->nominee_relation ?? old('nominee_relation')}}">
                                    
                                    @error('nominee_relation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
            
                                <div class="form-group">
                                    <label for="profession">Profession</label>
                                    <input type="text" name="profession" id="profession" class="form-control @error('profession') is-invalid @enderror" placeholder="Nominee" value="{{$user->userInfo->profession ?? old('profession')}}">
                                    
                                    @error('profession')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="education">Education</label>
                                    <input type="text" name="education" id="education" class="form-control @error('education') is-invalid @enderror" placeholder="Education" value="{{$user->userInfo->education ?? old('education')}}">
                                    
                                    @error('education')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
            
                                <div class="form-group">
                                    <label for="facebook">Facebook</label>
                                    <input type="text" name="facebook" id="facebook" class="form-control @error('facebook') is-invalid @enderror" placeholder="Facebook" value="{{$user->userInfo->facebook ?? old('facebook')}}">
                                    
                                    @error('facebook')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
            
                                <div class="form-group">
                                    <label for="present_address">Present Address</label>
                                    <input type="text" id='present_address' name='present_address' class="form-control @error('present_address') is-invalid @enderror" placeholder="Present address" value="{{$user->userInfo->present_address ?? old('present_address')}}">
                                    @error('present_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="permanent_address">Permanent Address</label>
                                    <input type="text" id='permanent_address' name='permanent_address' class="form-control @error('permanent_address') is-invalid @enderror" placeholder="Permanent address" value="{{$user->userInfo->permanent_address ?? old('permanent_address')}}">
                                    @error('permanent_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Bank Information(All field is optional)</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="bank_name">Bank Name</label>
                                    <input type="text" name="bank_name" id="bank_name" class="form-control @error('bank_name') is-invalid @enderror" placeholder="Bank Name" value="{{$user->userInfo->bank_name ?? old('bank_name')}}">
                                    
                                    @error('bank_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
            
                                <div class="form-group">
                                    <label for="bank_account_name">Bank Account Name</label>
                                    <input type="text" name="bank_account_name" id="bank_account_name" class="form-control @error('bank_account_name') is-invalid @enderror" placeholder="Bank account name" value="{{$user->userInfo->bank_account_name ?? old('bank_account_name')}}">
                                    
                                    @error('bank_account_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                
                                <div class="form-group">
                                    <label for="bank_account_number">Bank Account Number</label>
                                    <input type="text" name="bank_account_number" id="bank_account_number" class="form-control @error('bank_account_number') is-invalid @enderror" placeholder="Bank account number" value="{{$user->userInfo->bank_account_number ?? old('bank_account_number')}}">
                                    
                                    @error('bank_account_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                
                                <div class="form-group">
                                    <label for="branch_name">Branch Name</label>
                                    <input type="text" name="branch_name" id="branch_name" class="form-control @error('branch_name') is-invalid @enderror" placeholder="Branch name" value="{{$user->userInfo->branch_name ?? old('branch_name')}}">
                                    
                                    @error('branch_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Bank Information (All field is optional)</h3>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="bkash">Bkash</label>
                                    <input type="number" name="bkash" id="bkash" class="form-control @error('bkash') is-invalid @enderror" placeholder="Bkash" value="{{$user->userInfo->bkash ?? old('bkash')}}">
                                    
                                    @error('bkash')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
            
                                <div class="form-group">
                                    <label for="nagad">Nagad</label>
                                    <input type="number" name="nagad" id="nagad" class="form-control @error('nagad') is-invalid @enderror" placeholder="Nagad" value="{{$user->userInfo->nagad ?? old('nagad')}}">
                                    
                                    @error('nagad')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                
                                <div class="form-group">
                                    <label for="rocket">Rocket</label>
                                    <input type="number" name="rocket" id="rocket" class="form-control @error('rocket') is-invalid @enderror" placeholder="Rocket" value="{{$user->userInfo->rocket ?? old('rocket')}}">
                                    
                                    @error('rocket')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
            <div class="card-footer">
                <div class="form-group">
                    <button class="mt-1 btn btn-primary">
                        @isset($user)
                            <i class="fas fa-arrow-circle-up"></i>
                            Update
                        @else
                            <i class="fas fa-plus-circle"></i>
                            Submit
                        @endisset
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

@endsection

@push('js')
    <!-- Select2 -->
    <script src="/assets/plugins/select2/js/select2.full.min.js"></script>
    <script>
        $(function() {
            $('.select2').select2();
        })
    </script>
@endpush