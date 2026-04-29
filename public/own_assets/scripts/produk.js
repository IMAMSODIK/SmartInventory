
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

$('#price').on('keyup', function () {
    let cursorPos = this.selectionStart;
    let value = this.value.replace(/[^0-9]/g, '');

    if (value) {
        this.value = 'Rp ' + formatRupiah(value);
    } else {
        this.value = '';
    }

    this.setSelectionRange(this.value.length, this.value.length);
});

$('#edit_price').on('keyup', function () {
    let cursorPos = this.selectionStart;
    let value = this.value.replace(/[^0-9]/g, '');

    if (value) {
        this.value = 'Rp ' + formatRupiah(value);
    } else {
        this.value = '';
    }

    this.setSelectionRange(this.value.length, this.value.length);
});

$('#foto_produk').on('change', function () {
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

$('#edit_foto_produk').on('change', function () {
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

    let form = document.getElementById('formCreate');
    let formData = new FormData(form);

    let price = $('#price').val().replace(/[^0-9]/g, '');
    let token = $('meta[name="csrf-token"]').attr('content');

    formData.append('_token', token);
    formData.append('price', price);

    $.ajax({
        url: '/daftar-produk/store',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            if (res.success) {

                $('#modalCreate').modal('hide');
                $('#formCreate')[0].reset();
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
    $('#edit-preview-container').html('');

    $.get('/daftar-produk/' + id, function (res) {

        $('#edit_id').val(res.id);
        $('input[name="edit_name"]').val(res.name);
        $('select[name="edit_kategori_id"]').val(res.kategori_id);
        $('input[name="edit_price"]').val(formatRupiah(res.price));
        $('input[name="edit_stock"]').val(res.stock);
        $('input[name="edit_unit"]').val(res.unit);
        $('textarea[name="edit_description"]').val(res.description);

        // preview foto lama
        if (res.foto_produks && res.foto_produks.length > 0) {
            res.foto_produks.forEach(foto => {
                let img = `
                    <div>
                        <img src="/storage/${foto.image}" 
                            style="width:100px;height:100px;object-fit:cover;border-radius:8px;">
                    </div>
                `;
                $('#edit-preview-container').append(img);
            });
        }

        new bootstrap.Modal(document.getElementById('modalEdit')).show();
    });

});

$('#formEdit').submit(function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    let price = $('input[name="edit_price"]').val().replace(/[^0-9]/g, '');
    formData.set('edit_price', price);

    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

    $.ajax({
        url: '/daftar-produk/update',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,

        success: function (res) {

            $('#modalEdit').modal('hide');
            $('#formEdit')[0].reset();
            $('#edit-preview-container').html('');

            let newCard = $(generateMenuCard(res.data));

            $(`.produk-item[data-id="${res.data.id}"]`).replaceWith(newCard);

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
                url: '/daftar-produk/delete/' + id,
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
                url: '/daftar-produk/restore/' + id,
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
        url: '/daftar-produk/data-table',
        dataSrc: 'data',
        data: function (d) {
            d.status = 0;
        }
    },
    columnDefs: [{
        targets: [0, 2, 3, 4, 5, 6],
        className: 'text-center'
    }],
    columns: [{
        data: null,
        render: function (data, type, row, meta) {
            return meta.row + 1;
        }
    },
    // $table->foreignId('kategori_id');
    // $table->foreignId('profile_usaha_id')->constrained()->cascadeOnDelete();

    // $table->string('name');
    // $table->text('description')->nullable();

    // $table->decimal('price', 12, 2);
    // $table->integer('stock')->default(0);

    // $table->string('unit')->nullable(); // kg, ton, liter
    {
        data: 'name'
    },
    { data: 'kategori.nama_kategori' },
    { data: 'stock' },
    {
        data: 'price',
        render: function (data) {
            return 'Rp ' + formatRupiah(data);
        }
    },
    {
        data: 'is_approved',
        render: function (data) {
            return data ?
                '<span class="badge bg-success">Pending</span>' :
                '<span class="badge bg-secondary">Diterima</span>';
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