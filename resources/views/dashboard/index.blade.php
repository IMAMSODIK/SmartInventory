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
                    <ul class="nav nav-pills mb-4">

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#active-order">

                                🛒 Order Aktif

                            </button>
                        </li>

                        <li class="nav-item ms-2">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#history-order">

                                📜 History Order

                            </button>
                        </li>

                    </ul>

                    <div class="tab-content">

                        <!-- ORDER AKTIF -->
                        <div class="tab-pane fade show active" id="active-order">

                            @forelse($activeOrders as $order)
                                <div class="card border-0 shadow rounded-4 mb-4">

                                    <div class="card-body">

                                        <!-- HEADER -->
                                        <div class="d-flex justify-content-between align-items-start mb-3">

                                            <div>

                                                <h5 class="fw-bold text-success mb-1">
                                                    #{{ $order->order_id }}
                                                </h5>

                                                <small class="text-muted">
                                                    {{ $order->created_at->format('d M Y H:i') }}
                                                </small>

                                            </div>

                                            <span class="badge bg-primary">
                                                {{ strtoupper($order->status) }}
                                            </span>

                                        </div>

                                        <!-- ALAMAT -->
                                        <div class="mb-4">

                                            <small class="text-muted d-block">
                                                📍 Alamat Pengiriman
                                            </small>

                                            <strong>
                                                {{ $order->alamat->full_address ?? '-' }}
                                            </strong>

                                        </div>

                                        <!-- DETAIL PESANAN -->
                                        <h6 class="fw-bold mb-3">
                                            Detail Pesanan
                                        </h6>

                                        @forelse($order->orderItem as $item)
                                            @php

                                                $img = asset('storage/default.png');

                                                if (
                                                    $item->produk &&
                                                    $item->produk->fotoProduk &&
                                                    $item->produk->fotoProduk->count()
                                                ) {
                                                    $foto = $item->produk->fotoProduk->first();

                                                    if ($foto) {
                                                        $img = asset('storage/' . $foto->image);
                                                    }
                                                }

                                                $subtotal = $item->harga * $item->qty;

                                            @endphp

                                            <div class="border rounded-4 p-3 mb-3">

                                                <div class="d-flex">

                                                    <!-- GAMBAR -->
                                                    <img src="{{ $img }}" width="90" height="90"
                                                        class="rounded-3 object-fit-cover me-3">

                                                    <!-- DETAIL -->
                                                    <div class="flex-grow-1">

                                                        <h6 class="fw-bold mb-1">
                                                            {{ $item->nama_produk }}
                                                        </h6>

                                                        <small class="text-muted d-block">
                                                            Harga:
                                                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                                                        </small>

                                                        <small class="text-muted d-block">
                                                            Qty:
                                                            {{ $item->qty }}
                                                        </small>

                                                        @if ($item->note)
                                                            <small class="text-muted d-block">
                                                                Catatan:
                                                                {{ $item->note }}
                                                            </small>
                                                        @endif

                                                    </div>

                                                    <!-- SUBTOTAL -->
                                                    <div class="text-end">

                                                        <small class="text-muted d-block">
                                                            Total
                                                        </small>

                                                        <h6 class="fw-bold text-success">
                                                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                                                        </h6>

                                                    </div>

                                                </div>

                                            </div>

                                        @empty

                                            <div class="alert alert-light">
                                                Tidak ada item pesanan
                                            </div>
                                        @endforelse

                                        <!-- ONGKIR -->
                                        <div class="border-top pt-3 mt-3">

                                            <div class="d-flex justify-content-between mb-2">

                                                <span>🚚 Ongkir</span>

                                                <strong>
                                                    Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                                </strong>

                                            </div>

                                            <div class="d-flex justify-content-between">

                                                <h5 class="fw-bold">
                                                    💰 Total Bayar
                                                </h5>

                                                <h4 class="fw-bold text-success">
                                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                                </h4>

                                            </div>

                                        </div>

                                        <!-- AKSI -->
                                        @if ($order->status == 'paid')
                                            <div class="mt-4">

                                                <button class="btn btn-success rounded-pill complete-order-btn mt-3"
                                                    data-id="{{ $order->id }}">

                                                    ✅ Selesaikan Pesanan

                                                </button>

                                            </div>
                                        @endif

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
                                <div class="card border-0 shadow rounded-4 mb-4">

                                    <div class="card-body">

                                        <!-- HEADER -->
                                        <div class="d-flex justify-content-between align-items-start mb-3">

                                            <div>

                                                <h5 class="fw-bold mb-1">
                                                    #{{ $order->order_id }}
                                                </h5>

                                                <small class="text-muted">
                                                    {{ $order->created_at->format('d M Y H:i') }}
                                                </small>

                                            </div>
                                            {{$order->status}}
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

                                        <!-- DETAIL ITEM -->
                                        @forelse($order->orderItem as $item)
                                            @php

                                                $img = asset('storage/default.png');

                                                if (
                                                    $item->produk &&
                                                    $item->produk->fotoProduk &&
                                                    $item->produk->fotoProduk->count()
                                                ) {
                                                    $foto = $item->produk->fotoProduk->first();

                                                    if ($foto) {
                                                        $img = asset('storage/' . $foto->image);
                                                    }
                                                }

                                                $subtotal = $item->harga * $item->qty;

                                            @endphp

                                            <div class="border rounded-4 p-3 mb-3">

                                                <div class="d-flex">

                                                    <!-- GAMBAR -->
                                                    <img src="{{ $img }}" width="90" height="90"
                                                        class="rounded-3 object-fit-cover me-3">

                                                    <!-- DETAIL -->
                                                    <div class="flex-grow-1">

                                                        <h6 class="fw-bold mb-1">
                                                            {{ $item->nama_produk }}
                                                        </h6>

                                                        <small class="text-muted d-block">
                                                            Harga:
                                                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                                                        </small>

                                                        <small class="text-muted d-block">
                                                            Qty:
                                                            {{ $item->qty }}
                                                        </small>

                                                    </div>

                                                    <!-- TOTAL -->
                                                    <div class="text-end">

                                                        <small class="text-muted d-block">
                                                            Total
                                                        </small>

                                                        <h6 class="fw-bold text-success">
                                                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                                                        </h6>

                                                    </div>

                                                </div>

                                            </div>

                                        @empty

                                            <div class="alert alert-light">
                                                Tidak ada item pesanan
                                            </div>
                                        @endforelse

                                        <!-- TOTAL -->
                                        <div class="border-top pt-3 mt-3">

                                            <div class="d-flex justify-content-between mb-2">

                                                <span>🚚 Ongkir</span>

                                                <strong>
                                                    Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                                                </strong>

                                            </div>

                                            <div class="d-flex justify-content-between">

                                                <h5 class="fw-bold">
                                                    💰 Total Bayar
                                                </h5>

                                                <h4 class="fw-bold text-success">
                                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                                </h4>

                                            </div>

                                        </div>

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

    <div class="modal fade" id="completeOrderModal" tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content rounded-4 border-0">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Rating Pesanan
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <input type="hidden" id="complete_order_id">

                    <!-- RATING DRIVER -->
                    <div class="mb-4">

                        <label class="fw-bold mb-2">
                            ⭐ Rating Driver
                        </label>

                        <select class="form-select" id="driver_rating">

                            <option value="5">5 - Sangat Baik</option>
                            <option value="4">4 - Baik</option>
                            <option value="3">3 - Cukup</option>
                            <option value="2">2 - Buruk</option>
                            <option value="1">1 - Sangat Buruk</option>

                        </select>

                        <textarea class="form-control mt-2" id="driver_review" placeholder="Review driver"></textarea>

                    </div>

                    <!-- RATING PRODUK -->
                    <div id="produk-rating-wrapper">

                    </div>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-success" id="submitCompleteOrder">

                        Submit Penilaian

                    </button>

                </div>

            </div>

        </div>

    </div>
