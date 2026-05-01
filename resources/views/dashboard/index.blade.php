@extends('layouts.template')

@section('own_style')
@endsection

@section('content')
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @else
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>{{ $pageTitle }}</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('dashboard_assets/assets/svg/icon-sprite.svg#stroke-home') }}">
                                        </use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">{{ $pageTitle }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            @if (auth()->user()->role == 'kurir')
                <div class="row">
                    <div class="col-xl-4 col-sm-12">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-project border-b-primary border-2"><span
                                    class="f-light f-w-500 f-14">Total Project</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600">1,523</h2><span class="f-12 f-w-400">(This month)</span>
                                    </div>
                                    <div class="product-sub bg-primary-light">
                                        <svg class="invoice-icon">
                                            <use
                                                href="{{ asset('dashboard_assets/assets/svg/icon-sprite.svg#color-swatch') }}">
                                            </use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="incoming-order-wrapper" style="display:none;">
                    <div class="col-12">
                        <div class="card border border-warning shadow-sm">

                            <div class="card-body">

                                <h5 class="text-warning mb-3">
                                    🚚 Order Masuk!
                                </h5>

                                <p><b>Order ID:</b> <span id="order-id"></span></p>
                                <p><b>Customer:</b> <span id="customer-name"></span></p>
                                <p><b>Alamat:</b> <span id="customer-address"></span></p>

                                <hr>

                                <div id="order-items"></div>

                                <div class="mt-3 d-flex gap-2">
                                    <button class="btn btn-success" id="btn-start-delivery">
                                        Mulai Antar
                                    </button>

                                    <button class="btn btn-secondary" id="btn-hide-order">
                                        Sembunyikan
                                    </button>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-xl-6 box-col-7">
                        <div class="card">
                            <div class="card-header sales-chart card-no-border pb-0">
                                <h4>Sales Chart </h4>
                                <div class="sales-chart-dropdown">
                                    <ul class="balance-data">
                                        <li> <span class="circle bg-warning"></span><span
                                                class="f-light ms-1">Revenue</span>
                                        </li>
                                        <li><span class="circle bg-primary"> </span><span class="f-light ms-1">Orders</span>
                                        </li>
                                    </ul>
                                    <div class="sales-chart-dropdown-select">
                                        <div class="card-header-right-icon online-store">
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle dropdown-toggle-store"
                                                    id="dropdownMenuButtonToggle" data-bs-toggle="dropdown"
                                                    aria-expanded="false">Online Store</button>
                                                <div class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="dropdownMenuButtonToggle" role="menu"><span
                                                        class="dropdown-item">All </span><span
                                                        class="dropdown-item">Employee</span><span
                                                        class="dropdown-item">Client
                                                    </span></div>
                                            </div>
                                        </div>
                                        <div class="card-header-right-icon">
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" id="dropdownMenuButton1"
                                                    data-bs-toggle="dropdown" aria-expanded="false">Last Year </button>
                                                <div class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="dropdownMenuButton1" role="menu"><span
                                                        class="dropdown-item">Last Month</span><span
                                                        class="dropdown-item">Last
                                                        Week </span><span class="dropdown-item">Today </span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 box-col-5 total-revenue-total-order">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="total-revenue mb-2"> <span>Total Revenue</span><a href="index.html">View
                                                Report</a></div>
                                        <h3 class="f-w-600">₹97,250.89 </h3>
                                        <div class="total-chart">
                                            <div class="data-grow d-flex gap-2"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="feather feather-arrow-up-right font-primary">
                                                    <line x1="7" y1="17" x2="17" y2="7">
                                                    </line>
                                                    <polyline points="7 7 17 7 17 17"></polyline>
                                                </svg><span class="f-w-500">60.00% from last year </span></div>
                                            <div class="total-revenue-chart">
                                                <div id="revenue" style="min-height: 135px;">
                                                    <div id="apexchartsw1evsj28"
                                                        class="apexcharts-canvas apexchartsw1evsj28 apexcharts-theme-light"
                                                        style="width: 145px; height: 120px;"><svg id="SvgjsSvg1405"
                                                            width="145" height="120"
                                                            xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                                            xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg"
                                                            xmlns:data="ApexChartsNS" transform="translate(0, -20)"
                                                            style="background: transparent;">
                                                            <g id="SvgjsG1407"
                                                                class="apexcharts-inner apexcharts-graphical"
                                                                transform="translate(14.075, 30)">
                                                                <defs id="SvgjsDefs1406">
                                                                    <linearGradient id="SvgjsLinearGradient1410"
                                                                        x1="0" y1="0" x2="0"
                                                                        y2="1">
                                                                        <stop id="SvgjsStop1411" stop-opacity="0.4"
                                                                            stop-color="rgba(216,227,240,0.4)"
                                                                            offset="0">
                                                                        </stop>
                                                                        <stop id="SvgjsStop1412" stop-opacity="0.5"
                                                                            stop-color="rgba(190,209,230,0.5)"
                                                                            offset="1">
                                                                        </stop>
                                                                        <stop id="SvgjsStop1413" stop-opacity="0.5"
                                                                            stop-color="rgba(190,209,230,0.5)"
                                                                            offset="1">
                                                                        </stop>
                                                                    </linearGradient>
                                                                    <clipPath id="gridRectMaskw1evsj28">
                                                                        <rect id="SvgjsRect1415"
                                                                            width="150.99999999999997" height="77"
                                                                            x="-13.075" y="-1" rx="0"
                                                                            ry="0" opacity="1"
                                                                            stroke-width="0" stroke="none"
                                                                            stroke-dasharray="0" fill="#fff"></rect>
                                                                    </clipPath>
                                                                    <clipPath id="forecastMaskw1evsj28"></clipPath>
                                                                    <clipPath id="nonForecastMaskw1evsj28"></clipPath>
                                                                    <clipPath id="gridRectMarkerMaskw1evsj28">
                                                                        <rect id="SvgjsRect1416" width="128.85"
                                                                            height="79" x="-2" y="-2" rx="0"
                                                                            ry="0" opacity="1"
                                                                            stroke-width="0" stroke="none"
                                                                            stroke-dasharray="0" fill="#fff"></rect>
                                                                    </clipPath>
                                                                </defs>
                                                                <rect id="SvgjsRect1414" width="4.36975" height="75"
                                                                    x="0" y="0" rx="0" ry="0"
                                                                    opacity="1" stroke-width="0" stroke-dasharray="3"
                                                                    fill="url(#SvgjsLinearGradient1410)"
                                                                    class="apexcharts-xcrosshairs" y2="75"
                                                                    filter="none" fill-opacity="0.9"></rect>
                                                                <g id="SvgjsG1483" class="apexcharts-xaxis"
                                                                    transform="translate(0, 0)">
                                                                    <g id="SvgjsG1484" class="apexcharts-xaxis-texts-g"
                                                                        transform="translate(0, -4)"></g>
                                                                </g>
                                                                <g id="SvgjsG1472" class="apexcharts-grid">
                                                                    <g id="SvgjsG1473"
                                                                        class="apexcharts-gridlines-horizontal"
                                                                        style="display: none;">
                                                                        <line id="SvgjsLine1477" x1="-10.075"
                                                                            y1="18.75" x2="134.92499999999998"
                                                                            y2="18.75" stroke="#e0e0e0"
                                                                            stroke-dasharray="0" stroke-linecap="butt"
                                                                            class="apexcharts-gridline"></line>
                                                                        <line id="SvgjsLine1478" x1="-10.075"
                                                                            y1="37.5" x2="134.92499999999998"
                                                                            y2="37.5" stroke="#e0e0e0"
                                                                            stroke-dasharray="0" stroke-linecap="butt"
                                                                            class="apexcharts-gridline"></line>
                                                                        <line id="SvgjsLine1479" x1="-10.075"
                                                                            y1="56.25" x2="134.92499999999998"
                                                                            y2="56.25" stroke="#e0e0e0"
                                                                            stroke-dasharray="0" stroke-linecap="butt"
                                                                            class="apexcharts-gridline"></line>
                                                                    </g>
                                                                    <g id="SvgjsG1474"
                                                                        class="apexcharts-gridlines-vertical"
                                                                        style="display: none;"></g>
                                                                    <line id="SvgjsLine1482" x1="0"
                                                                        y1="75" x2="124.85" y2="75"
                                                                        stroke="transparent" stroke-dasharray="0"
                                                                        stroke-linecap="butt"></line>
                                                                    <line id="SvgjsLine1481" x1="0"
                                                                        y1="1" x2="0" y2="75"
                                                                        stroke="transparent" stroke-dasharray="0"
                                                                        stroke-linecap="butt"></line>
                                                                </g>
                                                                <g id="SvgjsG1417"
                                                                    class="apexcharts-bar-series apexcharts-plot-series">
                                                                    <g id="SvgjsG1418" class="apexcharts-series"
                                                                        rel="1" seriesName="NetxProfit"
                                                                        data:realIndex="0">
                                                                        <path id="SvgjsPath1422"
                                                                            d="M -4.36975 74.001 L -4.36975 26.001 C -4.36975 25.501 -3.86975 25.001 -3.36975 25.001 L -3 25.001 C -2.5 25.001 -2 25.501 -2 26.001 L -2 74.001 C -2 74.501 -2.5 75.001 -3 75.001 L -3.36975 75.001 C -3.86975 75.001 -4.36975 74.501 -4.36975 74.001 Z "
                                                                            fill="rgba(0,102,102,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="0"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M -4.36975 74.001 L -4.36975 26.001 C -4.36975 25.501 -3.86975 25.001 -3.36975 25.001 L -3 25.001 C -2.5 25.001 -2 25.501 -2 26.001 L -2 74.001 C -2 74.501 -2.5 75.001 -3 75.001 L -3.36975 75.001 C -3.86975 75.001 -4.36975 74.501 -4.36975 74.001 Z "
                                                                            pathFrom="M -4.36975 75.001 L -4.36975 75.001 L -2 75.001 L -2 75.001 L -2 75.001 L -2 75.001 L -2 75.001 L -4.36975 75.001 Z"
                                                                            cy="25" cx="-1" j="0"
                                                                            val="80" barHeight="50"
                                                                            barWidth="4.36975">
                                                                        </path>
                                                                        <path id="SvgjsPath1424"
                                                                            d="M 6.98025 74.001 L 6.98025 47.876 C 6.98025 47.376 7.48025 46.876 7.98025 46.876 L 8.35 46.876 C 8.85 46.876 9.35 47.376 9.35 47.876 L 9.35 74.001 C 9.35 74.501 8.85 75.001 8.35 75.001 L 7.98025 75.001 C 7.48025 75.001 6.98025 74.501 6.98025 74.001 Z "
                                                                            fill="rgba(0,102,102,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="0"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 6.98025 74.001 L 6.98025 47.876 C 6.98025 47.376 7.48025 46.876 7.98025 46.876 L 8.35 46.876 C 8.85 46.876 9.35 47.376 9.35 47.876 L 9.35 74.001 C 9.35 74.501 8.85 75.001 8.35 75.001 L 7.98025 75.001 C 7.48025 75.001 6.98025 74.501 6.98025 74.001 Z "
                                                                            pathFrom="M 6.98025 75.001 L 6.98025 75.001 L 9.35 75.001 L 9.35 75.001 L 9.35 75.001 L 9.35 75.001 L 9.35 75.001 L 6.98025 75.001 Z"
                                                                            cy="46.875" cx="10.35" j="1"
                                                                            val="45" barHeight="28.125"
                                                                            barWidth="4.36975"></path>
                                                                        <path id="SvgjsPath1426"
                                                                            d="M 18.33025 74.001 L 18.33025 32.251000000000005 C 18.33025 31.751000000000005 18.83025 31.251 19.33025 31.251 L 19.7 31.251 C 20.2 31.251 20.7 31.751000000000005 20.7 32.251000000000005 L 20.7 74.001 C 20.7 74.501 20.2 75.001 19.7 75.001 L 19.33025 75.001 C 18.83025 75.001 18.33025 74.501 18.33025 74.001 Z "
                                                                            fill="rgba(0,102,102,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="0"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 18.33025 74.001 L 18.33025 32.251000000000005 C 18.33025 31.751000000000005 18.83025 31.251 19.33025 31.251 L 19.7 31.251 C 20.2 31.251 20.7 31.751000000000005 20.7 32.251000000000005 L 20.7 74.001 C 20.7 74.501 20.2 75.001 19.7 75.001 L 19.33025 75.001 C 18.83025 75.001 18.33025 74.501 18.33025 74.001 Z "
                                                                            pathFrom="M 18.33025 75.001 L 18.33025 75.001 L 20.7 75.001 L 20.7 75.001 L 20.7 75.001 L 20.7 75.001 L 20.7 75.001 L 18.33025 75.001 Z"
                                                                            cy="31.25" cx="21.7" j="2"
                                                                            val="70" barHeight="43.75"
                                                                            barWidth="4.36975"></path>
                                                                        <path id="SvgjsPath1428"
                                                                            d="M 29.680249999999997 74.001 L 29.680249999999997 13.501 C 29.680249999999997 13.001 30.180249999999997 12.501 30.680249999999997 12.501 L 31.049999999999997 12.501 C 31.549999999999997 12.501 32.05 13.001 32.05 13.501 L 32.05 74.001 C 32.05 74.501 31.549999999999997 75.001 31.049999999999997 75.001 L 30.680249999999997 75.001 C 30.180249999999997 75.001 29.680249999999997 74.501 29.680249999999997 74.001 Z "
                                                                            fill="rgba(0,102,102,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="0"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 29.680249999999997 74.001 L 29.680249999999997 13.501 C 29.680249999999997 13.001 30.180249999999997 12.501 30.680249999999997 12.501 L 31.049999999999997 12.501 C 31.549999999999997 12.501 32.05 13.001 32.05 13.501 L 32.05 74.001 C 32.05 74.501 31.549999999999997 75.001 31.049999999999997 75.001 L 30.680249999999997 75.001 C 30.180249999999997 75.001 29.680249999999997 74.501 29.680249999999997 74.001 Z "
                                                                            pathFrom="M 29.680249999999997 75.001 L 29.680249999999997 75.001 L 32.05 75.001 L 32.05 75.001 L 32.05 75.001 L 32.05 75.001 L 32.05 75.001 L 29.680249999999997 75.001 Z"
                                                                            cy="12.5" cx="33.05" j="3"
                                                                            val="100" barHeight="62.5"
                                                                            barWidth="4.36975"></path>
                                                                        <path id="SvgjsPath1430"
                                                                            d="M 41.030249999999995 74.001 L 41.030249999999995 21.626 C 41.030249999999995 21.126 41.530249999999995 20.626 42.030249999999995 20.626 L 42.39999999999999 20.626 C 42.89999999999999 20.626 43.39999999999999 21.126 43.39999999999999 21.626 L 43.39999999999999 74.001 C 43.39999999999999 74.501 42.89999999999999 75.001 42.39999999999999 75.001 L 42.030249999999995 75.001 C 41.530249999999995 75.001 41.030249999999995 74.501 41.030249999999995 74.001 Z "
                                                                            fill="rgba(0,102,102,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="0"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 41.030249999999995 74.001 L 41.030249999999995 21.626 C 41.030249999999995 21.126 41.530249999999995 20.626 42.030249999999995 20.626 L 42.39999999999999 20.626 C 42.89999999999999 20.626 43.39999999999999 21.126 43.39999999999999 21.626 L 43.39999999999999 74.001 C 43.39999999999999 74.501 42.89999999999999 75.001 42.39999999999999 75.001 L 42.030249999999995 75.001 C 41.530249999999995 75.001 41.030249999999995 74.501 41.030249999999995 74.001 Z "
                                                                            pathFrom="M 41.030249999999995 75.001 L 41.030249999999995 75.001 L 43.39999999999999 75.001 L 43.39999999999999 75.001 L 43.39999999999999 75.001 L 43.39999999999999 75.001 L 43.39999999999999 75.001 L 41.030249999999995 75.001 Z"
                                                                            cy="20.625" cx="44.39999999999999" j="4"
                                                                            val="87" barHeight="54.375"
                                                                            barWidth="4.36975"></path>
                                                                        <path id="SvgjsPath1432"
                                                                            d="M 52.380250000000004 74.001 L 52.380250000000004 19.751 C 52.380250000000004 19.251 52.880250000000004 18.751 53.380250000000004 18.751 L 53.75 18.751 C 54.25 18.751 54.75 19.251 54.75 19.751 L 54.75 74.001 C 54.75 74.501 54.25 75.001 53.75 75.001 L 53.380250000000004 75.001 C 52.880250000000004 75.001 52.380250000000004 74.501 52.380250000000004 74.001 Z "
                                                                            fill="rgba(0,102,102,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="0"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 52.380250000000004 74.001 L 52.380250000000004 19.751 C 52.380250000000004 19.251 52.880250000000004 18.751 53.380250000000004 18.751 L 53.75 18.751 C 54.25 18.751 54.75 19.251 54.75 19.751 L 54.75 74.001 C 54.75 74.501 54.25 75.001 53.75 75.001 L 53.380250000000004 75.001 C 52.880250000000004 75.001 52.380250000000004 74.501 52.380250000000004 74.001 Z "
                                                                            pathFrom="M 52.380250000000004 75.001 L 52.380250000000004 75.001 L 54.75 75.001 L 54.75 75.001 L 54.75 75.001 L 54.75 75.001 L 54.75 75.001 L 52.380250000000004 75.001 Z"
                                                                            cy="18.75" cx="55.75" j="5"
                                                                            val="90" barHeight="56.25"
                                                                            barWidth="4.36975"></path>
                                                                        <path id="SvgjsPath1434"
                                                                            d="M 63.73025 74.001 L 63.73025 26.001 C 63.73025 25.501 64.23025 25.001 64.73025 25.001 L 65.1 25.001 C 65.6 25.001 66.1 25.501 66.1 26.001 L 66.1 74.001 C 66.1 74.501 65.6 75.001 65.1 75.001 L 64.73025 75.001 C 64.23025 75.001 63.73025 74.501 63.73025 74.001 Z "
                                                                            fill="rgba(0,102,102,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="0"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 63.73025 74.001 L 63.73025 26.001 C 63.73025 25.501 64.23025 25.001 64.73025 25.001 L 65.1 25.001 C 65.6 25.001 66.1 25.501 66.1 26.001 L 66.1 74.001 C 66.1 74.501 65.6 75.001 65.1 75.001 L 64.73025 75.001 C 64.23025 75.001 63.73025 74.501 63.73025 74.001 Z "
                                                                            pathFrom="M 63.73025 75.001 L 63.73025 75.001 L 66.1 75.001 L 66.1 75.001 L 66.1 75.001 L 66.1 75.001 L 66.1 75.001 L 63.73025 75.001 Z"
                                                                            cy="25" cx="67.1" j="6"
                                                                            val="80" barHeight="50"
                                                                            barWidth="4.36975">
                                                                        </path>
                                                                        <path id="SvgjsPath1436"
                                                                            d="M 75.08025 74.001 L 75.08025 21.626 C 75.08025 21.126 75.58025 20.626 76.08025 20.626 L 76.45 20.626 C 76.95 20.626 77.45 21.126 77.45 21.626 L 77.45 74.001 C 77.45 74.501 76.95 75.001 76.45 75.001 L 76.08025 75.001 C 75.58025 75.001 75.08025 74.501 75.08025 74.001 Z "
                                                                            fill="rgba(0,102,102,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="0"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 75.08025 74.001 L 75.08025 21.626 C 75.08025 21.126 75.58025 20.626 76.08025 20.626 L 76.45 20.626 C 76.95 20.626 77.45 21.126 77.45 21.626 L 77.45 74.001 C 77.45 74.501 76.95 75.001 76.45 75.001 L 76.08025 75.001 C 75.58025 75.001 75.08025 74.501 75.08025 74.001 Z "
                                                                            pathFrom="M 75.08025 75.001 L 75.08025 75.001 L 77.45 75.001 L 77.45 75.001 L 77.45 75.001 L 77.45 75.001 L 77.45 75.001 L 75.08025 75.001 Z"
                                                                            cy="20.625" cx="78.45" j="7"
                                                                            val="87" barHeight="54.375"
                                                                            barWidth="4.36975"></path>
                                                                        <path id="SvgjsPath1438"
                                                                            d="M 86.43025 74.001 L 86.43025 22.876 C 86.43025 22.376 86.93025 21.876 87.43025 21.876 L 87.8 21.876 C 88.3 21.876 88.8 22.376 88.8 22.876 L 88.8 74.001 C 88.8 74.501 88.3 75.001 87.8 75.001 L 87.43025 75.001 C 86.93025 75.001 86.43025 74.501 86.43025 74.001 Z "
                                                                            fill="rgba(0,102,102,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="0"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 86.43025 74.001 L 86.43025 22.876 C 86.43025 22.376 86.93025 21.876 87.43025 21.876 L 87.8 21.876 C 88.3 21.876 88.8 22.376 88.8 22.876 L 88.8 74.001 C 88.8 74.501 88.3 75.001 87.8 75.001 L 87.43025 75.001 C 86.93025 75.001 86.43025 74.501 86.43025 74.001 Z "
                                                                            pathFrom="M 86.43025 75.001 L 86.43025 75.001 L 88.8 75.001 L 88.8 75.001 L 88.8 75.001 L 88.8 75.001 L 88.8 75.001 L 86.43025 75.001 Z"
                                                                            cy="21.875" cx="89.8" j="8"
                                                                            val="85" barHeight="53.125"
                                                                            barWidth="4.36975"></path>
                                                                        <path id="SvgjsPath1440"
                                                                            d="M 97.78025 74.001 L 97.78025 13.501 C 97.78025 13.001 98.28025 12.501 98.78025 12.501 L 99.14999999999999 12.501 C 99.64999999999999 12.501 100.14999999999999 13.001 100.14999999999999 13.501 L 100.14999999999999 74.001 C 100.14999999999999 74.501 99.64999999999999 75.001 99.14999999999999 75.001 L 98.78025 75.001 C 98.28025 75.001 97.78025 74.501 97.78025 74.001 Z "
                                                                            fill="rgba(0,102,102,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="0"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 97.78025 74.001 L 97.78025 13.501 C 97.78025 13.001 98.28025 12.501 98.78025 12.501 L 99.14999999999999 12.501 C 99.64999999999999 12.501 100.14999999999999 13.001 100.14999999999999 13.501 L 100.14999999999999 74.001 C 100.14999999999999 74.501 99.64999999999999 75.001 99.14999999999999 75.001 L 98.78025 75.001 C 98.28025 75.001 97.78025 74.501 97.78025 74.001 Z "
                                                                            pathFrom="M 97.78025 75.001 L 97.78025 75.001 L 100.14999999999999 75.001 L 100.14999999999999 75.001 L 100.14999999999999 75.001 L 100.14999999999999 75.001 L 100.14999999999999 75.001 L 97.78025 75.001 Z"
                                                                            cy="12.5" cx="101.14999999999999" j="9"
                                                                            val="100" barHeight="62.5"
                                                                            barWidth="4.36975"></path>
                                                                        <path id="SvgjsPath1442"
                                                                            d="M 109.13025 74.001 L 109.13025 13.501 C 109.13025 13.001 109.63025 12.501 110.13025 12.501 L 110.5 12.501 C 111 12.501 111.5 13.001 111.5 13.501 L 111.5 74.001 C 111.5 74.501 111 75.001 110.5 75.001 L 110.13025 75.001 C 109.63025 75.001 109.13025 74.501 109.13025 74.001 Z "
                                                                            fill="rgba(0,102,102,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="0"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 109.13025 74.001 L 109.13025 13.501 C 109.13025 13.001 109.63025 12.501 110.13025 12.501 L 110.5 12.501 C 111 12.501 111.5 13.001 111.5 13.501 L 111.5 74.001 C 111.5 74.501 111 75.001 110.5 75.001 L 110.13025 75.001 C 109.63025 75.001 109.13025 74.501 109.13025 74.001 Z "
                                                                            pathFrom="M 109.13025 75.001 L 109.13025 75.001 L 111.5 75.001 L 111.5 75.001 L 111.5 75.001 L 111.5 75.001 L 111.5 75.001 L 109.13025 75.001 Z"
                                                                            cy="12.5" cx="112.5" j="10"
                                                                            val="100" barHeight="62.5"
                                                                            barWidth="4.36975"></path>
                                                                        <path id="SvgjsPath1444"
                                                                            d="M 120.48025 74.001 L 120.48025 29.126 C 120.48025 28.626 120.98025 28.126 121.48025 28.126 L 121.85 28.126 C 122.35 28.126 122.85 28.626 122.85 29.126 L 122.85 74.001 C 122.85 74.501 122.35 75.001 121.85 75.001 L 121.48025 75.001 C 120.98025 75.001 120.48025 74.501 120.48025 74.001 Z "
                                                                            fill="rgba(0,102,102,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="0"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 120.48025 74.001 L 120.48025 29.126 C 120.48025 28.626 120.98025 28.126 121.48025 28.126 L 121.85 28.126 C 122.35 28.126 122.85 28.626 122.85 29.126 L 122.85 74.001 C 122.85 74.501 122.35 75.001 121.85 75.001 L 121.48025 75.001 C 120.98025 75.001 120.48025 74.501 120.48025 74.001 Z "
                                                                            pathFrom="M 120.48025 75.001 L 120.48025 75.001 L 122.85 75.001 L 122.85 75.001 L 122.85 75.001 L 122.85 75.001 L 122.85 75.001 L 120.48025 75.001 Z"
                                                                            cy="28.125" cx="123.85" j="11"
                                                                            val="75" barHeight="46.875"
                                                                            barWidth="4.36975"></path>
                                                                        <g id="SvgjsG1420"
                                                                            class="apexcharts-bar-goals-markers"
                                                                            style="pointer-events: none">
                                                                            <g id="SvgjsG1421"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1423"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1425"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1427"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1429"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1431"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1433"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1435"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1437"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1439"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1441"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1443"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g id="SvgjsG1445" class="apexcharts-series"
                                                                        rel="2" seriesName="Revenue"
                                                                        data:realIndex="1">
                                                                        <path id="SvgjsPath1449"
                                                                            d="M 0 74.001 L 0 51.001 C 0 50.501 0.5 50.001 1 50.001 L 1.3697499999999998 50.001 C 1.8697499999999998 50.001 2.36975 50.501 2.36975 51.001 L 2.36975 74.001 C 2.36975 74.501 1.8697499999999998 75.001 1.3697499999999998 75.001 L 1 75.001 C 0.5 75.001 0 74.501 0 74.001 Z "
                                                                            fill="rgba(230,233,235,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="1"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 0 74.001 L 0 51.001 C 0 50.501 0.5 50.001 1 50.001 L 1.3697499999999998 50.001 C 1.8697499999999998 50.001 2.36975 50.501 2.36975 51.001 L 2.36975 74.001 C 2.36975 74.501 1.8697499999999998 75.001 1.3697499999999998 75.001 L 1 75.001 C 0.5 75.001 0 74.501 0 74.001 Z "
                                                                            pathFrom="M 0 75.001 L 0 75.001 L 2.36975 75.001 L 2.36975 75.001 L 2.36975 75.001 L 2.36975 75.001 L 2.36975 75.001 L 0 75.001 Z"
                                                                            cy="50" cx="3.36975" j="0"
                                                                            val="40" barHeight="25"
                                                                            barWidth="4.36975">
                                                                        </path>
                                                                        <path id="SvgjsPath1451"
                                                                            d="M 11.35 74.001 L 11.35 41.626 C 11.35 41.126 11.85 40.626 12.35 40.626 L 12.71975 40.626 C 13.21975 40.626 13.71975 41.126 13.71975 41.626 L 13.71975 74.001 C 13.71975 74.501 13.21975 75.001 12.71975 75.001 L 12.35 75.001 C 11.85 75.001 11.35 74.501 11.35 74.001 Z "
                                                                            fill="rgba(230,233,235,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="1"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 11.35 74.001 L 11.35 41.626 C 11.35 41.126 11.85 40.626 12.35 40.626 L 12.71975 40.626 C 13.21975 40.626 13.71975 41.126 13.71975 41.626 L 13.71975 74.001 C 13.71975 74.501 13.21975 75.001 12.71975 75.001 L 12.35 75.001 C 11.85 75.001 11.35 74.501 11.35 74.001 Z "
                                                                            pathFrom="M 11.35 75.001 L 11.35 75.001 L 13.71975 75.001 L 13.71975 75.001 L 13.71975 75.001 L 13.71975 75.001 L 13.71975 75.001 L 11.35 75.001 Z"
                                                                            cy="40.625" cx="14.71975" j="1"
                                                                            val="55" barHeight="34.375"
                                                                            barWidth="4.36975"></path>
                                                                        <path id="SvgjsPath1453"
                                                                            d="M 22.7 74.001 L 22.7 54.126 C 22.7 53.626 23.2 53.126 23.7 53.126 L 24.06975 53.126 C 24.56975 53.126 25.06975 53.626 25.06975 54.126 L 25.06975 74.001 C 25.06975 74.501 24.56975 75.001 24.06975 75.001 L 23.7 75.001 C 23.2 75.001 22.7 74.501 22.7 74.001 Z "
                                                                            fill="rgba(230,233,235,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="1"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 22.7 74.001 L 22.7 54.126 C 22.7 53.626 23.2 53.126 23.7 53.126 L 24.06975 53.126 C 24.56975 53.126 25.06975 53.626 25.06975 54.126 L 25.06975 74.001 C 25.06975 74.501 24.56975 75.001 24.06975 75.001 L 23.7 75.001 C 23.2 75.001 22.7 74.501 22.7 74.001 Z "
                                                                            pathFrom="M 22.7 75.001 L 22.7 75.001 L 25.06975 75.001 L 25.06975 75.001 L 25.06975 75.001 L 25.06975 75.001 L 25.06975 75.001 L 22.7 75.001 Z"
                                                                            cy="53.125" cx="26.06975" j="2"
                                                                            val="35" barHeight="21.875"
                                                                            barWidth="4.36975"></path>
                                                                        <path id="SvgjsPath1455"
                                                                            d="M 34.05 74.001 L 34.05 44.751 C 34.05 44.251 34.55 43.751 35.05 43.751 L 35.41974999999999 43.751 C 35.91974999999999 43.751 36.41974999999999 44.251 36.41974999999999 44.751 L 36.41974999999999 74.001 C 36.41974999999999 74.501 35.91974999999999 75.001 35.41974999999999 75.001 L 35.05 75.001 C 34.55 75.001 34.05 74.501 34.05 74.001 Z "
                                                                            fill="rgba(230,233,235,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="1"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 34.05 74.001 L 34.05 44.751 C 34.05 44.251 34.55 43.751 35.05 43.751 L 35.41974999999999 43.751 C 35.91974999999999 43.751 36.41974999999999 44.251 36.41974999999999 44.751 L 36.41974999999999 74.001 C 36.41974999999999 74.501 35.91974999999999 75.001 35.41974999999999 75.001 L 35.05 75.001 C 34.55 75.001 34.05 74.501 34.05 74.001 Z "
                                                                            pathFrom="M 34.05 75.001 L 34.05 75.001 L 36.41974999999999 75.001 L 36.41974999999999 75.001 L 36.41974999999999 75.001 L 36.41974999999999 75.001 L 36.41974999999999 75.001 L 34.05 75.001 Z"
                                                                            cy="43.75" cx="37.41974999999999" j="3"
                                                                            val="50" barHeight="31.25"
                                                                            barWidth="4.36975"></path>
                                                                        <path id="SvgjsPath1457"
                                                                            d="M 45.39999999999999 74.001 L 45.39999999999999 37.876 C 45.39999999999999 37.376 45.89999999999999 36.876 46.39999999999999 36.876 L 46.76974999999999 36.876 C 47.26974999999999 36.876 47.76974999999999 37.376 47.76974999999999 37.876 L 47.76974999999999 74.001 C 47.76974999999999 74.501 47.26974999999999 75.001 46.76974999999999 75.001 L 46.39999999999999 75.001 C 45.89999999999999 75.001 45.39999999999999 74.501 45.39999999999999 74.001 Z "
                                                                            fill="rgba(230,233,235,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="1"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 45.39999999999999 74.001 L 45.39999999999999 37.876 C 45.39999999999999 37.376 45.89999999999999 36.876 46.39999999999999 36.876 L 46.76974999999999 36.876 C 47.26974999999999 36.876 47.76974999999999 37.376 47.76974999999999 37.876 L 47.76974999999999 74.001 C 47.76974999999999 74.501 47.26974999999999 75.001 46.76974999999999 75.001 L 46.39999999999999 75.001 C 45.89999999999999 75.001 45.39999999999999 74.501 45.39999999999999 74.001 Z "
                                                                            pathFrom="M 45.39999999999999 75.001 L 45.39999999999999 75.001 L 47.76974999999999 75.001 L 47.76974999999999 75.001 L 47.76974999999999 75.001 L 47.76974999999999 75.001 L 47.76974999999999 75.001 L 45.39999999999999 75.001 Z"
                                                                            cy="36.875" cx="48.769749999999995" j="4"
                                                                            val="61" barHeight="38.125"
                                                                            barWidth="4.36975"></path>
                                                                        <path id="SvgjsPath1459"
                                                                            d="M 56.75 74.001 L 56.75 47.876 C 56.75 47.376 57.25 46.876 57.75 46.876 L 58.119749999999996 46.876 C 58.619749999999996 46.876 59.119749999999996 47.376 59.119749999999996 47.876 L 59.119749999999996 74.001 C 59.119749999999996 74.501 58.619749999999996 75.001 58.119749999999996 75.001 L 57.75 75.001 C 57.25 75.001 56.75 74.501 56.75 74.001 Z "
                                                                            fill="rgba(230,233,235,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="1"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 56.75 74.001 L 56.75 47.876 C 56.75 47.376 57.25 46.876 57.75 46.876 L 58.119749999999996 46.876 C 58.619749999999996 46.876 59.119749999999996 47.376 59.119749999999996 47.876 L 59.119749999999996 74.001 C 59.119749999999996 74.501 58.619749999999996 75.001 58.119749999999996 75.001 L 57.75 75.001 C 57.25 75.001 56.75 74.501 56.75 74.001 Z "
                                                                            pathFrom="M 56.75 75.001 L 56.75 75.001 L 59.119749999999996 75.001 L 59.119749999999996 75.001 L 59.119749999999996 75.001 L 59.119749999999996 75.001 L 59.119749999999996 75.001 L 56.75 75.001 Z"
                                                                            cy="46.875" cx="60.11975" j="5"
                                                                            val="45" barHeight="28.125"
                                                                            barWidth="4.36975"></path>
                                                                        <path id="SvgjsPath1461"
                                                                            d="M 68.1 74.001 L 68.1 44.751 C 68.1 44.251 68.6 43.751 69.1 43.751 L 69.46974999999999 43.751 C 69.96974999999999 43.751 70.46974999999999 44.251 70.46974999999999 44.751 L 70.46974999999999 74.001 C 70.46974999999999 74.501 69.96974999999999 75.001 69.46974999999999 75.001 L 69.1 75.001 C 68.6 75.001 68.1 74.501 68.1 74.001 Z "
                                                                            fill="rgba(230,233,235,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="1"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 68.1 74.001 L 68.1 44.751 C 68.1 44.251 68.6 43.751 69.1 43.751 L 69.46974999999999 43.751 C 69.96974999999999 43.751 70.46974999999999 44.251 70.46974999999999 44.751 L 70.46974999999999 74.001 C 70.46974999999999 74.501 69.96974999999999 75.001 69.46974999999999 75.001 L 69.1 75.001 C 68.6 75.001 68.1 74.501 68.1 74.001 Z "
                                                                            pathFrom="M 68.1 75.001 L 68.1 75.001 L 70.46974999999999 75.001 L 70.46974999999999 75.001 L 70.46974999999999 75.001 L 70.46974999999999 75.001 L 70.46974999999999 75.001 L 68.1 75.001 Z"
                                                                            cy="43.75" cx="71.46975" j="6"
                                                                            val="50" barHeight="31.25"
                                                                            barWidth="4.36975"></path>
                                                                        <path id="SvgjsPath1463"
                                                                            d="M 79.45 74.001 L 79.45 63.501 C 79.45 63.001 79.95 62.501 80.45 62.501 L 80.81975 62.501 C 81.31975 62.501 81.81975 63.001 81.81975 63.501 L 81.81975 74.001 C 81.81975 74.501 81.31975 75.001 80.81975 75.001 L 80.45 75.001 C 79.95 75.001 79.45 74.501 79.45 74.001 Z "
                                                                            fill="rgba(230,233,235,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="1"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 79.45 74.001 L 79.45 63.501 C 79.45 63.001 79.95 62.501 80.45 62.501 L 80.81975 62.501 C 81.31975 62.501 81.81975 63.001 81.81975 63.501 L 81.81975 74.001 C 81.81975 74.501 81.31975 75.001 80.81975 75.001 L 80.45 75.001 C 79.95 75.001 79.45 74.501 79.45 74.001 Z "
                                                                            pathFrom="M 79.45 75.001 L 79.45 75.001 L 81.81975 75.001 L 81.81975 75.001 L 81.81975 75.001 L 81.81975 75.001 L 81.81975 75.001 L 79.45 75.001 Z"
                                                                            cy="62.5" cx="82.81975" j="7"
                                                                            val="20" barHeight="12.5"
                                                                            barWidth="4.36975"></path>
                                                                        <path id="SvgjsPath1465"
                                                                            d="M 90.8 74.001 L 90.8 44.751 C 90.8 44.251 91.3 43.751 91.8 43.751 L 92.16975 43.751 C 92.66975 43.751 93.16975 44.251 93.16975 44.751 L 93.16975 74.001 C 93.16975 74.501 92.66975 75.001 92.16975 75.001 L 91.8 75.001 C 91.3 75.001 90.8 74.501 90.8 74.001 Z "
                                                                            fill="rgba(230,233,235,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="1"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 90.8 74.001 L 90.8 44.751 C 90.8 44.251 91.3 43.751 91.8 43.751 L 92.16975 43.751 C 92.66975 43.751 93.16975 44.251 93.16975 44.751 L 93.16975 74.001 C 93.16975 74.501 92.66975 75.001 92.16975 75.001 L 91.8 75.001 C 91.3 75.001 90.8 74.501 90.8 74.001 Z "
                                                                            pathFrom="M 90.8 75.001 L 90.8 75.001 L 93.16975 75.001 L 93.16975 75.001 L 93.16975 75.001 L 93.16975 75.001 L 93.16975 75.001 L 90.8 75.001 Z"
                                                                            cy="43.75" cx="94.16975" j="8"
                                                                            val="50" barHeight="31.25"
                                                                            barWidth="4.36975"></path>
                                                                        <path id="SvgjsPath1467"
                                                                            d="M 102.14999999999999 74.001 L 102.14999999999999 22.876 C 102.14999999999999 22.376 102.64999999999999 21.876 103.14999999999999 21.876 L 103.51974999999999 21.876 C 104.01974999999999 21.876 104.51974999999999 22.376 104.51974999999999 22.876 L 104.51974999999999 74.001 C 104.51974999999999 74.501 104.01974999999999 75.001 103.51974999999999 75.001 L 103.14999999999999 75.001 C 102.64999999999999 75.001 102.14999999999999 74.501 102.14999999999999 74.001 Z "
                                                                            fill="rgba(230,233,235,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="1"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 102.14999999999999 74.001 L 102.14999999999999 22.876 C 102.14999999999999 22.376 102.64999999999999 21.876 103.14999999999999 21.876 L 103.51974999999999 21.876 C 104.01974999999999 21.876 104.51974999999999 22.376 104.51974999999999 22.876 L 104.51974999999999 74.001 C 104.51974999999999 74.501 104.01974999999999 75.001 103.51974999999999 75.001 L 103.14999999999999 75.001 C 102.64999999999999 75.001 102.14999999999999 74.501 102.14999999999999 74.001 Z "
                                                                            pathFrom="M 102.14999999999999 75.001 L 102.14999999999999 75.001 L 104.51974999999999 75.001 L 104.51974999999999 75.001 L 104.51974999999999 75.001 L 104.51974999999999 75.001 L 104.51974999999999 75.001 L 102.14999999999999 75.001 Z"
                                                                            cy="21.875" cx="105.51974999999999" j="9"
                                                                            val="85" barHeight="53.125"
                                                                            barWidth="4.36975"></path>
                                                                        <path id="SvgjsPath1469"
                                                                            d="M 113.5 74.001 L 113.5 44.751 C 113.5 44.251 114 43.751 114.5 43.751 L 114.86975 43.751 C 115.36975 43.751 115.86975 44.251 115.86975 44.751 L 115.86975 74.001 C 115.86975 74.501 115.36975 75.001 114.86975 75.001 L 114.5 75.001 C 114 75.001 113.5 74.501 113.5 74.001 Z "
                                                                            fill="rgba(230,233,235,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="1"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 113.5 74.001 L 113.5 44.751 C 113.5 44.251 114 43.751 114.5 43.751 L 114.86975 43.751 C 115.36975 43.751 115.86975 44.251 115.86975 44.751 L 115.86975 74.001 C 115.86975 74.501 115.36975 75.001 114.86975 75.001 L 114.5 75.001 C 114 75.001 113.5 74.501 113.5 74.001 Z "
                                                                            pathFrom="M 113.5 75.001 L 113.5 75.001 L 115.86975 75.001 L 115.86975 75.001 L 115.86975 75.001 L 115.86975 75.001 L 115.86975 75.001 L 113.5 75.001 Z"
                                                                            cy="43.75" cx="116.86975000000001" j="10"
                                                                            val="50" barHeight="31.25"
                                                                            barWidth="4.36975"></path>
                                                                        <path id="SvgjsPath1471"
                                                                            d="M 124.85 74.001 L 124.85 13.501 C 124.85 13.001 125.35 12.501 125.85 12.501 L 126.21975 12.501 C 126.71975 12.501 127.21975 13.001 127.21975 13.501 L 127.21975 74.001 C 127.21975 74.501 126.71975 75.001 126.21975 75.001 L 125.85 75.001 C 125.35 75.001 124.85 74.501 124.85 74.001 Z "
                                                                            fill="rgba(230,233,235,1)" fill-opacity="1"
                                                                            stroke="transparent" stroke-opacity="1"
                                                                            stroke-linecap="round" stroke-width="2"
                                                                            stroke-dasharray="0"
                                                                            class="apexcharts-bar-area" index="1"
                                                                            clip-path="url(#gridRectMaskw1evsj28)"
                                                                            pathTo="M 124.85 74.001 L 124.85 13.501 C 124.85 13.001 125.35 12.501 125.85 12.501 L 126.21975 12.501 C 126.71975 12.501 127.21975 13.001 127.21975 13.501 L 127.21975 74.001 C 127.21975 74.501 126.71975 75.001 126.21975 75.001 L 125.85 75.001 C 125.35 75.001 124.85 74.501 124.85 74.001 Z "
                                                                            pathFrom="M 124.85 75.001 L 124.85 75.001 L 127.21975 75.001 L 127.21975 75.001 L 127.21975 75.001 L 127.21975 75.001 L 127.21975 75.001 L 124.85 75.001 Z"
                                                                            cy="12.5" cx="128.21975" j="11"
                                                                            val="100" barHeight="62.5"
                                                                            barWidth="4.36975"></path>
                                                                        <g id="SvgjsG1447"
                                                                            class="apexcharts-bar-goals-markers"
                                                                            style="pointer-events: none">
                                                                            <g id="SvgjsG1448"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1450"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1452"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1454"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1456"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1458"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1460"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1462"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1464"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1466"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1468"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                            <g id="SvgjsG1470"
                                                                                className="apexcharts-bar-goals-groups">
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g id="SvgjsG1419" class="apexcharts-datalabels"
                                                                        data:realIndex="0"></g>
                                                                    <g id="SvgjsG1446" class="apexcharts-datalabels"
                                                                        data:realIndex="1"></g>
                                                                </g>
                                                                <g id="SvgjsG1475" class="apexcharts-grid-borders"
                                                                    style="display: none;">
                                                                    <line id="SvgjsLine1476" x1="-10.075"
                                                                        y1="0" x2="134.92499999999998"
                                                                        y2="0" stroke="#e0e0e0"
                                                                        stroke-dasharray="0" stroke-linecap="butt"
                                                                        class="apexcharts-gridline">
                                                                    </line>
                                                                    <line id="SvgjsLine1480" x1="-10.075"
                                                                        y1="75" x2="134.92499999999998"
                                                                        y2="75" stroke="#e0e0e0"
                                                                        stroke-dasharray="0" stroke-linecap="butt"
                                                                        class="apexcharts-gridline">
                                                                    </line>
                                                                    <line id="SvgjsLine1491" x1="-10.075"
                                                                        y1="76" x2="134.92499999999998"
                                                                        y2="76" stroke="#e0e0e0"
                                                                        stroke-dasharray="0" stroke-width="1"
                                                                        stroke-linecap="butt"></line>
                                                                </g>
                                                                <line id="SvgjsLine1493" x1="-10.075" y1="0"
                                                                    x2="134.92499999999998" y2="0"
                                                                    stroke="#b6b6b6" stroke-dasharray="0"
                                                                    stroke-width="1" stroke-linecap="butt"
                                                                    class="apexcharts-ycrosshairs">
                                                                </line>
                                                                <line id="SvgjsLine1494" x1="-10.075" y1="0"
                                                                    x2="134.92499999999998" y2="0"
                                                                    stroke-dasharray="0" stroke-width="0"
                                                                    stroke-linecap="butt"
                                                                    class="apexcharts-ycrosshairs-hidden"></line>
                                                                <g id="SvgjsG1495" class="apexcharts-yaxis-annotations">
                                                                </g>
                                                                <g id="SvgjsG1496" class="apexcharts-xaxis-annotations">
                                                                </g>
                                                                <g id="SvgjsG1497" class="apexcharts-point-annotations">
                                                                </g>
                                                            </g>
                                                            <g id="SvgjsG1492" class="apexcharts-yaxis" rel="0"
                                                                transform="translate(-18, 0)"></g>
                                                            <g id="SvgjsG1408" class="apexcharts-annotations"></g>
                                                        </svg>
                                                        <div class="apexcharts-legend" style="max-height: 60px;"></div>
                                                        <div class="apexcharts-tooltip apexcharts-theme-light">
                                                            <div class="apexcharts-tooltip-title"
                                                                style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                            </div>
                                                            <div class="apexcharts-tooltip-series-group"
                                                                style="order: 1;">
                                                                <span class="apexcharts-tooltip-marker"
                                                                    style="background-color: rgb(0, 102, 102);"></span>
                                                                <div class="apexcharts-tooltip-text"
                                                                    style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                                    <div class="apexcharts-tooltip-y-group"><span
                                                                            class="apexcharts-tooltip-text-y-label"></span><span
                                                                            class="apexcharts-tooltip-text-y-value"></span>
                                                                    </div>
                                                                    <div class="apexcharts-tooltip-goals-group"><span
                                                                            class="apexcharts-tooltip-text-goals-label"></span><span
                                                                            class="apexcharts-tooltip-text-goals-value"></span>
                                                                    </div>
                                                                    <div class="apexcharts-tooltip-z-group"><span
                                                                            class="apexcharts-tooltip-text-z-label"></span><span
                                                                            class="apexcharts-tooltip-text-z-value"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="apexcharts-tooltip-series-group"
                                                                style="order: 2;">
                                                                <span class="apexcharts-tooltip-marker"
                                                                    style="background-color: rgb(230, 233, 235);"></span>
                                                                <div class="apexcharts-tooltip-text"
                                                                    style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                                    <div class="apexcharts-tooltip-y-group"><span
                                                                            class="apexcharts-tooltip-text-y-label"></span><span
                                                                            class="apexcharts-tooltip-text-y-value"></span>
                                                                    </div>
                                                                    <div class="apexcharts-tooltip-goals-group"><span
                                                                            class="apexcharts-tooltip-text-goals-label"></span><span
                                                                            class="apexcharts-tooltip-text-goals-value"></span>
                                                                    </div>
                                                                    <div class="apexcharts-tooltip-z-group"><span
                                                                            class="apexcharts-tooltip-text-z-label"></span><span
                                                                            class="apexcharts-tooltip-text-z-value"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                                            <div class="apexcharts-yaxistooltip-text"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="total-revenue mb-2"> <span>Total Order </span><a
                                                href="index.html">View
                                                Report</a></div>
                                        <h3 class="f-w-600">35,452</h3>
                                        <div class="total-chart">
                                            <div class="data-grow d-flex gap-2"> <svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="feather feather-arrow-down-left font-secondary">
                                                    <line x1="17" y1="7" x2="7" y2="17">
                                                    </line>
                                                    <polyline points="17 17 7 17 7 7"></polyline>
                                                </svg><span class="f-w-500">15.00% from last week</span></div>
                                            <div class="total-order">
                                                <div id="totalOrder" style="min-height: 135px;">
                                                    <div id="apexchartsxud5klq4f"
                                                        class="apexcharts-canvas apexchartsxud5klq4f apexcharts-theme-light"
                                                        style="width: 203px; height: 120px;"><svg id="SvgjsSvg1523"
                                                            width="203" height="120"
                                                            xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                                            xmlns:svgjs="http://svgjs.dev"
                                                            class="apexcharts-svg apexcharts-zoomable"
                                                            xmlns:data="ApexChartsNS" transform="translate(0, -17)"
                                                            style="background: transparent;">
                                                            <g id="SvgjsG1525"
                                                                class="apexcharts-inner apexcharts-graphical"
                                                                transform="translate(12, 30)">
                                                                <defs id="SvgjsDefs1524">
                                                                    <clipPath id="gridRectMaskxud5klq4f">
                                                                        <rect id="SvgjsRect1530" width="186"
                                                                            height="76" x="-2.5" y="-0.5"
                                                                            rx="0" ry="0" opacity="1"
                                                                            stroke-width="0" stroke="none"
                                                                            stroke-dasharray="0" fill="#fff"></rect>
                                                                    </clipPath>
                                                                    <clipPath id="forecastMaskxud5klq4f"></clipPath>
                                                                    <clipPath id="nonForecastMaskxud5klq4f"></clipPath>
                                                                    <clipPath id="gridRectMarkerMaskxud5klq4f">
                                                                        <rect id="SvgjsRect1531" width="185"
                                                                            height="79" x="-2" y="-2" rx="0"
                                                                            ry="0" opacity="1"
                                                                            stroke-width="0" stroke="none"
                                                                            stroke-dasharray="0" fill="#fff"></rect>
                                                                    </clipPath>
                                                                    <linearGradient id="SvgjsLinearGradient1536"
                                                                        x1="0" y1="0" x2="0"
                                                                        y2="1">
                                                                        <stop id="SvgjsStop1537" stop-opacity="0.5"
                                                                            stop-color="rgba(0,102,102,0.5)"
                                                                            offset="0">
                                                                        </stop>
                                                                        <stop id="SvgjsStop1538" stop-opacity="0"
                                                                            stop-color="rgba(51,133,133,0)"
                                                                            offset="1">
                                                                        </stop>
                                                                        <stop id="SvgjsStop1539" stop-opacity="0"
                                                                            stop-color="rgba(51,133,133,0)"
                                                                            offset="1">
                                                                        </stop>
                                                                    </linearGradient>
                                                                    <linearGradient id="SvgjsLinearGradient1545"
                                                                        x1="0" y1="0" x2="0"
                                                                        y2="1">
                                                                        <stop id="SvgjsStop1546" stop-opacity="0.5"
                                                                            stop-color="rgba(0,102,102,0.5)"
                                                                            offset="0">
                                                                        </stop>
                                                                        <stop id="SvgjsStop1547" stop-opacity="0"
                                                                            stop-color="rgba(51,133,133,0)"
                                                                            offset="1">
                                                                        </stop>
                                                                        <stop id="SvgjsStop1548" stop-opacity="0"
                                                                            stop-color="rgba(51,133,133,0)"
                                                                            offset="1">
                                                                        </stop>
                                                                    </linearGradient>
                                                                </defs>
                                                                <line id="SvgjsLine1529" x1="0" y1="0"
                                                                    x2="0" y2="75" stroke="#b6b6b6"
                                                                    stroke-dasharray="3" stroke-linecap="butt"
                                                                    class="apexcharts-xcrosshairs" x="0" y="0"
                                                                    width="1" height="75" fill="#b1b9c4"
                                                                    filter="none" fill-opacity="0.9" stroke-width="1">
                                                                </line>
                                                                <g id="SvgjsG1563" class="apexcharts-xaxis"
                                                                    transform="translate(0, 0)">
                                                                    <g id="SvgjsG1564" class="apexcharts-xaxis-texts-g"
                                                                        transform="translate(0, -4)"></g>
                                                                </g>
                                                                <g id="SvgjsG1551" class="apexcharts-grid">
                                                                    <g id="SvgjsG1552"
                                                                        class="apexcharts-gridlines-horizontal"
                                                                        style="display: none;">
                                                                        <line id="SvgjsLine1556" x1="0"
                                                                            y1="15" x2="181" y2="15"
                                                                            stroke="#e0e0e0" stroke-dasharray="0"
                                                                            stroke-linecap="butt"
                                                                            class="apexcharts-gridline">
                                                                        </line>
                                                                        <line id="SvgjsLine1557" x1="0"
                                                                            y1="30" x2="181" y2="30"
                                                                            stroke="#e0e0e0" stroke-dasharray="0"
                                                                            stroke-linecap="butt"
                                                                            class="apexcharts-gridline">
                                                                        </line>
                                                                        <line id="SvgjsLine1558" x1="0"
                                                                            y1="45" x2="181" y2="45"
                                                                            stroke="#e0e0e0" stroke-dasharray="0"
                                                                            stroke-linecap="butt"
                                                                            class="apexcharts-gridline">
                                                                        </line>
                                                                        <line id="SvgjsLine1559" x1="0"
                                                                            y1="60" x2="181"
                                                                            y2="60" stroke="#e0e0e0"
                                                                            stroke-dasharray="0" stroke-linecap="butt"
                                                                            class="apexcharts-gridline">
                                                                        </line>
                                                                    </g>
                                                                    <g id="SvgjsG1553"
                                                                        class="apexcharts-gridlines-vertical"
                                                                        style="display: none;"></g>
                                                                    <line id="SvgjsLine1562" x1="0"
                                                                        y1="75" x2="181" y2="75"
                                                                        stroke="transparent" stroke-dasharray="0"
                                                                        stroke-linecap="butt"></line>
                                                                    <line id="SvgjsLine1561" x1="0"
                                                                        y1="1" x2="0" y2="75"
                                                                        stroke="transparent" stroke-dasharray="0"
                                                                        stroke-linecap="butt"></line>
                                                                </g>
                                                                <g id="SvgjsG1532"
                                                                    class="apexcharts-area-series apexcharts-plot-series">
                                                                    <g id="SvgjsG1533" class="apexcharts-series"
                                                                        seriesName="sale-1" data:longestSeries="true"
                                                                        rel="1" data:realIndex="0">
                                                                        <path id="SvgjsPath1540"
                                                                            d="M 0 75 L 0 60C 9.049999999999999 60 16.807142857142857 37.5 25.857142857142858 37.5C 34.90714285714286 37.5 42.66428571428572 5.625 51.714285714285715 5.625C 60.76428571428571 5.625 68.52142857142857 9.375 77.57142857142857 9.375C 86.62142857142857 9.375 94.37857142857143 30 103.42857142857143 30C 112.47857142857143 30 120.23571428571428 7.5 129.28571428571428 7.5C 138.3357142857143 7.5 146.09285714285713 24.375 155.14285714285714 24.375C 164.19285714285715 24.375 171.95 33.75 181 33.75C 181 33.75 181 33.75 181 75M 181 33.75z"
                                                                            fill="url(#SvgjsLinearGradient1536)"
                                                                            fill-opacity="1" stroke-opacity="1"
                                                                            stroke-linecap="butt" stroke-width="0"
                                                                            stroke-dasharray="0" class="apexcharts-area"
                                                                            index="0"
                                                                            clip-path="url(#gridRectMaskxud5klq4f)"
                                                                            pathTo="M 0 75 L 0 60C 9.049999999999999 60 16.807142857142857 37.5 25.857142857142858 37.5C 34.90714285714286 37.5 42.66428571428572 5.625 51.714285714285715 5.625C 60.76428571428571 5.625 68.52142857142857 9.375 77.57142857142857 9.375C 86.62142857142857 9.375 94.37857142857143 30 103.42857142857143 30C 112.47857142857143 30 120.23571428571428 7.5 129.28571428571428 7.5C 138.3357142857143 7.5 146.09285714285713 24.375 155.14285714285714 24.375C 164.19285714285715 24.375 171.95 33.75 181 33.75C 181 33.75 181 33.75 181 75M 181 33.75z"
                                                                            pathFrom="M -1 90 L -1 90 L 25.857142857142858 90 L 51.714285714285715 90 L 77.57142857142857 90 L 103.42857142857143 90 L 129.28571428571428 90 L 155.14285714285714 90 L 181 90">
                                                                        </path>
                                                                        <path id="SvgjsPath1541"
                                                                            d="M 0 60C 9.049999999999999 60 16.807142857142857 37.5 25.857142857142858 37.5C 34.90714285714286 37.5 42.66428571428572 5.625 51.714285714285715 5.625C 60.76428571428571 5.625 68.52142857142857 9.375 77.57142857142857 9.375C 86.62142857142857 9.375 94.37857142857143 30 103.42857142857143 30C 112.47857142857143 30 120.23571428571428 7.5 129.28571428571428 7.5C 138.3357142857143 7.5 146.09285714285713 24.375 155.14285714285714 24.375C 164.19285714285715 24.375 171.95 33.75 181 33.75"
                                                                            fill="none" fill-opacity="1"
                                                                            stroke="#006666" stroke-opacity="1"
                                                                            stroke-linecap="butt" stroke-width="1"
                                                                            stroke-dasharray="0" class="apexcharts-area"
                                                                            index="0"
                                                                            clip-path="url(#gridRectMaskxud5klq4f)"
                                                                            pathTo="M 0 60C 9.049999999999999 60 16.807142857142857 37.5 25.857142857142858 37.5C 34.90714285714286 37.5 42.66428571428572 5.625 51.714285714285715 5.625C 60.76428571428571 5.625 68.52142857142857 9.375 77.57142857142857 9.375C 86.62142857142857 9.375 94.37857142857143 30 103.42857142857143 30C 112.47857142857143 30 120.23571428571428 7.5 129.28571428571428 7.5C 138.3357142857143 7.5 146.09285714285713 24.375 155.14285714285714 24.375C 164.19285714285715 24.375 171.95 33.75 181 33.75"
                                                                            pathFrom="M -1 90 L -1 90 L 25.857142857142858 90 L 51.714285714285715 90 L 77.57142857142857 90 L 103.42857142857143 90 L 129.28571428571428 90 L 155.14285714285714 90 L 181 90"
                                                                            fill-rule="evenodd"></path>
                                                                        <g id="SvgjsG1534"
                                                                            class="apexcharts-series-markers-wrap"
                                                                            data:realIndex="0">
                                                                            <g class="apexcharts-series-markers">
                                                                                <circle id="SvgjsCircle1580" r="0"
                                                                                    cx="0" cy="0"
                                                                                    class="apexcharts-marker wugk9xt7b no-pointer-events"
                                                                                    stroke="#ffffff" fill="#006666"
                                                                                    fill-opacity="1" stroke-width="2"
                                                                                    stroke-opacity="0.9"
                                                                                    default-marker-size="0"></circle>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g id="SvgjsG1542" class="apexcharts-series"
                                                                        seriesName="sale-2" data:longestSeries="true"
                                                                        rel="2" data:realIndex="1">
                                                                        <path id="SvgjsPath1549"
                                                                            d="M 0 75 L 0 48.75C 9.049999999999999 48.75 16.807142857142857 30 25.857142857142858 30C 34.90714285714286 30 42.66428571428572 11.25 51.714285714285715 11.25C 60.76428571428571 11.25 68.52142857142857 52.5 77.57142857142857 52.5C 86.62142857142857 52.5 94.37857142857143 24.375 103.42857142857143 24.375C 112.47857142857143 24.375 120.23571428571428 11.25 129.28571428571428 11.25C 138.3357142857143 11.25 146.09285714285713 43.125 155.14285714285714 43.125C 164.19285714285715 43.125 171.95 5.625 181 5.625C 181 5.625 181 5.625 181 75M 181 5.625z"
                                                                            fill="url(#SvgjsLinearGradient1545)"
                                                                            fill-opacity="1" stroke-opacity="1"
                                                                            stroke-linecap="butt" stroke-width="0"
                                                                            stroke-dasharray="4" class="apexcharts-area"
                                                                            index="1"
                                                                            clip-path="url(#gridRectMaskxud5klq4f)"
                                                                            pathTo="M 0 75 L 0 48.75C 9.049999999999999 48.75 16.807142857142857 30 25.857142857142858 30C 34.90714285714286 30 42.66428571428572 11.25 51.714285714285715 11.25C 60.76428571428571 11.25 68.52142857142857 52.5 77.57142857142857 52.5C 86.62142857142857 52.5 94.37857142857143 24.375 103.42857142857143 24.375C 112.47857142857143 24.375 120.23571428571428 11.25 129.28571428571428 11.25C 138.3357142857143 11.25 146.09285714285713 43.125 155.14285714285714 43.125C 164.19285714285715 43.125 171.95 5.625 181 5.625C 181 5.625 181 5.625 181 75M 181 5.625z"
                                                                            pathFrom="M -1 90 L -1 90 L 25.857142857142858 90 L 51.714285714285715 90 L 77.57142857142857 90 L 103.42857142857143 90 L 129.28571428571428 90 L 155.14285714285714 90 L 181 90">
                                                                        </path>
                                                                        <path id="SvgjsPath1550"
                                                                            d="M 0 48.75C 9.049999999999999 48.75 16.807142857142857 30 25.857142857142858 30C 34.90714285714286 30 42.66428571428572 11.25 51.714285714285715 11.25C 60.76428571428571 11.25 68.52142857142857 52.5 77.57142857142857 52.5C 86.62142857142857 52.5 94.37857142857143 24.375 103.42857142857143 24.375C 112.47857142857143 24.375 120.23571428571428 11.25 129.28571428571428 11.25C 138.3357142857143 11.25 146.09285714285713 43.125 155.14285714285714 43.125C 164.19285714285715 43.125 171.95 5.625 181 5.625"
                                                                            fill="none" fill-opacity="1"
                                                                            stroke="#006666" stroke-opacity="1"
                                                                            stroke-linecap="butt" stroke-width="1"
                                                                            stroke-dasharray="4" class="apexcharts-area"
                                                                            index="1"
                                                                            clip-path="url(#gridRectMaskxud5klq4f)"
                                                                            pathTo="M 0 48.75C 9.049999999999999 48.75 16.807142857142857 30 25.857142857142858 30C 34.90714285714286 30 42.66428571428572 11.25 51.714285714285715 11.25C 60.76428571428571 11.25 68.52142857142857 52.5 77.57142857142857 52.5C 86.62142857142857 52.5 94.37857142857143 24.375 103.42857142857143 24.375C 112.47857142857143 24.375 120.23571428571428 11.25 129.28571428571428 11.25C 138.3357142857143 11.25 146.09285714285713 43.125 155.14285714285714 43.125C 164.19285714285715 43.125 171.95 5.625 181 5.625"
                                                                            pathFrom="M -1 90 L -1 90 L 25.857142857142858 90 L 51.714285714285715 90 L 77.57142857142857 90 L 103.42857142857143 90 L 129.28571428571428 90 L 155.14285714285714 90 L 181 90"
                                                                            fill-rule="evenodd"></path>
                                                                        <g id="SvgjsG1543"
                                                                            class="apexcharts-series-markers-wrap"
                                                                            data:realIndex="1">
                                                                            <g class="apexcharts-series-markers">
                                                                                <circle id="SvgjsCircle1581" r="0"
                                                                                    cx="0" cy="0"
                                                                                    class="apexcharts-marker w20iyr5n1 no-pointer-events"
                                                                                    stroke="#ffffff" fill="#006666"
                                                                                    fill-opacity="1" stroke-width="2"
                                                                                    stroke-opacity="0.9"
                                                                                    default-marker-size="0"></circle>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                    <g id="SvgjsG1535" class="apexcharts-datalabels"
                                                                        data:realIndex="0"></g>
                                                                    <g id="SvgjsG1544" class="apexcharts-datalabels"
                                                                        data:realIndex="1"></g>
                                                                </g>
                                                                <g id="SvgjsG1554" class="apexcharts-grid-borders"
                                                                    style="display: none;">
                                                                    <line id="SvgjsLine1555" x1="0"
                                                                        y1="0" x2="181" y2="0"
                                                                        stroke="#e0e0e0" stroke-dasharray="0"
                                                                        stroke-linecap="butt"
                                                                        class="apexcharts-gridline"></line>
                                                                    <line id="SvgjsLine1560" x1="0"
                                                                        y1="75" x2="181" y2="75"
                                                                        stroke="#e0e0e0" stroke-dasharray="0"
                                                                        stroke-linecap="butt"
                                                                        class="apexcharts-gridline"></line>
                                                                    <line id="SvgjsLine1573" x1="0"
                                                                        y1="76" x2="181" y2="76"
                                                                        stroke="#e0e0e0" stroke-dasharray="0"
                                                                        stroke-width="1" stroke-linecap="butt"></line>
                                                                </g>
                                                                <line id="SvgjsLine1575" x1="0" y1="0"
                                                                    x2="181" y2="0" stroke="#b6b6b6"
                                                                    stroke-dasharray="0" stroke-width="1"
                                                                    stroke-linecap="butt"
                                                                    class="apexcharts-ycrosshairs">
                                                                </line>
                                                                <line id="SvgjsLine1576" x1="0" y1="0"
                                                                    x2="181" y2="0" stroke-dasharray="0"
                                                                    stroke-width="0" stroke-linecap="butt"
                                                                    class="apexcharts-ycrosshairs-hidden"></line>
                                                                <g id="SvgjsG1577" class="apexcharts-yaxis-annotations">
                                                                </g>
                                                                <g id="SvgjsG1578" class="apexcharts-xaxis-annotations">
                                                                </g>
                                                                <g id="SvgjsG1579" class="apexcharts-point-annotations">
                                                                </g>
                                                                <rect id="SvgjsRect1582" width="0" height="0"
                                                                    x="0" y="0" rx="0" ry="0"
                                                                    opacity="1" stroke-width="0" stroke="none"
                                                                    stroke-dasharray="0" fill="#fefefe"
                                                                    class="apexcharts-zoom-rect"></rect>
                                                                <rect id="SvgjsRect1583" width="0" height="0"
                                                                    x="0" y="0" rx="0" ry="0"
                                                                    opacity="1" stroke-width="0" stroke="none"
                                                                    stroke-dasharray="0" fill="#fefefe"
                                                                    class="apexcharts-selection-rect"></rect>
                                                            </g>
                                                            <rect id="SvgjsRect1528" width="0" height="0"
                                                                x="0" y="0" rx="0" ry="0"
                                                                opacity="1" stroke-width="0" stroke="none"
                                                                stroke-dasharray="0" fill="#fefefe"></rect>
                                                            <g id="SvgjsG1574" class="apexcharts-yaxis" rel="0"
                                                                transform="translate(-18, 0)"></g>
                                                            <g id="SvgjsG1526" class="apexcharts-annotations"></g>
                                                        </svg>
                                                        <div class="apexcharts-legend" style="max-height: 60px;"></div>
                                                        <div class="apexcharts-tooltip apexcharts-theme-light">
                                                            <div class="apexcharts-tooltip-title"
                                                                style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                            </div>
                                                            <div class="apexcharts-tooltip-series-group"
                                                                style="order: 1;">
                                                                <span class="apexcharts-tooltip-marker"
                                                                    style="background-color: rgb(0, 102, 102);"></span>
                                                                <div class="apexcharts-tooltip-text"
                                                                    style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                                    <div class="apexcharts-tooltip-y-group"><span
                                                                            class="apexcharts-tooltip-text-y-label"></span><span
                                                                            class="apexcharts-tooltip-text-y-value"></span>
                                                                    </div>
                                                                    <div class="apexcharts-tooltip-goals-group"><span
                                                                            class="apexcharts-tooltip-text-goals-label"></span><span
                                                                            class="apexcharts-tooltip-text-goals-value"></span>
                                                                    </div>
                                                                    <div class="apexcharts-tooltip-z-group"><span
                                                                            class="apexcharts-tooltip-text-z-label"></span><span
                                                                            class="apexcharts-tooltip-text-z-value"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="apexcharts-tooltip-series-group"
                                                                style="order: 2;">
                                                                <span class="apexcharts-tooltip-marker"
                                                                    style="background-color: rgb(0, 102, 102);"></span>
                                                                <div class="apexcharts-tooltip-text"
                                                                    style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                                    <div class="apexcharts-tooltip-y-group"><span
                                                                            class="apexcharts-tooltip-text-y-label"></span><span
                                                                            class="apexcharts-tooltip-text-y-value"></span>
                                                                    </div>
                                                                    <div class="apexcharts-tooltip-goals-group"><span
                                                                            class="apexcharts-tooltip-text-goals-label"></span><span
                                                                            class="apexcharts-tooltip-text-goals-value"></span>
                                                                    </div>
                                                                    <div class="apexcharts-tooltip-z-group"><span
                                                                            class="apexcharts-tooltip-text-z-label"></span><span
                                                                            class="apexcharts-tooltip-text-z-value"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="apexcharts-xaxistooltip apexcharts-xaxistooltip-bottom apexcharts-theme-light">
                                                            <div class="apexcharts-xaxistooltip-text"
                                                                style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                                            <div class="apexcharts-yaxistooltip-text"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 special-Offer-banner box-col-none">
                        <div class="card">
                            <div class="special-Offer">
                                <div class="offer-contain">
                                    <h4>Today’s Special Offer</h4>
                                    <p class="mt-2 text-center">You can flat get 20% off on your next pro version if your
                                        sale
                                        break your last record.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="container-fluid">
            <div class="row size-column">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        <i class="fa fa-exclamation-circle me-2"></i>
                        {{ session('error') }}

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection

@section('own_script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
