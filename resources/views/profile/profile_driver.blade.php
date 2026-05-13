@extends('layouts.template')

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
                        <h4>Profil Driver</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Users</li>
                            <li class="breadcrumb-item active">Profil Driver</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="edit-profile">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Profil Driver</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        @if ($data->foto)
                                            <img class="img-70 rounded-circle"
                                                src="{{ asset('storage') . '/' . $data->foto }}" alt="Profile Picture">
                                        @else
                                            <img class="img-70 rounded-circle"
                                                src="{{ asset('own_assets/images/avatar.png') }}" alt="Profile Picture">
                                        @endif
                                    </div>
                                    <div class="col-8">
                                        <h5 class="mb-1">{{ $data->name ?? '' }}</h5>
                                        <p>{{ ucfirst($data->role ?? '') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <form>
                                    <div class="row mb-2">
                                        <div class="profile-title">
                                            <div class="media">
                                                <div class="media-body">
                                                    <div class="row mb-4" style="margin-right: 10px">
                                                        <label class="form-label">Tipe Kendaraan</label>
                                                        <input class="form-control" type="text"
                                                            value="{{ $data->driver->vehicle_type ?? '' }}" readonly>
                                                    </div>

                                                    <div class="row mb-4" style="margin-right: 10px">
                                                        <label class="form-label">Plat Kendaraan</label>
                                                        <input class="form-control" type="text"
                                                            value="{{ $data->driver->plate_number ?? '' }}" readonly>
                                                    </div>

                                                    <div class="row">

                                                        <!-- RATING -->
                                                        <div class="col-md-3 mb-3">

                                                            <div class="card border-0 shadow rounded-4">

                                                                <div class="card-body text-center">

                                                                    <h6 class="text-muted">
                                                                        Rating
                                                                    </h6>

                                                                    <h2 class="fw-bold text-warning">

                                                                        ⭐ {{ $rating }}

                                                                    </h2>

                                                                    <small class="text-muted">

                                                                        {{ $totalReview }} Review

                                                                    </small>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <!-- DELIVERY -->
                                                        <div class="col-md-3 mb-3">

                                                            <div class="card border-0 shadow rounded-4">

                                                                <div class="card-body text-center">

                                                                    <h6 class="text-muted">
                                                                        Total Pengantaran
                                                                    </h6>

                                                                    <h2 class="fw-bold text-primary">

                                                                        {{ $totalDelivery }}

                                                                    </h2>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <!-- PENDAPATAN -->
                                                        <div class="col-md-3 mb-3">

                                                            <div class="card border-0 shadow rounded-4">

                                                                <div class="card-body text-center">

                                                                    <h6 class="text-muted">
                                                                        Pendapatan
                                                                    </h6>

                                                                    <h2 class="fw-bold text-success">

                                                                        Rp {{ number_format($totalIncome, 0, ',', '.') }}

                                                                    </h2>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="row" style="margin-right: 10px">
                                                        <label class="form-label">Total Delivery</label>
                                                        <input class="form-control" type="text"
                                                            value="{{ $data->driver->total_delivery ?? '' }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="col-xl-8">
                        <form class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Edit Profile Driver</h4>
                                <div class="card-options"><a class="card-options-collapse" href="#"
                                        data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                        class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                            class="fe fe-x"></i></a></div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Jenis Kendaraan</label>
                                            <select class="form-control" name="jenis_kendaraan" id="jenis_kendaraan">
                                                <option value="Sepeda Motor"
                                                    {{ $data->driver?->vehicle_type == 'Sepeda Motor' ? 'selected' : '' }}>
                                                    Sepeda Motor</option>
                                                <option value="Mobil Pickup"
                                                    {{ $data->driver?->vehicle_type == 'Mobil Pickup' ? 'selected' : '' }}>
                                                    Mobil Pickup</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Plat Kendaraan</label>
                                            <input class="form-control" name="plat_kendaraan" id="plat_kendaraan"
                                                placeholder="Masukkan plat kendaraan"
                                                value="{{ $data->driver->plate_number ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn btn-primary" type="button" id="change-profile">Update
                                    Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-toggle-wrapper">
                            <ul class="modal-img">
                                <li> <img id="alert-image" src="{{ asset('own_assets/icon/confirm.gif') }}"
                                        width="300px">
                                </li>
                            </ul>
                            <h4 class="text-center pb-2" id="alert-title">Hapus Data</h4>
                            <p class="text-center" id="alert-message">Apakah anda yakin ingin menghapus data?</p>
                            <div class="row">
                                <div class="col-md-6 d-flex justify-content-end">
                                    <button class="btn btn-primary" type="button"
                                        data-bs-dismiss="modal">Cancel</button>
                                </div>
                                <div class="col-md-6 d-flex justify-content-start">
                                    <button class="btn btn-danger" id="delete-confirmed" type="button"
                                        data-bs-dismiss="modal">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('own_script')
    <script src="{{ asset('own_assets/scripts/student.js') }}"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        $('#change-profile').on('click', function() {

            const btn = $(this);
            const formData = new FormData();

            formData.append('jenis_kendaraan', $('#jenis_kendaraan').val());
            formData.append('plat_kendaraan', $('#plat_kendaraan').val());

            btn.prop('disabled', true).text('Updating...');

            $.ajax({
                url: "/profile-driver",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message ?? 'Profile updated successfully'
                    });
                    setTimeout(() => {
                        location.reload()
                    }, 1000);
                },
                error: function(xhr) {
                    let msg = 'Something went wrong';
                    if (xhr.responseJSON?.message) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'warning',
                        title: 'Gagal',
                        text: msg
                    });
                },
                complete: function() {
                    btn.prop('disabled', false).text('Update Profile');
                }
            });
        });
    </script>
@endsection
