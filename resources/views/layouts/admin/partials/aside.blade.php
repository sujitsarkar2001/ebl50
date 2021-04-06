<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
        <img src="/uploads/setting/{{setting('logo')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8;float:none;min-height:40px;">
        {{-- <span class="brand-text font-weight-light">AdminLTE 3</span> --}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{Auth::user()->avatar != 'default.png' ? '/uploads/member/'.Auth::user()->avatar:'/default/user.jpg'}}" class="img-circle elevation-2" alt="User Image" style="width:50px;height:50px">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{Auth::user()->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            
                <li class="nav-item {{Request::is('admin') ? 'menu-is-opening menu-open':''}}">
                    <a href="{{route('admin.dashboard')}}" class="nav-link">
                      <i class="nav-icon fas fa-tachometer-alt"></i>
                      <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item {{Request::is('admin/staff*') ? 'menu-is-opening menu-open':''}}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Staff
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.staff.create')}}" class="nav-link {{Request::is('admin/staff/create') ? 'active':''}}">
                                <i class="fas fa-plus-circle nav-icon"></i>
                                <p>Add</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.staff.index')}}" class="nav-link {{Request::is('admin/staff') ? 'active':''}}">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{Request::is('admin/page*') ? 'menu-is-opening menu-open':''}}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-list-ul"></i>
                        <p>
                            Pages
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.page.create')}}" class="nav-link {{Request::is('admin/page/create') ? 'active':''}}">
                                <i class="fas fa-plus-circle nav-icon"></i>
                                <p>Add</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.page.index')}}" class="nav-link {{Request::is('admin/page') ? 'active':''}}">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{Request::is('admin/user*') ? 'menu-is-opening menu-open':''}}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Members
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.user.create')}}" class="nav-link {{Request::is('admin/user/create') ? 'active':''}}">
                                <i class="fas fa-plus-circle nav-icon"></i>
                                <p>Add</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.user.index')}}" class="nav-link {{Request::is('admin/user') ? 'active':''}}">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.user.new')}}" class="nav-link {{Request::is('admin/user/new') ? 'active':''}}">
                                <i class="fas fa-user-plus nav-icon"></i>
                                <p>New</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.user.blocked')}}" class="nav-link {{Request::is('admin/user/blocked') ? 'active':''}}">
                                <i class="fas fa-user-slash nav-icon"></i>
                                <p>Blocked</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{Request::is('admin/video*') ? 'menu-is-opening menu-open':''}}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fab fa-youtube"></i>
                        <p>
                            Videos
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.video.create')}}" class="nav-link {{Request::is('admin/video/create') ? 'active':''}}">
                                <i class="fas fa-plus-circle nav-icon"></i>
                                <p>Add</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.video.index')}}" class="nav-link {{Request::is('admin/video') ? 'active':''}}">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item {{Request::is('admin/withdraw*') ? 'menu-is-opening menu-open':''}}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>
                            Transaction
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.withdraw.index')}}" class="nav-link {{Request::is('admin/withdraw/history') ? 'active':''}}">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>Withdraw History</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.withdraw.income.history')}}" class="nav-link {{Request::is('admin/withdraw/income/history') ? 'active':''}}">
                                <i class="fas fa-history nav-icon"></i>
                                <p>Income History</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.withdraw.money.exchange')}}" class="nav-link {{Request::is('admin/withdraw/money/exchange') ? 'active':''}}">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>Money Exchange History</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.withdraw.shop.balance.create')}}" class="nav-link {{Request::is('admin/withdraw/shop/balance/create') ? 'active':''}}">
                                <i class="fas fa-money-check-alt nav-icon"></i>
                                <p>Give Shop Balance</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.withdraw.shop.balance')}}" class="nav-link {{Request::is('admin/withdraw/shop/balance') ? 'active':''}}">
                                <i class="fas fa-history nav-icon"></i>
                                <p>Give Shop Balance History</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{Request::is('admin/setting') ? 'menu-is-opening menu-open':''}}">
                    <a href="{{route('admin.setting')}}" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>
                            Settings
                        </p>
                    </a>
                </li>

                {{-- <li class="nav-item {{Request::is('admin/team*') ? 'menu-is-opening menu-open':''}}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            My Team
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.team.tree.view')}}" class="nav-link {{Request::is('admin/team/tree-view*') ? 'active':''}}">
                                <i class="fas fa-project-diagram nav-icon"></i>
                                <p>Tree View</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.team.list.view')}}" class="nav-link {{Request::is('admin/team/list-view') ? 'active':''}}">
                                <i class="fas fa-list-ol nav-icon"></i>
                                <p>List View</p>
                            </a>
                        </li>
                    </ul>
                </li> --}}

                <li class="nav-item {{Request::is('admin/connection*') ? 'menu-is-opening menu-open':''}}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>
                            Connection
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.connection.live.chat')}}" class="nav-link {{Request::is('admin/connection/live-chat') ? 'active':''}}">
                                <i class="fas fa-headset nav-icon"></i>
                                <p>Live Chat</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.connection.contact')}}" class="nav-link {{Request::is('admin/connection/contact') ? 'active':''}}">
                                <i class="fas fa-address-book nav-icon"></i>
                                <p>Contact</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{Request::is('admin/profile*') ? 'menu-is-opening menu-open':''}}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>
                            Profile
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.profile.index')}}" class="nav-link {{Request::is('admin/profile/show') ? 'active':''}}">
                                <i class="fas fa-user nav-icon"></i>
                                <p>My Profile</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{route('admin.profile.change.password')}}" class="nav-link {{Request::is('admin/profile/change-password') ? 'active':''}}">
                                <i class="fas fa-key nav-icon"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>Logout</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>