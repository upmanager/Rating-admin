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
                        <p>{{__('commons.Dashboard')}}</p>
                    </a>
                </li>
                @if(Auth::user()->role == 0)
                <li class="nav-item">
                    <a href="{{route('roles.index')}}" class="nav-link {{  request()->routeIs('roles.*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-users"></i>
                        <p>{{__('commons.manage-users')}}</p>
                    </a>
                </li>
                @endif
                @if(Auth::user()->role != 2)
                <li class="nav-item">
                    <a href="{{route('facilities.index')}}" class="nav-link {{  request()->routeIs('facilities.*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-building"></i>
                        <p>{{__('commons.manage-facility')}}</p>
                    </a>
                </li>
                @endif
                @if(Auth::user()->role == 0)
                <li class="nav-item">
                    <a href="{{route('offices.index')}}" class="nav-link {{  request()->routeIs('offices.*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-building"></i>
                        <p>{{__('commons.manage-offices')}}</p>
                    </a>
                </li>
                @endif
                @if(Auth::user()->role == 0)
                <li class="nav-item">
                    <a href="{{route('questions.index')}}" class="nav-link {{  request()->routeIs('questions.*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-question"></i>
                        <p>{{__('commons.manage-quest')}}</p>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{route('ratings.index')}}" class="nav-link {{  request()->routeIs('ratings.*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-star"></i>
                        <p>{{__('commons.manage-rating')}}</p>
                    </a>
                </li>
                @if(Auth::user()->role == 0)
                <li class="nav-item">
                    <a href="{{route('analysis.index')}}" class="nav-link {{  request()->routeIs('analysis.*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-book"></i>
                        <p>{{__('commons.analysis')}}</p>
                    </a>
                </li>
                @endif
                @if(Auth::user()->role == 0)
                <li class="nav-item">
                    <a href="{{route('reports.index')}}" class="nav-link {{  request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-book"></i>
                        <p>{{__('commons.reports')}}</p>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{route('notifications.index')}}" class="nav-link {{  request()->routeIs('notifications.*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-bell"></i>
                        <p>{{__('commons.manage-notify')}}</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>