
<div class="left-side-menu">

<div class="slimscroll-menu">

    <!--- Sidemenu -->
    <div id="sidebar-menu">

        <ul class="metismenu" id="side-menu">

            <li class="menu-title">Navigation</li>

            <li>
                <a href="{{route('admin.dashboard')}}">
                    <i class="fe-airplay"></i>
                    <span> Dashboards </span>
                </a>
            </li>
            <li class="">
                <a href="javascript: void(0);" aria-expanded="false">
                    <i class="fe-users"></i>
                    <span> Users </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('admin.roles.index')}}">Roles</a>
                    </li>
                    <li>
                        <a href="{{route('admin.users.index')}}">Users</a>
                    </li>
                </ul>
            </li>

            <li class="menu-title mt-2">Modules</li>
            <li>
                <a href="{{route('admin.wdata.index')}}" class="@if(@$menu == 'Warehouse Data') active @endif">
                    <i class="fe-pocket"></i>
                    <span>Warehouse Data</span>
                </a>
            </li>
        </ul>

    </div>
    <!-- End Sidebar -->

    <div class="clearfix"></div>

</div>
<!-- Sidebar -left -->

</div>