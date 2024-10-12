<div id="sidebar" class='active'>
    <div class="sidebar-wrapper active">
        <div class="sidebar-menu">
            <ul class="menu">
                <li class='sidebar-title'>Main Menu</li>
                <li class="sidebar-item">
                    <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
                        <i data-feather="home" width="20"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../admin_request/index.php" class='sidebar-link'>
                        <i data-feather="layers" width="20"></i>
                        <span>Request Certificate</span>
                    </a>
                </li>

                <li class='sidebar-title'>Data Master</li>
                <li class="sidebar-item">
                    <a href="{{ route('admin.marketing.index') }}" class='sidebar-link'>
                        <i data-feather="users" width="20"></i>
                        <span>Marketing</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('admin.company.index') }}" class='sidebar-link'>
                        <i data-feather="globe" width="20"></i>
                        <span>Company Profile</span>
                    </a>
                </li><li class="sidebar-item">
                    <a href="{{ route('admin.catalog.index') }}" class='sidebar-link'>
                        <i data-feather="book" width="20"></i>
                        <span>Catalog</span>
                    </a>
                </li><li class="sidebar-item">
                    <a href="../admin_ecard/index.php" class='sidebar-link'>
                        <i data-feather="credit-card" width="20"></i>
                        <span>E-Card</span>
                    </a>
                </li>
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
