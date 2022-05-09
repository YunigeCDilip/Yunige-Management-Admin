<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">

        <li class="dropdown notification-list">
            <!-- <a class="nav-link dropdown-toggle  waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="fe-bell noti-icon"></i>
                <span class="badge badge-danger rounded-circle noti-icon-badge">5</span>
            </a> -->
            <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                <!-- item-->
                <div class="dropdown-item noti-title">
                    <h5 class="m-0">
                        <span class="float-right">
                            <a href="" class="text-dark">
                                <small>Clear All</small>
                            </a>
                        </span>Notification
                    </h5>
                </div>

                <div class="slimscroll noti-scroll">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item active">
                        <div class="notify-icon">
                            <img src="{{asset('admin/images/yunige_avatar.png')}}" class="img-fluid rounded-circle" alt="" /> </div>
                        <p class="notify-details">Cristina Pride</p>
                        <p class="text-muted mb-0 user-msg">
                            <small>Hi, How are you? What about our next meeting</small>
                        </p>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-primary">
                            <i class="mdi mdi-comment-account-outline"></i>
                        </div>
                        <p class="notify-details">Caleb Flakelar commented on Admin
                            <small class="text-muted">1 min ago</small>
                        </p>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon">
                            <img src="" class="img-fluid rounded-circle" alt="" /> </div>
                        <p class="notify-details">Karen Robinson</p>
                        <p class="text-muted mb-0 user-msg">
                            <small>Wow ! this admin looks good and awesome design</small>
                        </p>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-warning">
                            <i class="mdi mdi-account-plus"></i>
                        </div>
                        <p class="notify-details">New user registered.
                            <small class="text-muted">5 hours ago</small>
                        </p>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-info">
                            <i class="mdi mdi-comment-account-outline"></i>
                        </div>
                        <p class="notify-details">Caleb Flakelar commented on Admin
                            <small class="text-muted">4 days ago</small>
                        </p>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-secondary">
                            <i class="mdi mdi-heart"></i>
                        </div>
                        <p class="notify-details">Carlos Crouch liked
                            <b>Admin</b>
                            <small class="text-muted">13 days ago</small>
                        </p>
                    </a>
                </div>

                <!-- All-->
                <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                    View all
                    <i class="fi-arrow-right"></i>
                </a>

            </div>
        </li>

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="{{asset('admin/images/yunige_avatar.png')}}" alt="user-image" class="rounded-circle">
                <span class="pro-user-name ml-1">
                    {{auth()->user()->name}} <i class="mdi mdi-chevron-down"></i> 
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">{{__('login.welcome')}} !</h6>
                </div>

                <!-- item-->
                <a href="{{route('front.index')}}" class="dropdown-item notify-item">
                    <i class="fe-globe"></i>
                    <span>Home</span>
                </a>

                <div class="dropdown-divider"></div>

                <!-- item-->
                <a href="{{route('user.logout')}}" class="dropdown-item notify-item">
                    <i class="fe-log-out"></i>
                    <span>{{__('login.log_out')}}</span>
                </a>

            </div>
        </li>


    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="index.html" class="logo text-center">
            <span class="logo-lg">
                <img src="{{asset('admin/images/logo/logo-light.png')}}" alt="" height="18">
                <!-- <span class="logo-lg-text-light">UBold</span> -->
            </span>
            <span class="logo-sm">
                <!-- <span class="logo-sm-text-dark">U</span> -->
                <img src="{{asset('admin/images/logo/logo-sm.png')}}" alt="" height="24">
            </span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
            <button class="button-menu-mobile waves-effect waves-light">
                <i class="fe-menu"></i>
            </button>
        </li>

        <li class="dropdown d-none d-lg-block">
            <!-- <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                Users
                <i class="mdi mdi-chevron-down"></i> 
            </a> -->
            <div class="dropdown-menu">
                <!-- item-->
                <a href="" class="dropdown-item">
                    <i class="fe-briefcase mr-1"></i>
                    <span>Roles</span>
                </a>

                <!-- item-->
                <a href="" class="dropdown-item">
                    <i class="fe-user mr-1"></i>
                    <span>Users</span>
                </a>

            </div>
        </li>

        <li class="dropdown dropdown-mega d-none d-lg-block">
            {{--<a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                {{__('menu.master_data')}}
                <i class="mdi mdi-chevron-down"></i> 
            </a>--}}
            <div class="dropdown-menu dropdown-megamenu">
                <div class="row">
                    <div class="col-sm-8">
            
                        <div class="row">
                            <div class="col-md-4">
                                <h5 class="text-dark mt-0">{{__('menu.client_master')}}</h5>
                                <ul class="list-unstyled megamenu-list">
                                <li>
                                    <a href="{{route('admin.shippers.index')}}">{{__('menu.shipper')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.categories.index')}}">{{__('menu.category')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.classifications.index')}}">{{__('menu.delivery_classification')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.movements.index')}}">{{__('menu.movement_confirmation')}}</a>
                                </li>
                                </ul>
                            </div>

                            <div class="col-md-4">
                                <h5 class="text-dark mt-0">{{__('menu.wdata_master')}}</h5>
                                <ul class="list-unstyled megamenu-list">
                                <li>
                                    <a href="{{route('admin.wdata-pics.index')}}">{{__('menu.wdata_pic')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.wdata-status.index')}}">{{__('menu.warehouse_status')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.carriers.index')}}">{{__('menu.carrier')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.wdata-categories.index')}}">{{__('menu.category')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.inbound-statuses.index')}}">{{__('menu.inbound_status')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.delivers.index')}}">{{__('menu.delivers')}}</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.custom-brokers.index')}}">{{__('menu.custom_brokers')}}</a>
                                </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>