$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});

let table = $('#dataTable').DataTable({
    processing: true,
    ajax: {
        url: '/daftar-order/data',
        dataSrc: 'data'
    },
    columnDefs: [
        { targets: '_all', className: 'align-middle' },
        { targets: [0,3,4,5,6], className: 'text-center' }
    ],
    columns: [
        {
            data: null,
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        { data: 'order_id' },
        { data: 'buyer_name' },
        { data: 'item_summary' },
        {
            data: 'total',
            render: function (data) {
                return 'Rp ' + formatRupiah(data);
            }
        },
        {
            data: 'status',
            render: function (status) {

                let badge = {
                    pending: 'warning',
                    paid: 'info',
                    processing: 'primary',
                    shipping: 'dark'
                };

                return `<span class="badge bg-${badge[status] ?? 'secondary'}">${status}</span>`;
            }
        },
        { data: 'created_at' },
        {
            data: 'id',
            render: function (data) {
                return `
                    <button class="btn btn-sm btn-info detail-btn" data-id="${data}">Detail</button>
                `;
            }
        }
    ]
});

// setInterval(() => {
//     table.ajax.reload(null, false);
// }, 2000);

let tableTrash = $('#dataTableTrash').DataTable({
    processing: true,
    ajax: {
        url: '/daftar-order/data',
        dataSrc: 'data',
        data: function (d) {
            d.status = 0;
        }
    },
    columnDefs: [{
        targets: [0, 3, 4, 5],
        className: 'text-center'
    }],
    columns: [{
        data: null,
        render: function (data, type, row, meta) {
            return meta.row + 1;
        }
    },
    {
        data: 'name'
    },
    {
        data: 'email'
    },
    {
        data: 'status',
        render: function (data) {
            return data ?
                '<span class="badge bg-success">Active</span>' :
                '<span class="badge bg-secondary">Inactive</span>';
        }
    },
    {
        data: 'role',
        render: function (data) {
            let roleClass = '';
            switch (data) {
                case 'admin':
                    roleClass = 'bg-primary';
                    break;
                case 'pedagang':
                    roleClass = 'bg-info';
                    break;
                case 'pembeli':
                    roleClass = 'bg-warning';
                    break;
                case 'kurir':
                    roleClass = 'bg-secondary';
                    break;
            }
            return `<span class="badge ${roleClass}">${data.charAt(0).toUpperCase() + data.slice(1)}</span>`;
        }
    },
    {
        data: 'id',
        className: 'text-nowrap',
        render: function (data) {
            return `
                            <button class="btn btn-sm btn-primary restore-btn" data-id="${data}"><i class="fa fa-retweet" aria-hidden="true"></i></button>
                            <button class="btn btn-sm btn-danger destroy-btn" data-id="${data}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            <button class="btn btn-sm btn-info detail-btn" data-id="${data}" data-page="trash">Detail</button>
                        `;
        }
    }
    ]
});

$('#tambah-data').on('click', function () {
    $('#formCreate')[0].reset();
    $('.text-danger').text('');

    let modal = new bootstrap.Modal(document.getElementById('modalCreate'));
    modal.show();
});

$('#formCreate').submit(function (e) {
    e.preventDefault();

    $('.text-danger').text('');

    let form = document.getElementById('formCreate');
    let formData = new FormData(form);

    let token = $('meta[name="csrf-token"]').attr('content');
    formData.append('_token', token);

    $.ajax({
        url: '/users/store',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            if (res.success) {
                $('#modalCreate').modal('hide');

                $('#formCreate')[0].reset();
                $('#preview-foto').hide();

                table.ajax.reload(null, false);

                alertResult('success', 'Berhasil', res.message);
            }
        },
        error: function (err) {
            if (err.status === 422) {
                let errors = err.responseJSON.errors;

                $.each(errors, function (key, value) {
                    $('.error-' + key).text(value[0]);
                });

                alertResult('warning', 'Validasi Gagal', 'Periksa kembali data kamu');

            } else {
                alertResult('error', 'Error', 'Terjadi kesalahan server');
            }
        }
    });
});

$(document).on('click', '.edit-btn', function () {
    let id = $(this).data('id');

    $('.text-danger').text('');

    $.get('/users/' + id, function (res) {
        $('#edit_id').val(res.id);
        $('#edit_name').val(res.name);
        $('#edit_email').val(res.email);
        $('#edit_role').val(res.role);

        if (res.foto) {
            $('#preview-edit_foto')
                .attr('src', '../../storage/' + res.foto)
                .show();
        } else {
            $('#preview-edit_foto').hide();
        }

        let modal = new bootstrap.Modal(document.getElementById('modalEdit'));
        modal.show();
    });
});

