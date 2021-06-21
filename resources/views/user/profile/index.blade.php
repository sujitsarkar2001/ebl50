<div class="History">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card p-0">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title">Profile Information</h4>
                        <div>
                            <a href="{{route('profile.change.password')}}" class="btn btn-primary" id="view-page">Change Password</a>
                        </div>
                    </div>
                    <img src="{{$member->avatar != '/default/default.png' ? '/uploads/member/'.Auth::user()->avatar:'/default/user.jpg'}}" class="img-fluid w-100" alt="User Image">
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <tbody>
                                <tr>
                                    <th colspan="4"><h4>Basic Information:</h4></th>
                                </tr>
                                <tr>
                                    <th>Username:</th>
                                    <td>{{$member->username}}</td>
                                    <th>Your Sponsor ID:</th>
                                    <td>{{$member->referer_id}}</td>
                                </tr>
                                <tr>
                                    <th>Name:</th>
                                    <td>{{$member->name}}</td>
                                    <th>Total Refers:</th>
                                    <td>{{$member->referrals->count()}}</td>
                                </tr>

                                @php
                                    $left   = $member->left;
                                    $middle = $member->middle;
                                    $right  = $member->right;
                                @endphp
                                <tr>
                                    <th>Total Team Member:</th>
                                    <td>{{$left+$middle+$right}}</td>
                                    <th>Left Side Team Member:</th>
                                    <td>{{$left}}</td>
                                </tr>
                                <tr>
                                    <th>Middle Side Member:</th>
                                    <td>{{$middle}}</td>
                                    <th>Right Side Member:</th>
                                    <td>{{$right}}</td>
                                </tr>
                                <tr>
                                    <th>Rank:</th>
                                    <td>{{$member->level}}</td>
                                    <th>Gender:</th>
                                    <td>{{$member->userInfo->gender}}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{$member->email}}</td>
                                    <th>Date of Birth:</th>
                                    <td>{{$member->userInfo->d_o_b}}</td>
                                </tr>
                                <tr>
                                    <th>Is Approved:</th>
                                    <td>
                                        @if ($member->is_approved)
                                            <span class="badge badge-success">Approved</span>
                                        @else
                                            <span class="badge badge-danger">Pending</span>
                                        @endif
                                    </td>
                                    <th>Gender:</th>
                                    <td>{{$member->userInfo->gender}}</td>
                                </tr>

                                <tr>
                                    <th colspan="4"><h4>Income History:</h4></th>
                                </tr>
                                <tr>
                                    <th>Income Balance:</th>
                                    <td>{{$member->incomeBalance->amount}}</td>
                                    <th>Shop Balance:</th>
                                    <td>{{$member->shopBalance->amount}}</td>
                                </tr>
                                <tr>
                                    <th>Share Income:</th>
                                    <td>{{$member->shareIncomes->sum('amount') ?? '0'}}</td>
                                    <th>Sponsor Income:</th>
                                    <td>{{$member->sponsorIncomes->sum('amount') ?? '0'}}</td>
                                </tr>
                                <tr>
                                    <th>Generation Income:</th>
                                    <td>{{$member->generationIncomes->sum('amount') ?? '0'}}</td>
                                    <th>Level Income:</th>
                                    <td>{{$member->levelIncomes->sum('amount') ?? '0'}}</td>
                                </tr>
                                <tr>
                                    <th>Daily Income:</th>
                                    <td>{{$member->videos->sum('amount') ?? '0'}}</td>
                                    <th>Level Income:</th>
                                    <td>{{$member->levelIncomes->sum('amount') ?? '0'}}</td>
                                </tr>

                                <tr>
                                    <th colspan="4"><h4>Your Sponsorer information:</h4></th>
                                </tr>
                                <tr>
                                    <th>Name:</th>
                                    <td>{{$member->sponsor->name ?? ''}}</td>
                                    <th>Username:</th>
                                    <td>{{$member->sponsor->username ?? ''}}</td>

                                </tr>
                                <tr>
                                    <th>Refer ID:</th>
                                    <td>{{$member->sponsor->referer_id ?? ''}}</td>
                                </tr>

                                <tr>
                                    <th colspan="4"><h4>Transaction History:</h4></th>
                                </tr>
                                <tr>
                                    <th>Withdraw Paid:</th>
                                    <td>{{$member->withdraws->where('status', true)->sum('amount') ?? '0'}}</td>
                                    <th>Withdraw Pending:</th>
                                    <td>{{$member->withdraws->where('status', false)->sum('amount') ?? '0'}}</td>
                                </tr>
                                <tr>
                                    <th>Exchange Money:</th>
                                    <td>{{$member->money_exchanges->where('status', true)->sum('amount') ?? '0'}}</td>
                                    <th>Receive Shop Balance:</th>
                                    <td>{{$member->parentSendShopBalances->sum('amount') ?? '0'}}</td>
                                </tr>
                                <tr>
                                    <th>Send Shop Balance:</th>
                                    <td>{{$member->sendShopBalances->sum('amount') ?? '0'}}</td>
                                </tr>

                                <tr>
                                    <th colspan="4"><h4>Contact information:</h4></th>
                                </tr>
                                <tr>
                                    <th>NID:</th>
                                    <td>{{$member->userInfo->nid}}</td>
                                    <th>Phone:</th>
                                    <td>{{$member->phone}}</td>
                                </tr>
                                <tr>
                                    <th>Present Address:</th>
                                    <td colspan="3">{{$member->userInfo->present_address}}</td>

                                </tr>
                                <tr>
                                    <th>Permanent Address:</th>
                                    <td colspan="3">{{$member->userInfo->present_address}}</td>
                                </tr>
                                <tr>
                                    <th>Nominee:</th>
                                    <td>{{$member->userInfo->nominee}}</td>
                                    <th>Nominee Relation:</th>
                                    <td>{{$member->userInfo->nominee_relation}}</td>
                                </tr>
                                <tr>
                                    <th>Profession:</th>
                                    <td>{{$member->userInfo->profession}}</td>
                                    <th>Education:</th>
                                    <td>{{$member->userInfo->education}}</td>
                                </tr>
                                <tr>
                                    <th>Facebook:</th>
                                    <td>{{$member->userInfo->facebook}}</td>
                                </tr>

                                <tr>
                                    <th colspan="4"><h4>Bank information:</h4></th>
                                </tr>
                                <tr>
                                    <th>Bank Name:</th>
                                    <td>{{$member->userInfo->bank_name}}</td>
                                    <th>Bank Account Name:</th>
                                    <td>{{$member->userInfo->bank_account_name}}</td>
                                </tr>
                                <tr>
                                    <th>Bank Account Number:</th>
                                    <td>{{$member->userInfo->bank_account_number}}</td>
                                    <th>Bank Branch:</th>
                                    <td>{{$member->userInfo->branch_name}}</td>
                                </tr>
                                <tr>
                                    <th colspan="2"><h4>Mobile Bank information:</h4></th>
                                </tr>
                                <tr>
                                    <th>Bkash:</th>
                                    <td>{{$member->userInfo->bkash}}</td>
                                    <th>Nagad:</th>
                                    <td>{{$member->userInfo->nagad}}</td>
                                </tr>
                                <tr>
                                    <th>Rocket:</th>
                                    <td>{{$member->userInfo->rocket}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('profile.update')}}" class="mt-1 btn btn-primary" id="view-page">
                            <i class="fas fa-arrow-circle-up"></i>
                            Update
                        </a>
                    </div>
                </div>
            </div>
        </div>
   </div>
</div>
