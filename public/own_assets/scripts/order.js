$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});

function getBadgeClass(status) {
    if (status === 'pending') return 'bg-warning';
    if (status === 'processing') return 'bg-primary';
    if (status === 'shipping') return 'bg-dark';
    if (status === 'delivered') return 'bg-success';
    return 'bg-secondary';
}

function generateActionButton(item) {

    if (item.status === 'pending') {
        return `<button class="btn btn-sm btn-primary process-btn" data-id="${item.id}">Proses</button>`;
    }

    if (item.status === 'processing') {
        return `<button class="btn btn-sm btn-warning ship-btn" data-id="${item.id}">Kirim</button>`;
    }

    if (item.status === 'shipping') {
        return `<button class="btn btn-sm btn-success done-btn" data-id="${item.id}">Selesai</button>`;
    }

    return `<span class="text-success">Selesai</span>`;
}
let userRole = $('#user_role').val();
let table = $('#dataTable').DataTable({
    processing: true,
    ajax: {
        url: '/daftar-order/data',
        dataSrc: 'data'
    },
    columnDefs: [
        { targets: '_all', className: 'align-middle' },
        { targets: [0, 3, 4, 5, 6], className: 'text-center' }
    ],
    columns: [
        {
            data: null,
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        { data: 'order_id' },
        ...(userRole === 'admin'
            ? [{ data: 'store_name' }]
            : []),
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

let tableDone = $('#dataTableDone').DataTable({
    processing: true,
    ajax: {
        url: '/daftar-order/data',
        dataSrc: 'data',
        data: function (d) {
            d.status = 'done';
        }
    },
    columnDefs: [
        { targets: '_all', className: 'align-middle' },
        { targets: [0, 3, 4, 5, 6], className: 'text-center' }
    ],
    columns: [
        {
            data: null,
            render: (data, type, row, meta) => meta.row + 1
        },
        { data: 'order_id' },
        ...(userRole === 'admin'
            ? [{ data: 'store_name' }]
            : []),
        { data: 'buyer_name' },
        { data: 'item_summary' },
        {
            data: 'total',
            render: data => 'Rp ' + formatRupiah(data)
        },
        {
            data: 'status',
            render: status => `<span class="badge bg-success">${status}</span>`
        },
        { data: 'created_at' },
        {
            data: 'id',
            render: function (data) {
                return `
                    <button class="btn btn-sm btn-info detail-btn" data-id="${data}" data-page="done">Detail</button>
                    <button class="btn btn-sm btn-danger destroy-btn" data-id="${data}">Hapus</button>
                `;
            }
        }
    ]
});

$(document).on('click', '.detail-btn', function () {

    let id = $(this).data('id');

    $.get('/order/detail/' + id, function (res) {

        $('#order-id').text('Order: ' + res.order_id);

        let html = '';

        res.items.forEach(item => {

            html += `
                <tr>
                    <td>${item.produk}</td>
                    <td>${item.qty}</td>
                    <td>Rp ${formatRupiah(item.harga)}</td>
                    <td>
                        <span class="badge bg-info">${item.status}</span>
                    </td>
                    <td class="action-cell">
                        ${generateActionButton(item)}
                    </td>
                </tr>
            `;
        });

        $('#order-items').html(html);

        new bootstrap.Modal(document.getElementById('modalDetailOrder')).show();
    });

});

$(document).on('click', '.process-btn, .ship-btn, .done-btn', function () {

    let btn = $(this);
    let id = btn.data('id');

    let status = 'processing';

    if (btn.hasClass('ship-btn')) status = 'shipping';
    if (btn.hasClass('done-btn')) status = 'delivered';

    $.ajax({
        url: '/order/update-status',
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            item_id: id,
            status: status
        },

        success: function (res) {
            let row = btn.closest('tr');
            let badge = row.find('.status-badge');

            badge
                .removeClass('bg-warning bg-info bg-primary bg-dark bg-success')
                .addClass(getBadgeClass(status))
                .text(status);
            row.find('.action-cell').html(generateActionButton({
                id: id,
                status: status
            }));

            alertResult('success', 'Berhasil', res.message);
        },

        error: function () {
            alertResult('warning', 'Gagal', 'Gagal update data');
        }
    });
});

$(document).on('click', '.destroy-btn', function () {

    let id = $(this).data('id');

    if (!confirm('Hapus transaksi ini?')) return;

    $.ajax({
        url: '/daftar-order/destroy/' + id,
        method: 'DELETE',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function () {
            tableDone.ajax.reload(null, false);
            toastr.success('Berhasil dihapus');
        },
        error: function () {
            toastr.error('Gagal hapus');
        }
    });

});

// $(document).on('click', '.restore-btn', function () {
//     let id = $(this).data('id');

//     Swal.fire({
//         title: 'Yakin?',
//         text: "Apakah anda ingin mengembalikan data ini?",
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonText: 'Ya, kembalikan!',
//         cancelButtonText: 'Batal'
//     }).then((result) => {
//         if (result.isConfirmed) {

//             $.ajax({
//                 url: '/users/restore/' + id,
//                 type: 'POST',
//                 data: {
//                     _token: $('meta[name="csrf-token"]').attr('content')
//                 },
//                 success: function (res) {
//                     if (res.success) {
//                         tableTrash.ajax.reload(null, false);
//                         alertResult('success', 'Berhasil', res.message);
//                     } else {
//                         alertResult('warning', 'Pengembalian Data Gagal', 'Gagal mengembalikan data');
//                     }
//                 },
//                 error: function () {
//                     alertResult('error', 'Error', 'Terjadi kesalahan server');
//                 }
//             });

//         }
//     });
// });

$(".refresh-data").on("click", function () {
    let tableType = $(this).data("table");
    if (tableType === "data") {
        table.ajax.reload(null, false);
    } else if (tableType === "trash") {
        tableTrash.ajax.reload(null, false);
    }
})