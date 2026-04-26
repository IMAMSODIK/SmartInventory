@extends('layouts.template')

@section('own_style')
@endsection

@section('content')
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

    <div class="container-fluid product-wrapper sidebaron">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @else
            <ul class="nav nav-tabs" id="myTab">
                <li class="nav-item">
                    <button class="nav-link active" id="user-tab" data-bs-toggle="tab" data-bs-target="#user">
                        Data User
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail">
                        Arsip Terhapus
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-3">
                <!-- TAB 1 -->
                <div class="tab-pane fade show active" id="user">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary" id="tambah-data" style="margin-right: 5px">
                                        <i class="fa fa-plus-circle me-2"></i> Tambah Data
                                    </button>
                                    <button class="btn btn-info refresh-data" data-table="data" style="margin-right: 5px">
                                        <i class="fa fa-refresh me-2" aria-hidden="true"></i> Refresh Data
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <table id="dataTable" class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2 -->
                <div class="tab-pane fade" id="detail">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-info refresh-data" data-table="trash" style="margin-right: 5px">
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
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Role</th>
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
                        <h5 class="modal-title">Tambah User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name">Nama (Wajib diisi)</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan nama user">
                            <small class="text-danger error-name"></small>
                        </div>

                        <div class="mb-3">
                            <label>Email (Wajib diisi)</label>
                            <input type="email" name="email" class="form-control" placeholder="Masukkan email user">
                            <small class="text-danger error-email"></small>
                        </div>

                        <div class="mb-3">
                            <label>Foto</label>
                            <input type="file" name="foto" class="form-control" id="foto">
                            <div class="mt-2">
                                <img id="preview-foto" src="" alt="Preview"
                                    style="max-width: 150px; display: none; border-radius: 8px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Role (Wajib dipilih)</label>
                            <select name="role" id="role" class="form-control">
                                <option value="kasir">Kasir</option>
                                <option value="waiter">Waiter</option>
                                <option value="kitchen">Kitchen</option>
                            </select>
                            <small class="text-danger error-role"></small>
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
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" name="name" id="edit_name" class="form-control">
                            <small class="text-danger error-name"></small>
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control">
                            <small class="text-danger error-email"></small>
                        </div>

                        <div class="mb-3">
                            <label>Foto</label>
                            <input type="file" name="foto" class="form-control" id="edit_foto">

                            <div class="mt-2">
                                <img id="preview-edit_foto" style="max-width:150px; border-radius:8px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Role</label>
                            <select name="role" id="edit_role" class="form-control">
                                <option value="kasir">Kasir</option>
                                <option value="waiter">Waiter</option>
                                <option value="kitchen">Kitchen</option>
                            </select>
                            <small class="text-danger error-role"></small>
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
    <script src="{{ asset('own_assets/scripts/user.js') }}"></script>
@endsection
