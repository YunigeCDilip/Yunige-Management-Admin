<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{@$title}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="会社概要とアクセス情報">
        <meta name="keywords" content="化粧品輸入代,化粧品OEM,オリジナル化粧品,PB化粧品,化粧品許可,薬機法,薬事法,化粧品製造販売業許可,化粧品製造業許可,化粧品製造販売業,化粧品製造業">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('admin')}}/images/favicon.ico">
        @include('layouts.partials.style')
        @yield('additional-css')

        </head>

<body>

    <!-- Pre-loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner">Loading...</div>
        </div>
    </div>
    <!-- End Preloader-->

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->

        @include('layouts.partials.topnav')
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        @include('layouts.partials.sidenav')
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                        
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{trans('menu.yunige_service')}}</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{@$menu}}</a></li>
                                        @if(isset($subMenu) && $subMenu != '')
                                            <li class="breadcrumb-item active">{{$subMenu}}</li>
                                        @endif
                                    </ol>
                                </div>
                                <h4 class="page-title">{{@$title}}</h4>
                            </div>
                        </div>
                    </div>     
                    <!-- end page title --> 
                    @yield('content')
                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->

            @include('layouts.partials.footer')
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->
    @yield('additional-content')
    @include('layouts.partials.script')
    @yield('additional-js')
    
</body>
</html>