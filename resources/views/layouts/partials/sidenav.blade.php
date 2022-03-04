
<div class="left-side-menu">

<div class="slimscroll-menu">

    <!--- Sidemenu -->
    <div id="sidebar-menu">

        <ul class="metismenu" id="side-menu">

            <li class="menu-title">{{__('menu.navigation')}}</li>

            <li>
                <a href="{{route('admin.dashboard')}}">
                    <i class="fe-airplay"></i>
                    <span> {{__('menu.dashboard')}} </span>
                </a>
            </li>
            <li class="">
                <a href="javascript: void(0);" aria-expanded="false">
                    <i class="fe-users"></i>
                    <span> {{__('menu.users')}} </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('admin.roles.index')}}">{{__('menu.roles')}}</a>
                    </li>
                    <li>
                        <a href="{{route('admin.users.index')}}">{{__('menu.users')}}</a>
                    </li>
                </ul>
            </li>

            <li class="menu-title mt-2">{{__('menu.modules')}}</li>
            <li>
                <a href="{{route('admin.wdata.index')}}" class="@if(@$menu == 'Warehouse Data') active @endif">
                    <i class="fe-pocket"></i>
                    <span>{{__('menu.warehouse_data')}}</span>
                </a>
            </li>
            <li>
                <a href="{{route('admin.settings.index')}}" class="@if(@$menu == 'Settings') active @endif">
                    <i class="fe-settings"></i>
                    <span>{{__('menu.settings')}}</span>
                </a>
            </li>
        </ul>

    </div>
    <!-- End Sidebar -->

    <div class="clearfix"></div>

</div>
<!-- Sidebar -left -->

</div>