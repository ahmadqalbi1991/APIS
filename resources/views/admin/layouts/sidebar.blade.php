<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <!-- SidebarSearch Form -->
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->is('admin/customers') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Customers
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.assets.index') }}" class="nav-link {{ request()->is('admin/assets') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>
                            Assets
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.chainOfCustody') }}" class="nav-link {{ request()->is('admin/chain-of-custody') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            Chain of custody
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->is('admin/orders') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>
                            Orders
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.docTypes') }}" class="nav-link {{ request()->is('admin/document-types') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Document Types
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.documents') }}" class="nav-link {{ request()->is('admin/documents') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-pdf"></i>
                        <p>
                            Documents
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
