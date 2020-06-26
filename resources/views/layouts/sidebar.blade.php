<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <img alt="" src="{{ asset('img/logo.png') }}" style="width: 80%;" class="mx-auto my-3" />
    <!-- Divider -->
    <hr class="sidebar-divider my-3">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    @can('user-list')
        <!-- Nav Item - Users -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>@lang('messages.users')</span>
            </a>
        </li>
    @endcan

    @can('user-role-list')
        <!-- Nav Item - Roles -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('userRole.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>@lang('messages.userRoles')</span>
            </a>
        </li>
    @endcan

    @can('country-list')
        <!-- Nav Item - Roles -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('country.index') }}">
                <i class="fas fa-fw fa-flag"></i>
                <span>@lang('messages.countries')</span>
            </a>
        </li>
    @endcan

    @can('city-list')
    <!-- Nav Item - Roles -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('city.index') }}">
                <i class="fas fa-fw fa-flag"></i>
                <span>@lang('messages.cities')</span>
            </a>
        </li>
    @endcan
</ul>
