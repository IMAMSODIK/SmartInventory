<!-- latest jquery-->
<script src="{{ asset('dashboard_assets/assets/js/jquery.min.js') }}"></script>
<!-- Bootstrap js-->
<script src="{{ asset('dashboard_assets/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
<!-- feather icon js-->
<script src="{{ asset('dashboard_assets/assets/js/icons/feather-icon/feather.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/icons/feather-icon/feather-icon.js') }}"></script>
<!-- scrollbar js-->
<script src="{{ asset('dashboard_assets/assets/js/scrollbar/simplebar.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/scrollbar/custom.js') }}"></script>
<!-- Sidebar jquery-->
<script src="{{ asset('dashboard_assets/assets/js/config.js') }}"></script>
<!-- Plugins JS start-->
<script src="{{ asset('dashboard_assets/assets/js/sidebar-menu.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/sidebar-pin.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/slick/slick.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/slick/slick.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/header-slick.js') }}"></script>
{{-- <script src="{{ asset('dashboard_assets/assets/js/chart/apex-chart/apex-chart.js') }}"></script> --}}
<script src="{{ asset('dashboard_assets/assets/js/chart/apex-chart/stock-prices.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/chart/apex-chart/apex-chart.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/chart/apex-chart/moment.min.js') }}"></script>
<!-- Range Slider js-->
<script src="{{ asset('dashboard_assets/assets/js/range-slider/rSlider.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/rangeslider/rangeslider.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/prism/prism.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/clipboard/clipboard.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/counter/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/counter/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/counter/counter-custom.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/custom-card/custom-card.js') }}"></script>
<!-- calendar js-->
<script src="{{ asset('dashboard_assets/assets/js/calendar/fullcalender.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/calendar/custom-calendar.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/dashboard/dashboard_2.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/animation/wow/wow.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{ asset('dashboard_assets/assets/js/script.js') }}"></script>
<script src="{{ asset('dashboard_assets/assets/js/theme-customizer/customizer.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let lastOrderHash = null;

    function loadDriverOrders() {

        $.get('/driver/incoming-order', function(res) {

            if (!res.status) {
                $('#driverOrders').html(`
                <div class="alert alert-secondary">
                    Tidak ada order masuk
                </div>
            `);
                return;
            }

            let currentHash = JSON.stringify(res.data);

            if (currentHash === lastOrderHash) {
                return;
            }

            lastOrderHash = currentHash;

            let html = '';

            Object.values(res.data).forEach(group => {

                let firstItem = group[0];

                let order = firstItem.order;

                let customer = order.buyer;

                let alamat = order.alamat;

                let deliveryStatus = firstItem.delivery_status;

                let totalBelanja = 0;

                // ambil seller dari item pertama
                let seller =
                    firstItem.produk?.profile_usaha;

                let sellerUser =
                    seller?.user;

                html += `
            <div class="card shadow border-0 mb-4 rounded-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="fw-bold text-success">
                            ORDER #${order.order_id}
                        </h4>

                        <span class="badge bg-primary text-uppercase">
                            ${deliveryStatus}
                        </span>
                    </div>

                    <hr>

                    <h5 class="fw-bold mb-3">
                        👤 Data Customer
                    </h5>

                    <p class="mb-1">
                        <strong>Nama:</strong>
                        ${customer.name}
                    </p>

                    <p class="mb-1">
                        <strong>HP:</strong>
                        ${customer.phone ?? '-'}
                    </p>

                    <p class="mb-2">
                        <strong>Alamat:</strong>
                        ${alamat.full_address}
                    </p>

                    <div class="mb-4">
                        <a href="https://www.google.com/maps?q=${alamat.latitude},${alamat.longitude}"
                           target="_blank"
                           class="btn btn-sm btn-outline-primary">
                           📍 Lihat Lokasi Customer
                        </a>
                    </div>
            `;

                // SELLER
                if (seller) {

                    html += `
                    <h5 class="fw-bold mb-3">
                        🏪 Data Penjual
                    </h5>

                    <p class="mb-1">
                        <strong>Toko:</strong>
                        ${seller.store_name}
                    </p>

                    <p class="mb-1">
                        <strong>Pemilik:</strong>
                        ${sellerUser?.name ?? '-'}
                    </p>

                    <div class="mb-4">
                        <a href="https://www.google.com/maps?q=${seller.latitude},${seller.longitude}"
                           target="_blank"
                           class="btn btn-sm btn-outline-success">
                           📍 Lihat Lokasi Penjual
                        </a>
                    </div>
                `;
                }

                html += `
                <h5 class="fw-bold mb-3">
                    🛒 Barang Dibeli
                </h5>

                <div class="table-responsive">
                    <table class="table table-bordered">

                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>
            `;

                group.forEach(item => {

                    let subtotal =
                        parseFloat(item.harga) * item.qty;

                    totalBelanja += subtotal;

                    html += `
                    <tr>
                        <td>${item.nama_produk}</td>

                        <td>${item.qty}</td>

                        <td>
                            ${formatRupiah(item.harga)}
                        </td>

                        <td>
                            ${formatRupiah(subtotal)}
                        </td>
                    </tr>
                `;
                });

                html += `
                        </tbody>
                    </table>
                </div>

                <div class="bg-light p-3 rounded-3 mt-3">

                    <div class="d-flex justify-content-between">
                        <span>Total Belanja</span>
                        <strong>
                            ${formatRupiah(totalBelanja)}
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span>Ongkos Kirim</span>
                        <strong>
                            ${formatRupiah(order.shipping_cost)}
                        </strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <span>Grand Total</span>

                        <strong class="text-success fs-5">
                            ${formatRupiah(order.total)}
                        </strong>
                    </div>

                </div>

                <div class="mt-4 d-flex flex-wrap gap-2">
            `;

                // ACTION BUTTON

                if (deliveryStatus === 'assigned') {

                    html += `
                        <button
                            class="btn btn-primary btn-accept-order"
                            data-id="${order.id}">
                            ✅ Terima Order
                        </button>
                    `;
                }

                if (deliveryStatus === 'picked') {

                    html += `
                        <button
                            class="btn btn-warning btn-start-delivery"
                            data-id="${order.id}">
                            🚚 Antar Sekarang
                        </button>
                    `;
                }

                if (deliveryStatus === 'on_delivery') {

                    html += `
                        <button
                            class="btn btn-success btn-complete"
                            data-id="${order.id}">
                            ✅ Selesaikan Pesanan
                        </button>
                    `;
                }

                if (deliveryStatus === 'delivered') {

                    html += `
                        <button
                            class="btn btn-secondary"
                            disabled>
                            ✔ Pesanan Selesai
                        </button>
                    `;
                }

                // tombol maps cepat
                html += `
                <a href="https://www.google.com/maps/dir/?api=1&destination=${alamat.latitude},${alamat.longitude}"
                   target="_blank"
                   class="btn btn-dark">
                   🗺️ Navigasi
                </a>
            `;

                // tombol telpon
                if (customer.phone) {

                    html += `
                    <a href="tel:${customer.phone}"
                       class="btn btn-info text-white">
                       📞 Hubungi Customer
                    </a>
                `;
                }

                html += `
                </div>

                </div>
            </div>
            `;
            });

            $('#driverOrders').html(html);
        });
    }

    $(document).on('click', '.btn-accept-order', function() {

        let id = $(this).data('id');

        $.ajax({
            url: `/driver/order/${id}/accept`,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {

                alert(res.message);

                loadDriverOrders();
            },
            error: function(err) {

                alert('Gagal menerima order');
            }
        });
    });

    $(document).on('click', '.btn-start-delivery', function() {

        let id = $(this).data('id');

        $.ajax({
            url: `/driver/order/${id}/delivery`,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {

                alert(res.message);

                loadDriverOrders();
            }
        });
    });

    $(document).on('click', '.btn-complete', function() {

        let id = $(this).data('id');

        $.ajax({
            url: `/driver/order/${id}/complete`,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {

                alert(res.message);

                loadDriverOrders();
            }
        });
    });

    $('#btn-hide-order').click(function() {
        $('#incoming-order-wrapper').fadeOut();
    });