@endsection

@section('own_script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).on('click', '.complete-order-btn', function() {

            let orderId = $(this).data('id');

            $('#complete_order_id').val(orderId);

            $.get('/buyer/order/' + orderId + '/detail', function(res) {

                let html = '';

                res.items.forEach(item => {

                    html += `
                <div class="border rounded-4 p-3 mb-3">

                    <h6 class="fw-bold">
                        ${item.nama_produk}
                    </h6>

                    <select class="form-select produk-rating mt-2"
                            data-id="${item.id}">

                        <option value="5">5 - Sangat Baik</option>
                        <option value="4">4 - Baik</option>
                        <option value="3">3 - Cukup</option>
                        <option value="2">2 - Buruk</option>
                        <option value="1">1 - Sangat Buruk</option>

                    </select>

                    <textarea class="form-control mt-2 produk-review"
                              data-id="${item.id}"
                              placeholder="Review produk"></textarea>

                </div>
            `;
                });

                $('#produk-rating-wrapper').html(html);

                $('#completeOrderModal').modal('show');

            });

        });

        $('#submitCompleteOrder').click(function() {

            let orderId = $('#complete_order_id').val();

            let produkRatings = [];

            $('.produk-rating').each(function() {

                let itemId = $(this).data('id');

                let rating = $(this).val();

                let review = $('.produk-review[data-id="' + itemId + '"]').val();

                produkRatings.push({
                    order_item_id: itemId,
                    rating: rating,
                    review: review
                });

            });

            $.ajax({

                url: '/buyer/order/' + orderId + '/complete',
                method: 'POST',

                data: {

                    _token: $('meta[name="csrf-token"]').attr('content'),

                    driver_rating: $('#driver_rating').val(),

                    driver_review: $('#driver_review').val(),

                    produk_ratings: produkRatings

                },

                success: function(res) {

                    toastr.success(res.message);

                    $('#completeOrderModal').modal('hide');

                    location.reload();

                },

                error: function(err) {

                    toastr.error('Gagal submit rating');

                }

            });

        });
    </script>
@endsection
