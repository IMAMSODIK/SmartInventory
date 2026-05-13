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
                    <div class="col-xl-2 col-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-project border-b-primary border-2"><span
                                    class="f-light f-w-500 f-14">Total Order</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600">{{ $totalOrderSelesai ?? 0 }}</h2><span
                                            class="f-12 f-w-400">(Order Selesai)</span>
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
                    <div class="col-xl-2 col-6">
                        <div class="card o-hidden small-widget">
                            <div class="card-body total-project border-b-primary border-2"><span
                                    class="f-light f-w-500 f-14">Total Pendapatan</span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h2 class="f-w-600">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
                                        </h2>
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

                <div class="container mt-4">

                    <!-- TAB -->
                    <ul class="nav nav-pills mb-4" id="driverTab">

                        <li class="nav-item">
                            <button class="nav-link active" id="aktif-tab" data-bs-toggle="pill"
                                data-bs-target="#aktif-order">
                                🚚 Order Aktif
                            </button>
                        </li>

                        <li class="nav-item ms-2">
                            <button class="nav-link" id="history-tab" data-bs-toggle="pill"
                                data-bs-target="#history-order">
                                📜 History Pengantaran
                            </button>
                        </li>

                    </ul>

                    <!-- TAB CONTENT -->
                    <div class="tab-content">

                        <!-- ORDER AKTIF -->
                        <div class="tab-pane fade show active" id="aktif-order">

                            <div id="activeOrders"></div>

                        </div>

                        <!-- HISTORY -->
                        <div class="tab-pane fade" id="history-order">

                            <div id="historyOrders"></div>

                        </div>

                    </div>

                </div>
            @endif

            @if (auth()->user()->role == 'pembeli')
                <div class="container mt-4">

                    <!-- TAB -->
                    <ul class="nav nav-pills mb-4" id="buyerTab">

                        <li class="nav-item">
                            <button class="nav-link active" id="aktif-tab" data-bs-toggle="pill"
                                data-bs-target="#aktif-order">

                                🛒 Order Aktif

                            </button>
                        </li>

                        <li class="nav-item ms-2">
                            <button class="nav-link" id="history-tab" data-bs-toggle="pill"
                                data-bs-target="#history-order">

                                📜 History Order

                            </button>
                        </li>

                    </ul>

                    <!-- CONTENT -->
                    <div class="tab-content">

                        <!-- ORDER AKTIF -->
                        <div class="tab-pane fade show active" id="aktif-order">

                            @forelse($activeOrders as $order)
                                <div class="card shadow-sm border-0 rounded-4 mb-4">

                                    <div class="card-body">

                                        <div class="d-flex justify-content-between">

                                            <h5 class="fw-bold text-success">
                                                #{{ $order->order_id }}
                                            </h5>

                                            <span class="badge bg-primary">
                                                {{ strtoupper($order->status) }}
                                            </span>

                                        </div>

                                        <hr>

                                        <p class="mb-1">
                                            <strong>Alamat:</strong>
                                            {{ $order->alamat->full_address }}
                                        </p>

                                        <p class="mb-3">
                                            <strong>Total:</strong>
                                            Rp {{ number_format($order->total, 0, ',', '.') }}
                                        </p>

                                        <h6 class="fw-bold">
                                            Barang:
                                        </h6>

                                        <ul class="list-group">

                                            @foreach ($order->items as $item)
                                                <li class="list-group-item d-flex justify-content-between">

                                                    <span>
                                                        {{ $item->nama_produk }}
                                                        x {{ $item->qty }}
                                                    </span>

                                                    <strong>
                                                        Rp {{ number_format($item->harga * $item->qty, 0, ',', '.') }}
                                                    </strong>

                                                </li>
                                            @endforeach

                                        </ul>

                                    </div>

                                </div>

                            @empty

                                <div class="alert alert-secondary">
                                    Tidak ada order aktif
                                </div>
                            @endforelse

                        </div>

                        <!-- HISTORY -->
                        <div class="tab-pane fade" id="history-order">

                            @forelse($historyOrders as $order)
                                <div class="card shadow-sm border-0 rounded-4 mb-4">

                                    <div class="card-body">

                                        <div class="d-flex justify-content-between">

                                            <h5 class="fw-bold">
                                                #{{ $order->order_id }}
                                            </h5>

                                            @if ($order->status == 'delivered')
                                                <span class="badge bg-success">
                                                    SELESAI
                                                </span>
                                            @elseif($order->status == 'cancelled')
                                                <span class="badge bg-danger">
                                                    DIBATALKAN
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    {{ strtoupper($order->status) }}
                                                </span>
                                            @endif

                                        </div>

                                        <hr>

                                        <p class="mb-1">
                                            <strong>Alamat:</strong>
                                            {{ $order->alamat->full_address }}
                                        </p>

                                        <p class="mb-3">
                                            <strong>Total:</strong>
                                            Rp {{ number_format($order->total, 0, ',', '.') }}
                                        </p>

                                        <ul class="list-group">

                                            @foreach ($order->items as $item)
                                                <li class="list-group-item d-flex justify-content-between">

                                                    <span>
                                                        {{ $item->nama_produk }}
                                                        x {{ $item->qty }}
                                                    </span>

                                                    <strong>
                                                        Rp {{ number_format($item->harga * $item->qty, 0, ',', '.') }}
                                                    </strong>

                                                </li>
                                            @endforeach

                                        </ul>

                                    </div>

                                </div>

                            @empty

                                <div class="alert alert-secondary">
                                    Belum ada history order
                                </div>
                            @endforelse

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
