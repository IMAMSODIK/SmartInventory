
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});

$(document).ready(function () {
    loadMenu(1);
});

$(".refresh-data").on("click", function () {
    let tableType = $(this).data("table");

    if (tableType === "data") {
        loadMenu(1);
    } else if (tableType === "trash") {
        loadMenu(0);
    }
});

$('#harga').on('keyup', function () {
    let cursorPos = this.selectionStart;
    let value = this.value.replace(/[^0-9]/g, '');

    if (value) {
        this.value = 'Rp ' + formatRupiah(value);
    } else {
        this.value = '';
    }

    this.setSelectionRange(this.value.length, this.value.length);
});

$('#edit_harga').on('keyup', function () {
    let cursorPos = this.selectionStart;
    let value = this.value.replace(/[^0-9]/g, '');

    if (value) {
        this.value = 'Rp ' + formatRupiah(value);
    } else {
        this.value = '';
    }

    this.setSelectionRange(this.value.length, this.value.length);
});

$('#foto_menu').on('change', function () {
    let preview = $('#preview-container');
    preview.html(''); // reset preview

    let files = this.files;

    if (files.length === 0) return;

    Array.from(files).forEach(file => {

        // validasi optional (biar aman)
        if (!file.type.startsWith('image/')) return;

        let reader = new FileReader();

        reader.onload = function (e) {
            let img = `
                <div style="position:relative;">
                    <img src="${e.target.result}" 
                        style="width:100px;height:100px;object-fit:cover;border-radius:8px;">
                </div>
            `;
            preview.append(img);
        };

        reader.readAsDataURL(file);
    });
});

$('#edit_foto_menu').on('change', function () {
    let preview = $('#edit-preview-container');
    preview.html('');

    let files = this.files;

    if (files.length === 0) return;

    Array.from(files).forEach(file => {

        // validasi optional (biar aman)
        if (!file.type.startsWith('image/')) return;

        let reader = new FileReader();

        reader.onload = function (e) {
            let img = `
                <div style="position:relative;">
                    <img src="${e.target.result}" 
                        style="width:100px;height:100px;object-fit:cover;border-radius:8px;">
                </div>
            `;
            preview.append(img);
        };

        reader.readAsDataURL(file);
    });
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

    let namaMenu = $('input[name="nama_menu"]').val();
    if (!namaMenu) {
        alertResult('warning', 'Validasi', 'Nama menu wajib diisi');
        return;
    }

    let form = document.getElementById('formCreate');
    let formData = new FormData(form);
    let harga = $('#harga').val().replace(/[^0-9]/g, '');
    let token = $('meta[name="csrf-token"]').attr('content');

    formData.append('_token', token);
    formData.append('harga', harga);

    $.ajax({
        url: '/daftar-menu/store',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            if (res.success) {

                $('#modalCreate').modal('hide');
                $('#formCreate')[0].reset();
                $('#preview-container').html('');
                $('#preview-container').html('');

                let newCard = $(generateMenuCard(res.data)).hide();
                $('.menu-grid').prepend(newCard);
                newCard.fadeIn(300);

                alertResult('success', 'Berhasil', res.message);
            }
        },
        error: function (err) {
            if (err.status === 422) {
                let errors = err.responseJSON.errors;

                $.each(errors, function (key, value) {
                    $('.error-' + key).text(value[0]);
                });

                alertResult('warning', 'Validasi Gagal', 'Periksa kembali data');
            } else {
                alertResult('error', 'Error', 'Terjadi kesalahan server');
            }
        }
    });
});

$(document).on('click', '.edit-btn', function () {

    let id = $(this).data('id');
    $('.text-danger').text('');
    $('#preview-container').html('');

    $.get('/daftar-menu/' + id, function (res) {

        $('#edit_id').val(res.id);
        $('input[name="edit_nama_menu"]').val(res.nama_menu);
        $('select[name="edit_kategori_menu_id"]').val(res.kategori_menu_id);
        $('input[name="edit_harga"]').val(formatRupiah(res.harga));
        $('textarea[name="edit_deskripsi"]').val(res.deskripsi);

        if (res.foto_menus && res.foto_menus.length > 0) {
            res.foto_menus.forEach(foto => {
                let img = `
                    <div style="position:relative;">
                        <img src="/storage/${foto.foto_path}" 
                            style="width:100px;height:100px;object-fit:cover;border-radius:8px;">
                    </div>
                `;
                $('#edit-preview-container').append(img);
            });
        }

        let modal = new bootstrap.Modal(document.getElementById('modalEdit'));
        modal.show();
    });

});

