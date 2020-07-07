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

    @can('property-type-list')
    <!-- Nav Item - Roles -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('propertyType.index') }}">
                <i class="fas fa-fw fa-home"></i>
                <span>@lang('messages.propertyTypes')</span>
            </a>
        </li>
    @endcan

    @can('property-status-list')
    <!-- Nav Item - Roles -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('propertyStatus.index') }}">
                <i class="fas fa-fw fa-home"></i>
                <span>@lang('messages.propertyStatus')</span>
            </a>
        </li>
    @endcan

    @can('property-legal-list')
    <!-- Nav Item - Roles -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('propertyLegalCondition.index') }}">
                <i class="fas fa-fw fa-home"></i>
                <span>@lang('messages.propertyLegalConditions')</span>
            </a>
        </li>
    @endcan

    @can('currency-list')
    <!-- Nav Item - Roles -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('currency.index') }}">
                <i class="fas fa-fw fa-dollar-sign"></i>
                <span>@lang('messages.currencies')</span>
            </a>
        </li>
    @endcan

    @can('property-list')
    <!-- Nav Item - Roles -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('property.index') }}">
                <i class="fas fa-fw fa-home"></i>
                <span>@lang('messages.properties')</span>
            </a>
        </li>
    @endcan

    @can('log')

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
