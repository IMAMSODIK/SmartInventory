@extends('layouts.template')

@section('own_style')
    <style>
        .product-img {
            width: 100%;
            height: 200px;
            overflow: hidden;
        }

        .product-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .skeleton-img {
            height: 200px;
            background: linear-gradient(90deg, #eee, #ddd, #eee);
            background-size: 200% 100%;
            animation: shimmer 1.2s infinite;
        }

        .skeleton-text {
            height: 15px;
            background: linear-gradient(90deg, #eee, #ddd, #eee);
            background-size: 200% 100%;
            animation: shimmer 1.2s infinite;
            border-radius: 4px;
        }

        .skeleton-text.small {
            width: 60%;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }
    </style>
@endsection

@section('content')
    <input type="hidden" name="user_role" id="user_role" value="{{ auth()->user()->role }}">
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
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $pageTitle }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid product-wrapper">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @else
            <ul class="nav nav-tabs" id="myTab">
                <li class="nav-item">
                    <button class="nav-link active" id="user-tab" data-bs-toggle="tab" data-bs-target="#user">
                        Data Produk
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail">
                        Arsip Terhapus
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="user">
                    <div class="product-grid">
                        <div class="feature-products">
                            <div class="row">
                                <div class="col-md-6 products-total">
                                </div>
                                <div class="col-md-6 text-sm-end">
                                    <div class="d-flex justify-content-end mb-2">
                                        @if (auth()->user()->role == 'pedagang')
                                            <button class="btn btn-primary" id="tambah-data" style="margin-right: 5px">
                                                <i class="fa fa-plus-circle me-2"></i> Tambah Data
                                            </button>
                                        @endif
                                        <button class="btn btn-info refresh-data" data-table="data"
                                            style="margin-right: 5px">
                                            <i class="fa fa-refresh me-2" aria-hidden="true"></i> Refresh Data
                                        </button>
                                        <span class="d-none-productlist filter-toggle">Filters <span class="ms-2"><i
                                                    class="toggle-data" data-feather="chevron-down"></i></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="product-sidebar">
                                        <div class="filter-section">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h6 class="mb-0 f-w-600">Filters<span class="pull-right"><i
                                                                class="fa fa-chevron-down toggle-data"></i></span></h6>
                                                </div>
                                                <div class="left-filter">
                                                    <div class="card-body filter-cards-view animate-chk">
                                                        <div class="product-filter">
                                                            <h6 class="f-w-600">Category</h6>
                                                            <div class="checkbox-animated mt-0" id="filter-kategori">
                                                                @foreach ($kategoriMenus as $kategori)
                                                                    <label class="d-block">
                                                                        <input class="checkbox_animated filter-kategori"
                                                                            type="checkbox" value="{{ $kategori->id }}">
                                                                        {{ $kategori->nama_kategori }}
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        {{-- <div class="product-filter">
                                                            <h6 class="f-w-600">Status Menu</h6>

                                                            <label class="d-block">
                                                                <input type="radio" name="filter_ready" value=""
                                                                    checked>
                                                                Semua
                                                            </label>

                                                            <label class="d-block">
                                                                <input type="radio" name="filter_ready" value="1">
                                                                Ready
                                                            </label>

                                                            <label class="d-block">
                                                                <input type="radio" name="filter_ready" value="0">
                                                                Tidak Ready
                                                            </label>
                                                        </div> --}}

                                                        <div class="product-filter mt-5">
                                                            <button class="btn btn-sm btn-secondary w-100 reset-filter">
                                                                Reset Filter
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9 col-sm-12">
                                    <form>
                                        <div class="form-group m-0 position-relative">
                                            <input id="search-menu" class="form-control" type="search"
                                                placeholder="Search menu...">
                                            <i class="fa fa-search position-absolute" style="right:10px; top:12px;"></i>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="product-wrapper-grid">
                            <div class="row menu-grid" id="menu-container">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="detail">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-info refresh-data-table" data-table="trash"
                                        style="margin-right: 5px">
                                        <i class="fa fa-refresh me-2" aria-hidden="true"></i> Refresh Data
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <table id="dataTableTrash" class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Kategori</th>
                                            <th>Stock</th>
                                            <th>Harga</th>
                                            <th>Status Approval</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="modal fade" id="modalCreate" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formCreate">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Nama Produk (Wajib diisi)</label>
                            <input type="text" name="name" class="form-control"
                                placeholder="Masukkan nama produk">
                            <small class="text-danger error-name"></small>
                        </div>

                        <div class="mb-3">
                            <label>Kategori (Wajib dipilih)</label>
                            <select name="kategori_id" class="form-control">
                                @foreach ($kategoriMenus as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger error-kategori_id"></small>
                        </div>

                        <div class="mb-3">
                            <label>Harga (Wajib diisi)</label>
                            <input type="text" name="price" id="price" class="form-control"
                                placeholder="Masukkan harga produk">
                            <small class="text-danger error-price"></small>
                        </div>

                        <div class="mb-3">
                            <label>Stok</label>
                            <input type="number" name="stock" class="form-control" placeholder="Jumlah stok">
                        </div>

                        <div class="mb-3">
                            <label>Satuan (kg, liter, dll)</label>
                            <input type="text" name="unit" class="form-control" placeholder="Contoh: kg, liter">
                        </div>

                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" placeholder="Masukkan deskripsi produk"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Foto Produk</label>
                            <input type="file" name="foto_produk[]" multiple class="form-control" id="foto_produk">
                            <div id="preview-container" class="mt-2 d-flex flex-wrap gap-2"></div>
                            <small class="text-danger error-foto_produk"></small>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEdit">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Nama Produk</label>
                            <input type="text" name="edit_name" class="form-control">
                            <small class="text-danger error-edit_name"></small>
                        </div>

                        <div class="mb-3">
                            <label>Kategori</label>
                            <select name="edit_kategori_id" class="form-control">
                                @foreach ($kategoriMenus as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger error-edit_kategori_id"></small>
                        </div>

                        <div class="mb-3">
                            <label>Harga</label>
                            <input type="text" name="edit_price" id="edit_price" class="form-control">
                            <small class="text-danger error-edit_price"></small>
                        </div>

                        <div class="mb-3">
                            <label>Stok</label>
                            <input type="number" name="edit_stock" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Satuan</label>
                            <input type="text" name="edit_unit" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea name="edit_description" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Foto Produk</label>
                            <input type="file" name="edit_foto_produk[]" multiple class="form-control">
                            <div id="edit-preview-container" class="mt-2 d-flex flex-wrap gap-2"></div>
                            <small class="text-danger error-edit_foto_produk"></small>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('own_script')
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <script src="{{ asset('own_assets/scripts/utils/menu.js') }}"></script>
    <script src="{{ asset('own_assets/scripts/produk.js') }}"></script>
@endsection
