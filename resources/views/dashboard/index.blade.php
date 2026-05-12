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
            @if (auth()->user()->role == 'admin')
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-project border-b-primary border-2"><span
                                    class="f-light f-w-500 f-14">Total Pengguna</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600">{{ $data['total_user'] }}</h2><span
                                            class="f-12 f-w-400">(Pengguna)</span>
                                    </div>
                                    <div class="product-sub bg-primary-light">
                                        <i class="fa fa-users text-success" aria-hidden="true"></i>
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
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Progress border-b-warning border-2"> <span
                                    class="f-light f-w-500 f-14">Total Pedagang</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600">{{ $data['total_pedagang'] }}</h2><span
                                            class="f-12 f-w-400">(Pedagang) </span>
                                    </div>
                                    <div class="product-sub bg-warning-light">
                                        <i class="fa fa-building text-warning" aria-hidden="true"></i>
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
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Complete border-b-secondary border-2"><span
                                    class="f-light f-w-500 f-14">Total Customer</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600">{{ $data['total_pembeli'] }}</h2><span
                                            class="f-12 f-w-400">(Customer) </span>
                                    </div>
                                    <div class="product-sub bg-secondary-light">
                                        <svg class="invoice-icon">
                                            <use
                                                href="{{ asset('dashboard_assets/assets/svg/icon-sprite.svg#add-square') }}">
                                            </use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                    <li class="bubble"></li>
                                    <li class="bubble"></li>
                                    <li class="bubble"> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-upcoming"><span class="f-light f-w-500 f-14">Total Driver</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600">{{ $data['total_kurir'] }}</h2><span
                                            class="f-12 f-w-400">(Driver) </span>
                                    </div>
                                    <div class="product-sub bg-light-light">
                                        <i class="fa fa-motorcycle text-dark"></i>
                                    </div>
                                </div>
                                <ul class="bubbles">
                                    <li class="bubble"> </li>
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

                <div class="row">

                    <!-- ORDER -->
                    <div class="col-lg-6 col-12">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-upcoming">
                                <span class="f-light f-w-500 f-14">Orders</span>

                                <div class="project-details">
                                    <div class="project-counter">
                                        <h6 class="mb-1">Hari ini: {{ $orderOverview['today']['total'] }}</h6>
                                    </div>
                                    <h4 class="f-w-600">Total: {{ $orderOverview['all']['total'] }}</h4>

                                    <div class="product-sub bg-light-light">
                                        <i class="fa fa-shopping-cart text-primary"></i>
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

                    <!-- REVENUE -->
                    <div class="col-lg-6 col-12">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Complete border-b-success border-2">
                                <span class="f-light f-w-500 f-14">Revenue</span>

                                <div class="project-details">
                                    <div class="project-counter">
                                        <h6 class="mb-1">
                                            Hari ini: Rp {{ number_format($revenue['revenue_today'] ?? 0, 0, ',', '.') }}
                                        </h6>
                                    </div>
                                    <h4 class="f-w-600">
                                        Total: Rp {{ number_format($revenue['revenue_all'] ?? 0, 0, ',', '.') }}
                                    </h4>

                                    <div class="product-sub bg-success-light">
                                        <i class="fa fa-money text-success"></i>
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

                    <!-- PENDING -->
                    <div class="col-lg-6 col-12">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-upcoming border-b-warning border-2">
                                <span class="f-light f-w-500 f-14">Pending Orders</span>

                                <div class="project-details">
                                    <div class="project-counter">
                                        <h6 class="mb-1">Hari ini: {{ $orderOverview['today']['pending'] }}</h6>
                                    </div>
                                    <h4 class="f-w-600">Total: {{ $orderOverview['all']['pending'] }}</h4>

                                    <div class="product-sub bg-warning-light">
                                        <i class="fa fa-clock text-warning"></i>
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

                    <!-- SHIPPING -->
                    <div class="col-lg-6 col-12">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-upcoming border-b-dark border-2">
                                <span class="f-light f-w-500 f-14">Shipping</span>

                                <div class="project-details">
                                    <div class="project-counter">
                                        <h6 class="mb-1">Hari ini: {{ $orderOverview['today']['shipping'] }}</h6>
                                    </div>
                                    <h4 class="f-w-600">Total: {{ $orderOverview['all']['shipping'] }}</h4>

                                    <div class="product-sub bg-dark-light">
                                        <i class="fa fa-truck text-dark"></i>
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

                    <!-- DELIVERED -->
                    <div class="col-lg-6 col-12">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-Complete border-b-success border-2">
                                <span class="f-light f-w-500 f-14">Delivered</span>

                                <div class="project-details">
                                    <div class="project-counter">
                                        <h6 class="mb-1">Hari ini: {{ $orderOverview['today']['delivered'] }}</h6>
                                    </div>
                                    <h4 class="f-w-600">Total: {{ $orderOverview['all']['delivered'] }}</h4>

                                    <div class="product-sub bg-success-light">
                                        <i class="fa fa-check-circle text-success"></i>
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

                    <!-- PROCESSING -->
                    <div class="col-lg-6 col-12">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-upcoming border-b-info border-2">
                                <span class="f-light f-w-500 f-14">Processing</span>

                                <div class="project-details">
                                    <div class="project-counter">
                                        <h6 class="mb-1">Hari ini: {{ $orderOverview['today']['processing'] }}</h6>
                                    </div>
                                    <h4 class="f-w-600">Total: {{ $orderOverview['all']['processing'] }}</h4>

                                    <div class="product-sub bg-info-light">
                                        <i class="fa fa-cogs text-info"></i>
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
            @endif

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

                <div class="row" id="driverOrders">
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