$(document).on('click', '.detail-btn', function () {
    let id = $(this).data('id');
    let button = $(this).data('page');

    $('.text-danger').text('');

    $.get('/user/detail/' + id, function (res) {

        $('#detail_id').val(res.id);
        $('#detail_name').val(res.name);
        $('#detail_email').val(res.email);
        $('#detail_role').val(res.role);

        // FOTO USER
        if (res.foto) {
            $('#preview-detail_foto')
                .attr('src', '/storage/' + res.foto)
                .show();
        } else {
            $('#preview-detail_foto')
                .attr('src', '/own_assets/images/avatar.png')
                .show();
        }

        // BUTTON
        if (button == 'data') {
            $("#verif-button").hide();
        } else {
            $("#verif-button").show();
        }

        // 🔥 PEDAGANG (USAHA)
        if (res.role == 'pedagang' && res.profile_usaha) {

            $(".detail-usaha").show();
            $(".detail-driver").hide();

            $('#nama_usaha').val(res.profile_usaha.store_name);
            $('#deskripsi_usaha').val(res.profile_usaha.description);

            // LOGO USAHA
            if (res.profile_usaha.store_photo) {
                $('#preview-logo_usaha')
                    .attr('src', '/storage/' + res.profile_usaha.store_photo)
                    .show();
            } else {
                $('#preview-logo_usaha')
                    .attr('src', '/own_assets/images/avatar.png')
                    .show();
            }

            // LAT LONG
            let lat = res.profile_usaha.latitude;
            let lng = res.profile_usaha.longitude;

            $('#detail_latitude').val(lat);
            $('#detail_longitude').val(lng);

            // INIT MAP
            setTimeout(() => {
                initMapDetail(lat, lng);
            }, 300);

        }

        else if (res.role == 'kurir' && res.driver) {
            $(".detail-usaha").hide();
            $(".detail-driver").show();

            $('#driver_vehicle').val(res.driver.vehicle_type ?? '-');
            $('#driver_plate').val(res.driver.plate_number ?? '-');
            $('#driver_rating').val(res.driver.rating ?? '0');
            $('#driver_total').val(res.driver.total_delivery ?? '0');
        }

        else {
            $(".detail-usaha").hide();
            $(".detail-driver").hide();
        }

        new bootstrap.Modal(document.getElementById('modalDetail')).show();
    });
});

$('#formEdit').submit(function (e) {
    e.preventDefault();

    $('.text-danger').text('');

    let id = $('#edit_id').val();
    let formData = new FormData(this);
    let token = $('meta[name="csrf-token"]').attr('content');
    formData.append('_token', token);

    $.ajax({
        url: '/users/update/' + id,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            if (res.success) {
                $('#modalEdit').modal('hide');

                table.ajax.reload(null, false);

                alertResult('success', 'Berhasil', res.message);
            }
        },
        error: function (err) {
            if (err.status === 422) {
                let errors = err.responseJSON.errors;

                $.each(errors, function (key, value) {
                    $('#formEdit .error-' + key).text(value[0]);
                });

                alertResult('warning', 'Validasi Gagal', 'Periksa kembali data');
            } else {
                alertResult('error', 'Error', 'Terjadi kesalahan server');
            }
        }
    });
});

$(document).on('click', '.delete-btn', function () {
    let id = $(this).data('id');

    Swal.fire({
        title: 'Yakin?',
        text: "Apakah anda yakin ingin menonaktifkan data?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Nonaktifkan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: '/users/delete/' + id,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    if (res.success) {
                        table.ajax.reload(null, false);
                        alertResult('success', 'Berhasil', res.message);
                    } else {
                        alertResult('warning', 'Nonaktifkan Data Gagal', 'Gagal menonaktifkan data');
                    }
                },
                error: function () {
                    alertResult('error', 'Error', 'Terjadi kesalahan server');
                }
            });

        }
    });
});

$(document).on('click', '.destroy-btn', function () {
    let id = $(this).data('id');

    Swal.fire({
        title: 'Yakin?',
        text: "Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: '/users/destroy/' + id,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    if (res.success) {
                        tableTrash.ajax.reload(null, false);
                        alertResult('success', 'Berhasil', res.message);
                    } else {
                        alertResult('warning', 'Hapus Data Gagal', 'Gagal menghapus data');
                    }
                },
                error: function () {
                    alertResult('error', 'Error', 'Terjadi kesalahan server');
                }
            });

        }
    });
});

$(document).on('click', '.restore-btn', function () {
    let id = $(this).data('id');

    Swal.fire({
        title: 'Yakin?',
        text: "Apakah anda ingin mengembalikan data ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, kembalikan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: '/users/restore/' + id,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    if (res.success) {
                        tableTrash.ajax.reload(null, false);
                        alertResult('success', 'Berhasil', res.message);
                    } else {
                        alertResult('warning', 'Pengembalian Data Gagal', 'Gagal mengembalikan data');
                    }
                },
                error: function () {
                    alertResult('error', 'Error', 'Terjadi kesalahan server');
                }
            });

        }
    });
});

$(".refresh-data").on("click", function () {
    let tableType = $(this).data("table");
    if (tableType === "data") {
        table.ajax.reload(null, false);
    } else if (tableType === "trash") {
        tableTrash.ajax.reload(null, false);
    }
})