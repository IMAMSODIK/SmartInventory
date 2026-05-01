<div class="sidebar-wrapper" data-layout="stroke-svg">
    <div class="logo-wrapper">
        <a href="/dashboard">
            <img class="img-fluid" style="width: 100px; margin-top: -30px"
                src="{{ asset('dashboard_assets/assets/images/logo/logo.png') }}" alt="">
        </a>
        <div class="back-btn"><i class="fa fa-angle-left"> </i></div>
        <div class="toggle-sidebar">
            <i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i>
        </div>
    </div>

    <div class="logo-icon-wrapper">
        <a href="/dashboard">
            <img class="img-fluid" width="10px" src="{{ asset('dashboard_assets/assets/images/logo/logo-icon.png') }}"
                alt="">
        </a>
    </div>
    <nav class="sidebar-main">
        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
        <div id="sidebar-menu">
            <ul class="sidebar-links" id="simple-bar">
                <li class="back-btn"><a href="/dashboard"><img class="img-fluid"
                            src="{{ asset('dashboard_assets/assets/images/logo/logo-icon.png') }}" alt=""></a>
                    <div class="mobile-back text-end"> <span>Back </span><i class="fa fa-angle-right ps-2"
                            aria-hidden="true"></i></div>
                </li>
                <li class="pin-title sidebar-main-title">
                    <div>
                        <h6>Pinned</h6>
                    </div>
                </li>
                <li class="sidebar-main-title">
                    <div>
                        <h6 class="lan-1">General</h6>
                    </div>
                </li>

                <li class="sidebar-list">
                    <a class="sidebar-link sidebar-title link-nav" href="/dashboard">
                        <i class="fa fa-home text-white" aria-hidden="true"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @if (auth()->user()->role == 'pedagang')
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="/profile-usaha">
                            <i class="fa fa-building text-white" aria-hidden="true"></i>
                            <span>Profile Usaha</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->role == 'kurir')
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="/profile-driver">
                            <i class="fa fa-motorcycle text-white"></i>
                            <span>Profile Driver</span>
                        </a>
                    </li>
                @endif

                <li class="sidebar-main-title">
                    <div>
                        <h6 class="">Data Master</h6>
                    </div>
                </li>

                @if (in_array(auth()->user()->role, ['pedagang', 'admin']))
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="/daftar-produk">
                            <i class="fa fa-cutlery text-white" aria-hidden="true"></i>
                            <span>Daftar Produk</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->role == 'admin')
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="/users">
                            <i class="fa fa-users text-white" aria-hidden="true"></i>
                            <span>Users</span>
                        </a>
                    </li>
                @endif

                @if (in_array(auth()->user()->role, ['pedagang', 'admin']))
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="">Data Penjualan</h6>
                        </div>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="/daftar-order">
                            <i class="fa fa-shopping-cart text-white me-2"></i>
                            <span class="">Order</span>
                        </a>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="/statistik-penjualan">
                            <i class="fa fa-line-chart text-white" aria-hidden="true"></i>
                            <span>Statistik Penjualan</span>
                        </a>
                    </li>
                @endif

            </ul>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</div>
