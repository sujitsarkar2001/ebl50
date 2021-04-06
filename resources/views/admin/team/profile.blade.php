@extends('layouts.user.app')

@section('title', 'Team Member Profile')

@push('css')
    <style>
        .contact-title {
            display: inline-block;
            padding-bottom: 9px;
            width: 170px;
            font-size: 14px;
            color: #868e96;
        }
    </style>
@endpush

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>My Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Team Member Profile</li>
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
                    <h3 class="card-title">Team Member Profile</h3>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h3 class="card-title">Team Member Information</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="user-profile">
                                <div class="row">
                
                                    <div class="col-lg-12">
                
                                        <h4 class="card-title">Basic information</h4>
                                        <br>
                                        <div class="user-photo m-b-30">
                                            <img src="{{$user->avatar != 'default.png' ? '/uploads/member/'.Auth::user()->avatar:'/default/user.jpg'}}" class="img-fluid w-100" alt="User Image"> 
                                                
                                        </div>
                                        <div class="mb-1">
                                            <span class="contact-title">Username:</span>
                                            <span>{{$user->username}}</span>
                                        </div>
                                        <div class="mb-1">
                                            <span class="contact-title">Your Sponsor ID:</span>
                                            <span>{{$user->referer_id}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Name:</span>
                                            <span>{{$user->name}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Total Refers:</span>
                                            <span>{{$user->referrals->count()}}</span>
                                        </div>
                                        
                                        <div class="">
                                            <span class="contact-title">Total Team Member:</span>
                                            {{-- This Function Define App\Helpers\TeamCountHelper.php --}}
                                            <span>{{totalTeamMemberCount($user)}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Rank:</span>
                                            
                                            <span>
                                                {{-- This Function Define App\Helpers\LevelHelper.php --}}

                                                {{level($user)}}
                                            </span>
                                        </div>

                                        @isset($user->userInfo)
                                            <div class="birthday-content">
                                                <span class="contact-title">Date of Birth:</span>
                                                <span>{{$user->userInfo->d_o_b}}</span>
                                            </div>
                                            <div class="">
                                                <span class="contact-title">Gender:</span>
                                                <span>{{$user->userInfo->gender}}</span>
                                            </div>
                                        @endisset
                                        
                                        <div class="">
                                            <span class="contact-title">Email:</span>
                                            <span>{{$user->email}}</span>
                                        </div>

                                        <div class="birthday-content">
                                            <span class="contact-title">Date of Birth:</span>
                                            <span>{{$user->userInfo->d_o_b}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Gender:</span>
                                            <span>{{$user->userInfo->gender}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Is Approved:</span>
                                            @if ($user->is_approved)
                                                <span class="badge badge-success">Approved</span>
                                            @else
                                                <span class="badge badge-danger">Pending</span>
                                            @endif
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Status:</span>
                                            @if ($user->status)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Disable</span>
                                            @endif
                                        </div>
                
                                        <br>
                                        <br>
                                        <h4 >Contact information</h4>
                                        <hr>
                                        <div class="">
                                            <span class="contact-title">NID:</span>
                                            <span>{{$user->userInfo->nid}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Phone:</span>
                                            <span>{{$user->phone}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Present Address:</span>
                                            <span>{{$user->userInfo->present_address}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Permanent Address:</span>
                                            <span>{{$user->userInfo->permanent_address}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Email:</span>
                                            <span>{{$user->email}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Nominee:</span>
                                            <span>{{$user->userInfo->nominee}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Nominee Relation:</span>
                                            <span>{{$user->userInfo->nominee_relation}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Profession:</span>
                                            <span>{{$user->userInfo->profession}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Education:</span>
                                            <span>{{$user->userInfo->education}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Facebook:</span>
                                            <span>{{$user->userInfo->facebook}}</span>
                                        </div>
                                        <br>
                                        <br>
                                        <h4>Bank Information</h4>
                                        <hr>
                
                                        <div class="">
                                            <span class="contact-title">Bank Name:</span>
                                            <span>{{$user->userInfo->bank_name}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Bank Account Name:</span>
                                            <span>{{$user->userInfo->bank_account_name}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Bank Account Number:</span>
                                            <span>{{$user->userInfo->bank_account_number}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Bank Branch:</span>
                                            <span>{{$user->userInfo->branch_name}}</span>
                                        </div>
                                        <br>
                                        <br>
                                        <h4>Mobile Bank Information</h4>
                                        <hr>
                                        <div class="">
                                            <span class="contact-title">Bkash:</span>
                                            <span>{{$user->userInfo->bkash}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Nagad:</span>
                                            <span>{{$user->userInfo->nagad}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Rocket:</span>
                                            <span>{{$user->userInfo->rocket}}</span>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

@endsection
