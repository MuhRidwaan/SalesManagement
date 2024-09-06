<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="/profile" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Inventory -->
                <li class="nav-item {{ Request::routeIs('inventory.*') ? 'menu-open' : '' }}">
                    <a href="{{ route('inventory.index') }}"
                        class="nav-link {{ Request::routeIs('inventory.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Inventory</p>
                    </a>
                </li>

                <!-- Master -->
                <li
                    class="nav-item {{ Request::routeIs('items.*') || Request::routeIs('uoms.*') || Request::routeIs('groups.*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ Request::routeIs('items.*') || Request::routeIs('uoms.*') || Request::routeIs('groups.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Master <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul
                        class="nav nav-treeview {{ Request::routeIs('items.*') || Request::routeIs('uoms.*') || Request::routeIs('groups.*') ? 'menu-open' : '' }}">
                        <li class="nav-item">
                            <a href="{{ route('items.index') }}"
                                class="nav-link {{ Request::routeIs('items.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Item</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('uoms.index') }}"
                                class="nav-link {{ Request::routeIs('uoms.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>UOM / Satuan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('groups.index') }}"
                                class="nav-link {{ Request::routeIs('groups.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Group</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- <!-- Sales -->
                <li class="nav-item {{ Request::routeIs('sales.*') ? 'menu-open' : '' }}">
                    <a href="{{ route('sales.index') }}"
                        class="nav-link {{ Request::routeIs('sales.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Sales</p>
                    </a>
                </li> --}}

                <li class="nav-item {{ Request::routeIs('sales.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::routeIs('sales.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Sales <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview {{ Request::routeIs('sales.*') ? 'menu-open' : '' }}">
                        <li class="nav-item">
                            <a href="{{ route('sales.index') }}"
                                class="nav-link {{ Request::routeIs('sales.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sales Overview</p>
                            </a>
                        </li>
                        <!-- Add more sales-related links here -->
                    </ul>
                </li>

                <!-- Report -->
                <li class="nav-item {{ Request::routeIs('report.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::routeIs('report.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Report <i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview {{ Request::routeIs('report.*') ? 'menu-open' : '' }}">
                        <li class="nav-item">
                            <a href="{{ route('report.reportSales') }}"
                                class="nav-link {{ Request::routeIs('report.reportSales') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sales Report</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <!-- Logout -->
                <li class="nav-header">LABELS</li>
                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                        <p class="text">Logout</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