$('#formEdit').submit(function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    let harga = $('input[name="edit_harga"]').val().replace(/[^0-9]/g, '');
    formData.set('edit_harga', harga);

    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

    $.ajax({
        url: '/daftar-menu/update',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,

        success: function (res) {
            $('#modalEdit').modal('hide');
            $('#formCreate')[0].reset();
            $('#edit-preview-container').html('');
            let newCard = $(generateMenuCard(res.data));

            $(`.switch-ready[data-id="${res.data.id}"]`)
                .closest('.col-xl-3')
                .replaceWith(newCard);

            alertResult('success', 'Berhasil', res.message);
        },

        error: function (err) {
            if (err.status === 422) {
                let errors = err.responseJSON.errors;

                $.each(errors, function (key, value) {
                    $('.error-' + key).text(value[0]);
                });
            }
        }
    });
});

$(document).on('click', '.btn-delete', function () {
    let btn = $(this);
    let id = btn.data('id');

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
                url: '/daftar-menu/delete/' + id,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    if (res.success) {
                        btn.closest('.col-xl-3').fadeOut(300, function () {
                            $(this).remove();
                        });

                        alertResult('success', 'Berhasil', res.message);
                    }
                },
                error: function () {
                    alertResult('error', 'Error', 'Gagal menghapus data');
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
                url: '/daftar-menu/restore/' + id,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    if (res.success) {
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

$(document).on('change', '.switch-ready', function () {

    let checkbox = $(this);
    let id = checkbox.data('id');

    $.ajax({
        url: '/daftar-menu/toggle-ready',
        type: 'POST',
        data: {
            id: id,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            if (res.success) {
                if (res.is_ready) {
                    alertResult('success', 'Berhasil', 'Menu akan ditampilkan');
                    checkbox.closest('.card').removeClass('opacity-50');
                } else {
                    alertResult('success', 'Berhasil', 'Menu akan disembunyikan');
                    checkbox.closest('.card').addClass('opacity-50');
                }
            } else {
                alertResult('error', 'Error', 'Gagal mengubah status ready menu');
            }
        },
        error: function () {
            alertResult('error', 'Error', 'Terjadi kesalahan server');
            checkbox.prop('checked', !checkbox.prop('checked'));
        }
    });

});

$(document).on('change', '.filter-kategori, input[name="filter_ready"], input[name="filter_status"]', function () {
    loadMenu();
});

$('.reset-filter').on('click', function () {

    $('.filter-kategori').prop('checked', false);
    $('input[name="filter_ready"][value=""]').prop('checked', true);
    $('input[name="filter_status"][value="1"]').prop('checked', true);

    loadMenu();
});

let searchTimeout = null;

$('#search-menu').on('keyup', function () {
    clearTimeout(searchTimeout);

    let keyword = $(this).val();
    searchTimeout = setTimeout(function () {
        loadMenu();
    }, 300);
});

let tableTrash = $('#dataTableTrash').DataTable({
    processing: true,
    ajax: {
        url: '/daftar-menu/data-table',
        dataSrc: 'data',
        data: function (d) {
            d.status = 0;
        }
    },
    columnDefs: [{
        targets: [0, 2, 3, 5],
        className: 'text-center'
    }],
    columns: [{
        data: null,
        render: function (data, type, row, meta) {
            return meta.row + 1;
        }
    },
    {
        data: 'nama_menu'
    },
    { data: 'kategori_menu.nama_kategori' },
    {
        data: 'is_ready',
        render: function (data) {
            return data ?
                '<span class="badge bg-success">Tersedia</span>' :
                '<span class="badge bg-secondary">Tidak Tersedia</span>';
        }
    },
    {
        data: 'harga',
        render: function (data) {
            return 'Rp ' + formatRupiah(data);
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

$(".refresh-data-table").on("click", function () {
    let tableType = $(this).data("table");
    if (tableType === "data") {
        table.ajax.reload(null, false);
    } else if (tableType === "trash") {
        tableTrash.ajax.reload(null, false);
    }
})