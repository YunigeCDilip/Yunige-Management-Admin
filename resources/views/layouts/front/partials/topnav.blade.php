<header id="topnav">

    <!-- Topbar Start -->
    <div class="navbar-custom">
        <div class="container-fluid">
            <ul class="list-unstyled topnav-menu float-right mb-0">

                <li class="dropdown notification-list">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle nav-link">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </li>
                @if(!auth()->check())
                    <li class="dropdown notification-list">
                        <a href="{{route('login')}}" class="nav-link custom-login-nav dropdown-toggle">
                            <span class="fe-lock"></span> LOGIN
                            </a>
                    </li>
                    <li class="dropdown notification-list">
                        <a href="{{route('register')}}" class="nav-link custom-register-nav dropdown-toggle">
                            <span class="fe-user"></span> REGISTER
                            </a>
                    </li>
                @else
                @if(auth()->user()->is_super_admin)
                    <li class="dropdown notification-list">
                        <a href="{{route('admin.dashboard')}}" class="nav-link custom-register-nav dropdown-toggle">
                            <span class="fe-airplay"></span> DASHBOARD
                            </a>
                    </li>
                @else
                    <li class="dropdown notification-list">
                        <a href="{{route('logout')}}" class="nav-link custom-register-nav dropdown-toggle">
                            <span class="fe-log-out"></span> LOGOUT
                            </a>
                    </li>
                @endif
                @endif

            </ul>

            <!-- LOGO -->
            <div class="logo-box">
                <a href="{{route('front.index')}}" class="logo text-center">
                    <span class="logo-lg">
                        <img src="{{asset('front')}}/images/yunige.png" alt="" height="18">
                        <!-- <span class="logo-lg-text-light">UBold</span> -->
                    </span>
                    <span class="logo-sm">
                        <!-- <span class="logo-sm-text-dark">U</span> -->
                        <img src="{{asset('front')}}/images/yunige.png" alt="" height="24">
                    </span>
                </a>
            </div>

            <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                
                <li class="dropdown dropdown-mega d-none d-lg-block">
                    <a class="nav-link dropdown-toggle waves-effect" href="#" role="button">
                        FNSKU Storage
                    </a>
                </li>
                <li class="dropdown dropdown-mega d-none d-lg-block">
                    <a class="nav-link dropdown-toggle waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        Services
                        <i class="mdi mdi-chevron-down"></i> 
                    </a>
                    <div class="dropdown-menu dropdown-megamenu">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h5 class="text-dark mt-0">Master Items</h5>
                                        <ul class="list-unstyled megamenu-list">
                                            <li>
                                                <a href="javascript:void(0);">Clients</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);">Products</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-md-4">
                                        <h5 class="text-dark mt-0">Warehouse</h5>
                                        <ul class="list-unstyled megamenu-list">
                                            <li>
                                                <a href="javascript:void(0);">Warehouse Data</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);">Warehouse Data Detail</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-md-4">
                                        <h5 class="text-dark mt-0">Logistic Department</h5>
                                        <ul class="list-unstyled megamenu-list">
                                            <li>
                                                <a href="javascript:void(0);">Goods receipt storage work</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);">Warehouse tax included storage</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <h5 class="text-dark mt-0">Shipment</h5>
                                <ul class="list-unstyled megamenu-list">
                                    <li>
                                        <a href="javascript:void(0);">Shipping instructions (charge → warehouse)</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Confirm shipping instructions → Shipping → Enter invoice number (warehouse)</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </li>
            </ul>
        </div> <!-- end container-fluid-->
    </div>
    <!-- end Topbar -->

</header>