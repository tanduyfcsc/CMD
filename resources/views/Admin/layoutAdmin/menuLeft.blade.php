<div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical bg-white logo-dark">
    <div class="app-brand demo">
        <span class="app-brand-logo demo">
            <img src="{{ URL::to('assetsAdmin/img/logo.png') }}" alt="Brand Logo" class="img-fluid">
        </span>
        <a href="{{ route('admin-dashboard') }}"
            class="app-brand-text demo sidenav-text font-weight-normal ml-2">Empire</a>
        <a href="javascript:" class="layout-sidenav-toggle sidenav-link text-large ml-auto">
            <i class="ion ion-md-menu align-middle"></i>
        </a>
    </div>
    <div class="sidenav-divider mt-0"></div>

    <ul class="sidenav-inner py-1">

        <li class="sidenav-item active">
            <a href="{{ route('admin-dashboard') }}" class="sidenav-link">
                <i class="sidenav-icon feather icon-home"></i>
                <div>Dashboards</div>
            </a>
        </li>

        <li class="sidenav-divider mb-1"></li>
        <li class="sidenav-header small font-weight-semibold">Người dùng</li>
        <li class="sidenav-item">
            <a href="javascript:" class="sidenav-link sidenav-toggle">
                <i class="sidenav-icon lnr lnr-users"></i>
                <div>Người dùng</div>
            </a>
            <ul class="sidenav-menu">
                <li class="sidenav-item">
                    <a href="{{ route('admin-add-user') }}" class="sidenav-link">
                        <div>Thêm người dùng</div>
                    </a>
                </li>
                <li class="sidenav-item">
                    <a href="{{ route('user-management') }}" class="sidenav-link">
                        <div>Quản lí nhân viên </div>
                    </a>
                </li>
                <li class="sidenav-item">
                    <a href="{{ route('user-lecturers') }}" class="sidenav-link">
                        <div>Quản lí giảng viên </div>
                    </a>
                </li>
                <li class="sidenav-item">
                    <a href="{{ route('studentManagement') }}" class="sidenav-link">
                        <div>Quản lí người dùng </div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="sidenav-divider mb-1"></li>
        <li class="sidenav-header small font-weight-semibold">Đơn hàng</li>
        <li class="sidenav-item">
            <a href="javascript:" class="sidenav-link sidenav-toggle">
                <i class="sidenav-icon feather icon-clipboard"></i>
                <div>Đơn hàng</div>
            </a>
            <ul class="sidenav-menu">
                <li class="sidenav-item">
                    <a href="{{ route('oder-management') }}" class="sidenav-link">
                        <div>Quản lí đơn hàng</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="sidenav-divider mb-1"></li>
    </ul>
</div>
