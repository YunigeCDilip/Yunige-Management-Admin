
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
            <li class="">
                <a href="javascript: void(0);" aria-expanded="false">
                    <i class="fe-airplay"></i>
                    <span> {{__('menu.zoom')}} </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('admin.meetings.list')}}">{{__('menu.meeting')}}</a>
                    </li>
                    <li>
                        <a href="{{route('admin.rooms.list')}}">{{__('menu.room')}}</a>
                    </li>
                </ul>
            </li>

            <li class="menu-title mt-2">{{__('menu.master_data')}}</li>
            <li class="">
                <a href="javascript: void(0);" aria-expanded="false">
                    <i class="fe-users"></i>
                    <span> {{__('menu.client_master')}} </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
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
            </li>

            <li class="menu-title mt-2">{{__('menu.modules')}}</li>            
            <li>
                <a href="{{route('admin.clients.index')}}" class="@if(@$menu == 'Client Data') active @endif">
                    <i class="fe-pocket"></i>
                    <span>{{__('menu.client')}}</span>
                </a>
            </li>
                        
            <li>
                <a href="{{route('admin.amazon-progress.index')}}" class="@if(@$menu == 'Amazon Progress') active @endif">
                    <i class="fe-pocket"></i>
                    <span>{{__('menu.amazon_progress')}}</span>
                </a>
            </li>
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