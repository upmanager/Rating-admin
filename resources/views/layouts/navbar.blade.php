<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('dashboard.index')}}" class="nav-link">{{__('commons.Dashboard')}}</a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    {{-- <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </form> --}}

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        {{-- <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                @if (session()->get('lang_code')=='en')
                <i class="fi fi-us"></i>
                @else
                <i class="fi fi-sa"></i>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right p-0" style="left: inherit; right: 0px;">
                <a href="{{route('change-language', 'en')}}" class="dropdown-item {{session()->get('lang_code')=='en' ? 'active' : ''}}">
                    <i class="fi fi-us mr-2"></i> English
                </a>
                <a href="{{route('change-language', 'ar')}}" class="dropdown-item {{session()->get('lang_code')=='en' ? '' : 'active'}}">
                    <i class="fi fi-sa mr-2"></i> عربي
                </a>
            </div>
        </li> --}}

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fa fa-cog"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                <a href="{{route('settings.index')}}" class="dropdown-item">{{__('commons.Settings')}}</a>
                <div class="dropdown-divider"></div>
                <form id="logout-form" action="{{route('logout')}}" method="post">
                    @csrf
                </form>
                <a href="javascript:void(0)" onclick="$('#logout-form').submit();" class="dropdown-item">{{__('commons.Logout')}}</a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->