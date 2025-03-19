<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index" class="logo logo-dark" style="font-weight:bold">
            <span class="logo-sm" >
              <!--  <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22"> -->
              SRDI
            </span>
            <span class="logo-lg" style="font-size: large; font-weight:bold">
              <!--  <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="17"> -->
              SRDI in CL
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>Analytics</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="dashboard">
                        <i class="ri-dashboard-2-fill"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-title"><span>Forms</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->is('admin/farmers-profile*') ? 'active' : '' }}"
                        href="{{ route('farmers-profile.index') }}">
                        <i class="ri-group-fill"></i>
                        <span>Farmers Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="dashboard">
                        <i class="ri-user-voice-fill"></i>
                        <span>Speaker Evaluation</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="dashboard">
                        <i class="ri-booklet-fill"></i>
                        <span>Training Evaluation</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="dashboard">
                        <i class="ri-bar-chart-grouped-fill"></i>
                        <span>Baseline Monitoring</span>
                    </a>
                </li>
                <li class="menu-title"><span>Account Management</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->is('admin/admin-management*') ? 'active' : '' }}"
                        href="{{ route('admin-management.index') }}">
                        <i class="ri-admin-fill"></i> <span>Admin Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="aews-management">
                        <i class="ri-group-fill"></i>
                        <span>AEWs Management</span>
                    </a>
                </li>
                <li class="menu-title"><span>Settings</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->is('admin/activity-logs*') ? 'active' : '' }}" href="{{ route('activity-logs.index') }}">
                        <i class="ri-list-settings-fill"></i>
                        <span>Activity Logs</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
