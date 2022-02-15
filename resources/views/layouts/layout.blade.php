<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{@$title}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="admin/images/favicon.ico">
        @include('layouts.partials.style')
        @yield('additional-css')

        </head>

<body>

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
                                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Yunige Service</a></li>
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