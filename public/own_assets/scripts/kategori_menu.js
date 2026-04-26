
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});

let table = $('#dataTable').DataTable({
    processing: true,
    ajax: {
        url: '/kategori-menu/data',
        dataSrc: 'data',
        data: function (d) {
            d.status = 1;
        }
    },
    columnDefs: [{
        targets: [0, 2, 3, 4],
        className: 'text-center'
    }],
    columns: [{
        data: null,
        render: function (data, type, row, meta) {
            return meta.row + 1;
        }
    },
    {
        data: 'nama_kategori'
    },
    {
        data: 'icon',
        render: function (data) {
            if (data) {
                return `<img src="../../storage/${data}" alt="Icon" width="100">`;
            } else {
                return '<span class="text-muted">No Icon</span>';
            }
        }
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
        data: 'id',
        render: function (data) {
            return `
                            <button class="btn btn-sm btn-primary edit-btn" data-id="${data}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${data}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        `;
        }
    }
    ]
});

let tableTrash = $('#dataTableTrash').DataTable({
    processing: true,
    ajax: {
        url: '/kategori-menu/data',
        dataSrc: 'data',
        data: function (d) {
            d.status = 0;
        }
    },
    columnDefs: [{
        targets: [0, 2, 3, 4],
        className: 'text-center'
    }],
    columns: [{
        data: null,
        render: function (data, type, row, meta) {
            return meta.row + 1;
        }
    },
    {
        data: 'nama_kategori'
    },
    {
        data: 'icon',
        render: function (data) {
            if (data) {
                return `<img src="../../storage/${data}" alt="Icon" width="100">`;
            } else {
                return '<span class="text-muted">No Icon</span>';
            }
        }
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
        data: 'id',
        render: function (data) {
            return `
                            <button class="btn btn-sm btn-primary restore-btn" data-id="${data}"><i class="fa fa-retweet" aria-hidden="true"></i></button>
                        `;
        }
    }
    ]
});
{/* <button class="btn btn-sm btn-danger destroy-btn" data-id="${data}"><i class="fa fa-trash" aria-hidden="true"></i></button> */}

$('#tambah-data').on('click', function () {
    $('#formCreate')[0].reset();
    $('.text-danger').text('');

    let modal = new bootstrap.Modal(document.getElementById('modalCreate'));
    modal.show();
});

$('#formCreate').submit(function (e) {
    e.preventDefault();
    $('.text-danger').text('');

    let namaKategori = $('input[name="nama_kategori"]').val();
    if (!namaKategori) {
        alertResult('warning', 'Validasi', 'Nama kategori wajib diisi');
        return;
    }

    let form = document.getElementById('formCreate');
    let formData = new FormData(form);
    let token = $('meta[name="csrf-token"]').attr('content');

    formData.append('_token', token);

    $.ajax({
        url: '/kategori-menu/store',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            if (res.success) {
                $('#modalCreate').modal('hide');
                $('#formCreate')[0].reset();

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

    $.get('/kategori-menu/' + id, function (res) {
        $('#edit_id').val(res.id);
        $('#edit_nama_kategori').val(res.nama_kategori);

        if (res.icon) {
            $('#preview-edit_icon')
                .attr('src', '../../storage/' + res.icon)
                .show();
        } else {
            $('#preview-edit_icon').hide();
        }

        let modal = new bootstrap.Modal(document.getElementById('modalEdit'));
        modal.show();
    });
});

$('#formEdit').submit(function (e) {
    e.preventDefault();
    $('.text-danger').text('');

    let namaKategori = $('#edit_nama_kategori').val();
    let id = $('#edit_id').val();
    if (!namaKategori) {
        alertResult('warning', 'Validasi', 'Nama Kategori wajib diisi');
        return;
    }

    let form = document.getElementById('formEdit');
    let formData = new FormData(form);
    let token = $('meta[name="csrf-token"]').attr('content');

    formData.append('_token', token);

    $.ajax({
        url: '/kategori-menu/update/' + id,
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
        text: "Apakah anda yakin ingin menghapus data?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: '/kategori-menu/delete/' + id,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    if (res.success) {
                        table.ajax.reload(null, false);
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
                url: '/kategori-menu/restore/' + id,
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