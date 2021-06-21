<div class="ledger">
    <div class="container">
        <div class="card p-0">
            <div class="card-header">
                <h4 class="card-title">General Ledger</h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Income</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Shop</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        
                        <table>
                            <tr>
                                <th><a href="{{route('sponsor-income')}}" id="view-page">Sponsor Income</a></th>
                                <td><a href="{{route('sponsor-income')}}" id="view-page">{{$sponsor_income}}</a></td>
                            </tr>
                            <tr>
                                <th><a href="{{route('generation-income')}}" id="view-page">Generation Income</a></th>
                                <td><a href="{{route('generation-income')}}" id="view-page">{{$generation_income}}</a></td>
                            </tr>
                            <tr>
                                <th><a href="{{route('daily-income')}}" id="view-page">Daily Work Bonus</a></th>
                                <td><a href="{{route('daily-income')}}" id="view-page">{{$daily_income}}</a></td>
                            </tr>
                            <tr>
                                <th><a href="{{route('level-income')}}" id="view-page">Level Income</a></th>
                                <td><a href="{{route('level-income')}}"  id="view-page">{{$level_income}}</a></td>
                            </tr>
                            <tr class="ebx">
                                <th>Total</th>
                                <th>{{$sponsor_income+$generation_income+$daily_income+$level_income.'.00'}}</th>
                            </tr>
                        </table>
        
                        <table>
                            <tr class="ebx">
                                <th colspan="2">Expense</th>
                            </tr>
                            <tr>
                                <th><a href="{{route('withdraw-expense')}}" id="view-page">Withdraw</a></th>
                                <td><a href="{{route('withdraw-expense')}}" id="view-page">{{$withdraw_amount}}</a></td>
                            </tr>
                            <tr>
                                <th><a href="{{route('exchange-expense')}}" id="view-page">Exchange</a></th>
                                <td><a href="{{route('exchange-expense')}}" id="view-page">{{$money_exchange}}</a></td>
                            </tr>
                            <tr class="ebx">
                                <th>Total</th>
                                <th>{{$withdraw_amount+$money_exchange.'.00'}}</th>
                            </tr>
                        </table>
        
                        <table>
                            <tr class="ebx">
                                <th>Income Wallet</th>
                                <th>{{$income_balance}}</th>
                            </tr>
                        </table>
                    </div>
        
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <table>
                            <tr class="ebx">
                                <th colspan="2">Income</th>
                            </tr>
                            <tr>
                                <th><a href="{{route('exchange-expense')}}" id="view-page">Own Transfer In</a></th>
                                <td><a href="{{route('exchange-expense')}}" id="view-page">{{$money_exchange}}</a></td>
                            </tr>
                            <tr>
                                <th><a href="{{route('shop.company-transfer')}}" id="view-page">Company Transfer In</a></th>
                                <td><a href="{{route('shop.company-transfer')}}" id="view-page">{{$company_transfer_in}}</a></td>
                            </tr>
                            <tr>
                                <th><a href="{{route('shop.member-transfer')}}" id="view-page">Member Transfer In</a></th>
                                <td><a href="{{route('shop.member-transfer')}}" id="view-page">{{$member_transfer_in}}</a></td>
                            </tr>
                            <tr class="ebx">
                                <th>Total</th>
                                <th>{{$company_transfer_in+$member_transfer_in+$money_exchange}}</th>
                            </tr>
                        </table>
        
                        <table>
                            <tr class="ebx">
                                <th colspan="2">Expense</th>
                            </tr>
                            <tr>
                                <th><a href="{{route('shop.transfer')}}" id="view-page">Transfer</a></th>
                                <td><a href="{{route('shop.transfer')}}" id="view-page">{{$transfer_amount}}</a></td>
                            </tr>
                            <tr class="ebx">
                                <th>Total</th>
                                <th>{{$transfer_amount}}</th>
                            </tr>
                        </table>
        
                        <table>
                            <tr class="ebx">
                                <th>Income Wallet</th>
                                <th>{{$shop_balance}}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>