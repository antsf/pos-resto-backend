<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">POS Resto</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown {{ $type_menu === 'home' ? 'active' : '' }}">
                <a href="{{ route('home') }}"
                    class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                {{-- <ul class="dropdown-menu">
                    <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('dashboard-general-dashboard') }}">General Dashboard</a>
                    </li>
                    <li class="{{ Request::is('dashboard-ecommerce-dashboard') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('dashboard-ecommerce-dashboard') }}">Ecommerce Dashboard</a>
                    </li>
                </ul> --}}
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'users' ? 'active' : '' }}">
                <a href="{{ route('users.index') }}"
                    class="nav-link"><i class="fas fa-users"></i><span>Users</span></a>
                {{-- <ul class="dropdown-menu">
                    <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="
                            {{ route('users.index') }}
                             ">Index</a>
                    </li>
                    <li class="{{ Request::is('dashboard-ecommerce-dashboard') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('dashboard-ecommerce-dashboard') }}">Ecommerce Dashboard</a>
                    </li>
                </ul> --}}
            </li>
            <li class="nav-item {{ $type_menu === 'products' ? 'active' : '' }}">
                <a href="{{ route('products.index') }}"
                    class="nav-link"><i class="fas fa-cubes"></i><span>Products</span></a>
            </li>
            <li class="nav-item {{ $type_menu === 'categories' ? 'active' : '' }}">
                <a href="{{ route('categories.index') }}"
                    class="nav-link"><i class="fas fa-cube"></i><span>Categories</span></a>
            </li>
        </ul>
    </aside>
</div>
