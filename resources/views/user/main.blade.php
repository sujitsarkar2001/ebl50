<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/jpg" href="{{asset('/')}}uploads/setting/{{setting('favicon')}}"/>

    <title>{{config('app.name')}}</title>

    <link rel="stylesheet" href="{{asset('/')}}assets/frontend/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/frontend/css/style.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/frontend/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/frontend/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/frontend/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/frontend/css/icofont.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/frontend/css/slick.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/frontend/css/calendar.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/frontend/css/all.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/frontend/css/toast.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/frontend/css/sidebar.css">

    <style>
        #loading-image {
            position: fixed;
            z-index: 99999;
            text-align: center;
            background: white;
            width: 100%;
            height: 100vh;
        }
    </style>

    <script src="{{asset('/')}}assets/frontend/js/jquery.js"></script>
    <script src="{{asset('/')}}assets/frontend/js/bootstrap.min.js"></script>
    <script src="{{asset('/')}}assets/frontend/js/calendar.min.js"></script>
    <script src="{{asset('/')}}assets/frontend/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('/')}}assets/frontend/js/dataTables.responsive.min.js"></script>
    <script src="{{asset('/')}}assets/frontend/js/dataTables.rowReorder.min.js"></script>
    <script src="{{asset('/')}}assets/frontend/js/slick.js"></script>
    <script src="{{asset('/')}}assets/frontend/js/main.js"></script>
    <script src="{{asset('/')}}assets/frontend/js/toast.min.js"></script>
    <script src="{{asset('/')}}assets/frontend/js/sidebar.js"></script>

</head>
<body>
    <div id="loading-image" class="d-none">
        <img style="width: 120px;position: relative;top: 50%;" src="{{asset('/')}}assets/frontend/images/ajax-loader.gif">
    </div>

    <div class="main-area" id="main">

        <nav id="sidebar">
            <div class="close-btn text-right mr-2 mt-2" style="cursor: pointer;">
                <i class="fas fa-times" style="font-size:32px"></i>
            </div>
            <div class="pt-3">
                <div class="text-center mb-2">
                    {{-- <a href="#" class="img logo rounded-circle mb-5" style="background-image: url({{asset('uploads/member').'/'.auth()->user()->avatar}});"></a> --}}
                    <img src="{{asset('uploads/member').'/'.auth()->user()->avatar}}" alt="" srcset="">
                </div>

                <ul class="list-unstyled components mb-0">
                    <li><a href="{{route('join.referrer')}}" id="view-page">Joining</a></li>
                    <li><a href="{{route('level')}}" id="view-page">Level</a></li>
                    <li>
                        <a href="#transaction" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Transaction</a>
                        <ul class="collapse list-unstyled" id="transaction">
                            <li><a href="{{route('general-ledger')}}" id="view-page">General Ledger</a></li>
                            <li><a href="{{route('withdraw.create')}}" id="view-page">Withdraw</a></li>
                            <li><a href="{{route('withdraw-expense')}}" id="view-page">Withdraw History</a></li>
                            <li><a href="{{route('money.exchange')}}" id="view-page">Exchange Money</a></li>
                            <li><a href="{{route('exchange-expense')}}" id="view-page">Exchange History</a></li>
                            <li><a href="{{route('add.fund')}}" id="view-page">Add Fund</a></li>
                            <li><a href="{{route('fund.history')}}" id="view-page">Add Fund History</a></li>
                            <li><a href="{{route('send.shop.balance')}}" id="view-page">Transfer Shop Balance</a></li>
                            <li><a href="{{route('shop.balance.history')}}" id="view-page">Send/Receive Shop History</a></li>
                        </ul>
                    </li>
                    <li><a href="{{route('daily.work')}}" id="view-page">Work</a></li>
                    <li><a href="{{route('notice')}}" id="view-page">Notice</a></li>
                    <li><a href="{{route('connection.contact')}}" id="view-page">Contact</a></li>

                    <li>
                        <a href="#team" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">My Team</a>
                        <ul class="collapse list-unstyled" id="team">
                            <li><a href="{{route('team.tree.view')}}" id="view-page">Tree View</a></li>
                            <li><a href="{{route('team.list.view')}}" id="view-page">List View</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>

        <div class="header">
            <div class="container" style="display: flex;">
                <div class="bars">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="bell">
{{--                    <i class="far fa-bell"></i>--}}
{{--                    <img src="{{asset('uploads/member/'.auth()->user()->avatar)}}" width="50px">--}}
                    <div class="c">
                        <!-- The dropdown starts here... -->
                        <div class="dd">
                            <div class="dd-a">
                                <img src="{{asset('uploads/member/'.auth()->user()->avatar)}}" width="50px">
                            </div>
                            <input type="checkbox">
                            <div class="dd-c">
                                <ul>
                                    <li><a href="{{route('profile.index')}}" id="view-page">Profile</a></li>
                                    <li>
                                        <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{route('logout')}}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>

{{--                                    <li><a href="#"><span>Link</span></a></li>--}}
                                </ul>
                            </div>
                        </div>
                        <!-- ...and ends here. -->
                    </div>

                </div>
            </div>
        </div>

        <div id="main-content"></div>
    </div>

    <div style="padding: 20px;" class="clear-fix"></div>

    <div class="footer-menu">
        <div class="container">
            <ul>
                <li><a href="{{route('profile.index')}}" id="view-page"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="{{route('withdraw.index')}}" id="view-page"><i class="fas fa-wallet"></i> Wallet</a></li>
                <li><a href="{{route('home')}}" id="view-page"><img src="{{asset('/')}}assets/frontend/images/usp_mask.png" alt=""></a></li>
                <li><a href="{{route('connection.live.chat')}}" id="view-page"><i class="fas fa-comment-alt"></i> Inbox</a></li>
                <li><a href="{{route('notice')}}" id="view-page"><i class="fas fa-bell"></i> Notice</a></li>
            </ul>
        </div>
    </div>

    @include('user.script')

</body>
</html>
