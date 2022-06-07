<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
        @auth
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('img/user-photo-default.png')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{Auth::user()->name}}</a>
            </div>
        </div>
        @endauth

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    {{-- active --}}
                    <a href="{{route('dashboard.index')}}" class="nav-link {{  request()->routeIs('dashboard.*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @if(Auth::user()->role == 0)
                <li class="nav-item">
                    <a href="{{route('roles.index')}}" class="nav-link {{  request()->routeIs('roles.*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-users"></i>
                        <p>Manage Users</p>
                    </a>
                </li>
                @endif
                @if(Auth::user()->role != 2)
                <li class="nav-item">
                    <a href="{{route('facilities.index')}}" class="nav-link {{  request()->routeIs('facilities.*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-building"></i>
                        <p>Manage Facilities</p>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{route('ratings.index')}}" class="nav-link {{  request()->routeIs('ratings.*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-star"></i>
                        <p>Manage Ratings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('notifications.index')}}" class="nav-link {{  request()->routeIs('notifications.*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-bell"></i>
                        <p>Manage Notifications</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>