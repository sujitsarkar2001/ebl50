@extends('layouts.user.app')

@section('title', 'User Information')

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
                    <li class="breadcrumb-item active">My Profile</li>
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
                    <h3 class="card-title">My Profile</h3>
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
                                    <h3 class="card-title">Your Information</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="user-profile">
                                <div class="row">
                
                                    <div class="col-lg-12">
                
                                        <h4>Basic information</h4>
                                        <br>
                                        <div class="user-photo m-b-30">
                                            <img src="{{Auth::user()->avatar != 'default.png' ? '/uploads/member/'.Auth::user()->avatar:'/default/user.jpg'}}" class="img-fluid w-100" alt="User Image"> 
                                                
                                        </div>
                                        <div class="mb-1">
                                            <span class="contact-title">Username:</span>
                                            <span>{{Auth::user()->username}}</span>
                                        </div>
                                        <div class="mb-1">
                                            <span class="contact-title">Your Sponsor ID:</span>
                                            <span>{{Auth::user()->referer_id}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Name:</span>
                                            <span>{{Auth::user()->name}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Total Refers:</span>
                                            <span>{{Auth::user()->referrals->count()}}</span>
                                        </div>
                                        
                                        <div class="">
                                            <span class="contact-title">Total Team Member:</span>
                                            {{-- This Function Define App\Helpers\TeamCountHelper.php --}}
                                            <span>{{totalTeamMemberCount(Auth::user())}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Left Side Team Member:</span>
                                            {{-- This Function Define App\Helpers\LevelHelper.php --}}
                                            <span>{{Auth::user()->countLeft()}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Middle Side Team Member:</span>
                                            {{-- This Function Define App\Helpers\LevelHelper.php --}}
                                            <span>{{Auth::user()->countMiddle()}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Right Side Team Member:</span>
                                            {{-- This Function Define App\Helpers\LevelHelper.php --}}
                                            <span>{{Auth::user()->countRight()}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Rank:</span>
                                            
                                            <span>
                                                {{-- This Function Define App\Helpers\LevelHelper.php --}}

                                                {{Auth::user()->level}}
                                            </span>
                                        </div>

                                        <div class="">
                                            <span class="contact-title">Gender:</span>
                                            <span>{{Auth::user()->userInfo->gender}}</span>
                                        </div>
                                        
                                        <div class="">
                                            <span class="contact-title">Email:</span>
                                            <span>{{Auth::user()->email}}</span>
                                        </div>

                                        <div class="birthday-content">
                                            <span class="contact-title">Date of Birth:</span>
                                            <span>{{Auth::user()->userInfo->d_o_b}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Gender:</span>
                                            <span>{{Auth::user()->userInfo->gender}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Is Approved:</span>
                                            @if (Auth::user()->is_approved)
                                                <span class="badge badge-success">Approved</span>
                                            @else
                                                <span class="badge badge-danger">Pending</span>
                                            @endif
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Status:</span>
                                            @if (Auth::user()->status)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Disable</span>
                                            @endif
                                        </div>
                                        
                                        <br>
                                        <br>
                                        <h4 >Income History</h4>
                                        <hr>
                                        <div class="">
                                            <span class="contact-title">Income Balance:</span>
                                            <span>{{Auth::user()->incomeBalance->amount}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Shop Balance:</span>
                                            <span>{{Auth::user()->shopBalance->amount}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Send Shop Balance:</span>
                                            <span>{{Auth::user()->parentSendShopBalances->sum('amount') ?? '0'}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Receive Shop Balance:</span>
                                            <span>{{Auth::user()->sendShopBalances->sum('amount') ?? '0'}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Share Income :</span>
                                            <span>{{Auth::user()->shareIncomes->sum('amount') ?? '0'}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Sponsor Income:</span>
                                            <span>{{Auth::user()->sponsorIncomes->sum('amount') ?? '0'}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Generation Income:</span>
                                            <span>{{Auth::user()->generationIncomes->sum('amount') ?? '0'}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Level Income:</span>
                                            <span>{{Auth::user()->levelIncomes->sum('amount') ?? '0'}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Daily Income:</span>
                                            <span>{{Auth::user()->videos->sum('rate') ?? '0'}}</span>
                                        </div>
                                        <br>
                                        <br>

                                        <h4>Your Sponsorer information</h4>
                                        <br>                        
                                        <div class="mb-1">
                                            <span class="contact-title">Name:</span>
                                            <span>{{Auth::user()->sponsor->name ?? ''}}</span>
                                        </div>                        
                                        <div class="mb-1">
                                            <span class="contact-title">Username:</span>
                                            <span>{{Auth::user()->sponsor->username ?? ''}}</span>
                                        </div>
                                        <div class="mb-1">
                                            <span class="contact-title">Refer ID:</span>
                                            <span>{{Auth::user()->sponsor->referer_id ?? ''}}</span>
                                        </div>

                                        <h4 >Transaction History</h4>
                                        <hr>
                                        <div class="">
                                            <span class="contact-title"> Withdraw Paid Money:</span>
                                            <span>{{Auth::user()->withdraws->where('status', true)->sum('amount') ?? '0'}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title text-danger">Withdraw Pending Money:</span>
                                            <span class="text-danger">{{Auth::user()->withdraws->where('status', false)->sum('amount') ?? '0'}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Exchange Paid Money:</span>
                                            <span>{{Auth::user()->money_exchanges->where('status', true)->sum('amount') ?? '0'}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title text-danger">Exchange Pending Money:</span>
                                            <span class="text-danger">{{Auth::user()->money_exchanges->where('status', false)->sum('amount') ?? '0'}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Receive Shop Balance:</span>
                                            <span>{{Auth::user()->sendShopBalances->sum('amount') ?? '0'}}</span>
                                        </div>
                                        <br>
                                        <br>

                                        <h4 >Contact information</h4>
                                        <hr>
                                        <div class="">
                                            <span class="contact-title">NID:</span>
                                            <span>{{Auth::user()->userInfo->nid}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Phone:</span>
                                            <span>{{Auth::user()->phone}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Present Address:</span>
                                            <span>{{Auth::user()->userInfo->present_address}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Permanent Address:</span>
                                            <span>{{Auth::user()->userInfo->permanent_address}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Email:</span>
                                            <span>{{Auth::user()->email}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Nominee:</span>
                                            <span>{{Auth::user()->userInfo->nominee}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Nominee Relation:</span>
                                            <span>{{Auth::user()->userInfo->nominee_relation}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Profession:</span>
                                            <span>{{Auth::user()->userInfo->profession}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Education:</span>
                                            <span>{{Auth::user()->userInfo->education}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Facebook:</span>
                                            <span>{{Auth::user()->userInfo->facebook}}</span>
                                        </div>
                                        <br>
                                        <br>
                                        <h4>Bank Information</h4>
                                        <hr>
                
                                        <div class="">
                                            <span class="contact-title">Bank Name:</span>
                                            <span>{{Auth::user()->userInfo->bank_name}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Bank Account Name:</span>
                                            <span>{{Auth::user()->userInfo->bank_account_name}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Bank Account Number:</span>
                                            <span>{{Auth::user()->userInfo->bank_account_number}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Bank Branch:</span>
                                            <span>{{Auth::user()->userInfo->branch_name}}</span>
                                        </div>
                                        <br>
                                        <br>
                                        <h4>Mobile Bank Information</h4>
                                        <hr>
                                        <div class="">
                                            <span class="contact-title">Bkash:</span>
                                            <span>{{Auth::user()->userInfo->bkash}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Nagad:</span>
                                            <span>{{Auth::user()->userInfo->nagad}}</span>
                                        </div>
                                        <div class="">
                                            <span class="contact-title">Rocket:</span>
                                            <span>{{Auth::user()->userInfo->rocket}}</span>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group">
                                <a href="{{route('profile.update')}}" class="mt-1 btn btn-primary">
                                    
                                    <i class="fas fa-arrow-circle-up"></i>
                                    Update
                                </a>
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
