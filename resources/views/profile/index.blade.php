@extends('layouts.template')

@section('own_style')
    <style>
        .alamat-item[data-default="true"] {
            border: 2px solid #28a745;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>User Profile</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Users</li>
                        <li class="breadcrumb-item active">User Profile</li>
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
                            <h4 class="card-title mb-0">My Profile</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row mb-2">
                                    <div class="profile-title">
                                        <div class="media">
                                            @if ($data->foto)
                                                <img class="img-70 rounded-circle"
                                                    src="{{ asset('storage') . '/' . $data->foto }}" alt="Profile Picture">
                                            @else
                                                <img class="img-70 rounded-circle"
                                                    src="{{ asset('own_assets/images/avatar.png') }}" alt="Profile Picture">
                                            @endif
                                            <div class="media-body">
                                                <h5 class="mb-1">{{ $data->name }}</h5>
                                                <p>{{ ucfirst($data->role) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email-Address</label>
                                    <input class="form-control" readonly value="{{ $data->email }}">
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Change Password</h4>
                        </div>
                        <div class="card-body">
                            <form id="change-password-form">
                                <div class="mb-3">
                                    <label class="form-label">Current Password</label>
                                    <input class="form-control" type="password" id="current_password"
                                        name="current_password" placeholder="Enter your current password">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input class="form-control" type="password" id="new_password" name="new_password"
                                        placeholder="Enter your new password">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input class="form-control" type="password" id="new_password_confirmation"
                                        name="new_password_confirmation" placeholder="Confirm your new password">
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary btn-block" id="save-password">Save</button>
                        </div>
                    </div>

                </div>
                <div class="col-xl-8">
                    <form class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Edit Profile</h4>
                            <div class="card-options"><a class="card-options-collapse" href="#"
                                    data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                    class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                        class="fe fe-x"></i></a></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input class="form-control" name="name" id="nama" type="text"
                                            value="{{ $data->name }}" placeholder="Enter yout name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Foto</label>
                                        <input class="form-control" name="foto" id="foto" type="file"
                                            accept="image/*">
                                        <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB.</div>
                                    </div>

                                    <div id="foto-preview-container" class="mt-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <p class="text-muted mb-0">Preview:</p>
                                            <button type="button" id="hapus-preview"
                                                class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-times"></i> Hapus
                                            </button>
                                        </div>
                                        <div class="border rounded p-2 d-inline-block position-relative">
                                            <img id="preview-foto" class="img-fluid rounded"
                                                src="{{ $data->foto ? asset('storage') . '/' . $data->foto : asset('own_assets/images/avatar.png') }}"
                                                style="max-height: 200px;">
                                            <div class="mt-2 text-center">
                                                <small class="text-muted" id="file-info"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="button" id="change-profile">Update Profile</button>
                        </div>
                    </form>
                </div>

                @if (auth()->user()->role == 'pembeli')
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Daftar Alamat</h4>
                            </div>

                            <div class="card-body" id="alamat-container">
                                <!-- isi dari JS -->
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <form class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Pengaturan Alamat</h4>
                                <div class="card-options"><a class="card-options-collapse" href="#"
                                        data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                        class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                            class="fe fe-x"></i></a></div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Label Alamat</label>
                                            <select class="form-control" name="label" id="label">
                                                <option value="Rumah">Rumah</option>
                                                <option value="Kantor">Kantor</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Alamat Lengkap</label>
                                            <textarea class="form-control" id="full_address" rows="3" readonly></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div id="map-alamat" style="height:300px; border-radius:10px;"></div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" id="latitude" class="form-control"
                                                    placeholder="Latitude" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" id="longitude" class="form-control"
                                                    placeholder="Longitude" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn btn-primary" type="button" id="add-address">Simpan Alamat</button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade modal-alert" id="alert" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenter1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-toggle-wrapper">
                        <ul class="modal-img">
                            <li> <img id="alert-image"></li>
                        </ul>
                        <h4 class="text-center pb-2" id="alert-title"></h4>
                        <p class="text-center" id="alert-message"></p>
                        <button class="btn btn-secondary d-flex m-auto" id="is-error" type="button"
                            data-bs-dismiss="modal">Close</button>
                    </div>
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
                            <li> <img id="alert-image" src="{{ asset('own_assets/icon/confirm.gif') }}" width="300px">
                            </li>
                        </ul>
                        <h4 class="text-center pb-2" id="alert-title">Hapus Data</h4>
                        <p class="text-center" id="alert-message">Apakah anda yakin ingin menghapus data?</p>
                        <div class="row">
                            <div class="col-md-6 d-flex justify-content-end">
                                <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Cancel</button>
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
@endsection

@section('own_script')
    <script src="{{ asset('own_assets/scripts/student.js') }}"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.getElementById('foto').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const preview = document.getElementById('preview-foto');
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('d-none');
            }
        });
    </script>

    <script>
        document.getElementById('foto').addEventListener('change', function(event) {
            const [file] = event.target.files;
            const previewContainer = document.getElementById('foto-preview-container');
            const preview = document.getElementById('preview-foto');
            const fileInfo = document.getElementById('file-info');
            const hapusBtn = document.getElementById('hapus-preview');

            if (file) {
                if (!file.type.match('image/(jpeg|png|gif|jpg)')) {
                    alert('Format file tidak didukung. Harap pilih file JPG, PNG, atau GIF.');
                    this.value = '';
                    previewContainer.classList.add('d-none');
                    return;
                }

                const maxSize = 2 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('Ukuran file maksimal 2MB. File Anda: ' + formatBytes(file.size));
                    this.value = '';
                    previewContainer.classList.add('d-none');
                    return;
                }

                preview.src = URL.createObjectURL(file);
                fileInfo.textContent = `${file.name} (${formatBytes(file.size)})`;
                previewContainer.classList.remove('d-none');

                preview.onload = function() {
                    URL.revokeObjectURL(preview.src);
                }
            } else {
                previewContainer.classList.add('d-none');
            }
        });

        document.getElementById('hapus-preview').addEventListener('click', function() {
            const inputFile = document.getElementById('foto');
            const previewContainer = document.getElementById('foto-preview-container');

            inputFile.value = '';
            previewContainer.classList.add('d-none');
        });

        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';

            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];

            const i = Math.floor(Math.log(bytes) / Math.log(k));

            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }
    </script>

    <script>
        $('#change-profile').on('click', function() {

            const btn = $(this);
            const formData = new FormData();

            formData.append('name', $('#nama').val());
            formData.append('foto', $('#foto')[0].files[0] ?? '');

            btn.prop('disabled', true).text('Updating...');

            $.ajax({
                url: "/profile",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    alertModal(true, res.message ?? 'Profile updated successfully');
                    setTimeout(() => {
                        location.reload()
                    }, 1000);
                },
                error: function(xhr) {
                    let msg = 'Something went wrong';
                    if (xhr.responseJSON?.message) {
                        msg = xhr.responseJSON.message;
                    }
                    alertModal(false, msg);
                },
                complete: function() {
                    btn.prop('disabled', false).text('Update Profile');
                }
            });
        });
    </script>

    <script>
        $('#save-password').on('click', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('password.update') }}",
                method: "POST",
                data: {
                    current_password: $('#current_password').val(),
                    new_password: $('#new_password').val(),
                    new_password_confirmation: $('#new_password_confirmation').val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    alertModal(true, res.message ?? 'Password updated successfully');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    alertModal(false, xhr.responseJSON?.message ?? 'Failed to update password');
                }
            });
        });
    </script>

    <script>
        let map, marker;

        map = L.map('map-alamat').setView([3.5952, 98.6722], 13); // default medan

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        // klik map
        map.on('click', function(e) {
            let lat = e.latlng.lat;
            let lng = e.latlng.lng;

            $('#latitude').val(lat);
            $('#longitude').val(lng);

            if (marker) map.removeLayer(marker);
            marker = L.marker([lat, lng]).addTo(map);

            // 🔥 reverse geocoding (ambil alamat)
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(res => res.json())
                .then(data => {
                    $('#full_address').val(data.display_name);
                });
        });

        // auto detect lokasi awal
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(pos) {
                let lat = pos.coords.latitude;
                let lng = pos.coords.longitude;

                map.setView([lat, lng], 15);
                marker = L.marker([lat, lng]).addTo(map);

                $('#latitude').val(lat);
                $('#longitude').val(lng);

                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(res => res.json())
                    .then(data => {
                        $('#full_address').val(data.display_name);
                    });
            });
        }


        $('#add-address').on('click', function() {

            let btn = $(this);
            let formData = new FormData();

            formData.append('label', $('#label').val());
            formData.append('full_address', $('#full_address').val());
            formData.append('latitude', $('#latitude').val());
            formData.append('longitude', $('#longitude').val());

            btn.prop('disabled', true).text('Menyimpan...');

            $.ajax({
                url: '/alamat/store',
                method: 'POST',
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
                    location.reload();
                },

                error: function(xhr) {
                    let msg = 'Terjadi kesalahan';

                    if (xhr.responseJSON?.errors) {
                        msg = Object.values(xhr.responseJSON.errors).join('\n');
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

    <script>
        $(function() {
            loadAlamat();

            function generateAlamatCard(alamat) {

                let badge = alamat.is_default ?
                    `<span class="badge bg-success">Default</span>` :
                    `<button class="btn btn-sm btn-outline-primary set-default" data-id="${alamat.id}">
                        Jadikan Default
                </button>`;

                return `
                    <div class="card mb-2 shadow-sm alamat-item" data-id="${alamat.id}">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-start">
                                <strong>${alamat.label ?? 'Alamat'}</strong>
                                ${badge}
                            </div>

                            <p class="text-muted small mt-2 mb-2">
                                ${alamat.full_address}
                            </p>

                            <small class="text-muted">
                                Lat: ${alamat.latitude} <br>
                                Lng: ${alamat.longitude}
                            </small>

                            <div class="mt-3 d-flex justify-content-between">
                                <button class="btn btn-sm btn-danger delete-alamat" data-id="${alamat.id}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                `;
            }

            function loadAlamat() {
                $.get('/alamat/list', function(res) {

                    $('#alamat-container').html('');

                    res.data.forEach(item => {
                        $('#alamat-container').append(generateAlamatCard(item));
                    });

                });
            }

            $(document).on('click', '.set-default', function() {

                let id = $(this).data('id');

                $.ajax({
                    url: '/alamat/set-default/' + id,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message
                        });
                        setTimeout(function(){
                            location.reload()
                        }, 1500)
                    },

                    error: function() {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Gagal',
                            text: 'Gagal set default'
                        });
                    }
                });

            });

            $(document).on('click', '.delete-alamat', function() {

                let id = $(this).data('id');

                if (!confirm('Yakin ingin menghapus alamat ini?')) return;

                $.ajax({
                    url: '/alamat/delete/' + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message
                        });

                        $(`.alamat-item[data-id="${id}"]`).fadeOut(300, function() {
                            $(this).remove();
                            if ($('.alamat-item').length === 0) {
                                loadAlamat();
                            }
                        });
                    },

                    error: function() {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Gagal',
                            text: 'Gagal menghapus alamat'
                        });
                    }
                });

            });
        });
    </script>
@endsection