</script>

<script>
    setInterval(() => {
        loadDriverOrders();
    }, 5000);
</script>

<script>
    let trackingInterval = null;

    function startTracking() {

        if (trackingInterval) return;

        trackingInterval = setInterval(() => {

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {

                    let lat = position.coords.latitude;
                    let lng = position.coords.longitude;

                    $.post('/driver/update-location', {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        lat: lat,
                        lng: lng
                    });

                });
            }

        }, 5000);
    }

    function stopTracking() {
        clearInterval(trackingInterval);
        trackingInterval = null;
    }
</script>

<script>
    new WOW().init();
    $(document).ready(function() {

        $.get('/driver/status', function(res) {
            $('#driver-status').prop('checked', res.is_online == 1);
            if (res.is_online == 1) {
                startTracking();
            }
        });

    });

    $("#logout").on("click", function() {
        let token = $("meta[name='csrf-token']").attr('content');
        $.ajax({
            url: '/logout',
            method: 'POST',
            data: {
                "_token": token
            },
            success: function(response) {
                location.href = '/login'
            },
            error: function(response) {
                alert(response.message);
            }
        })
    })

    function closeModal(element) {
        element.modal("hide");
    }

    function alertResult(status, title, message) {
        if (status === 'error' || status === 'warning') {
            Swal.fire({
                icon: status,
                title: title,
                text: message,
            });
        } else {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: message,
                timer: 2000,
                showConfirmButton: false
            });
        }
    }

    function slugify(text) {
        return text
            .toString()
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-');
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    function formatTanggal(data) {
        moment.locale('id');
        return data ? moment(data).format('DD MMMM YYYY HH:mm') + ' WIB' : '-';
    }

    function formatTanggalBooking(data) {
        moment.locale('id');
        return data ? moment(data).format('DD MMMM YYYY') : '-';
    }

    function formatRupiah(angka) {
        if (!angka) return 'Tidak ada data';
        angka = Math.floor(angka);

        return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    $(document).on('change', 'input[type="file"]', function(e) {
        let input = this;
        let file = input.files[0];

        if (!file) return;

        let id = $(input).attr('id');
        let preview = $('#preview-' + id);

        if (preview.length === 0) return;

        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar!');
            $(input).val('');
            preview.hide();
            return;
        }

        let reader = new FileReader();
        reader.onload = function(e) {
            preview
                .attr('src', e.target.result)
                .show();
        };

        reader.readAsDataURL(file);
    });
</script>

<script>
    $('#driver-status').on('change', function() {

        let isOnline = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: '/driver/toggle-status',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                is_online: isOnline
            },

            success: function(res) {
                if (res.success) {
                    if (isOnline) {
                        startTracking();
                    } else {
                        stopTracking();
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message,
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Gagal',
                        text: 'Gagal update status',
                    });
                }

            },

            error: function() {
                toastr.error('Terjadi kesalahan');
                $('#driver-status').prop('checked', !isOnline);
            }
        });

    });
</script>

@yield('own_script')
