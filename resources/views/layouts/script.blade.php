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
    function loadDriverOrders() {
        $.get('/driver/incoming-order', function(res) {

            if (!res.status) {
                $('#driverOrders').html('<p>Tidak ada order</p>');
                return;
            }

            let html = '';

            Object.values(res.data).forEach(group => {

                let order = group[0].order;
                let status = group[0].delivery_status;

                html += `
            <div class="card mb-3 shadow-sm">
                <div class="card-body">

                    <h5>Order: ${order.order_id}</h5>
                    <p>Customer: ${order.buyer.name}</p>
                    <p>Alamat: ${order.alamat.full_address}</p>

                    <hr>
            `;

                group.forEach(item => {
                    html += `<p>${item.nama_produk} x ${item.qty}</p>`;
                });

                html += `<div class="mt-3">`;

                if (status === 'accepted') {
                    html += `
                    <button class="btn btn-warning btn-shipping" data-id="${order.id}">
                        🚚 Kirim Sekarang
                    </button>
                `;
                }

                if (status === 'shipping') {
                    html += `
                    <button class="btn btn-success btn-complete" data-id="${order.id}">
                        ✅ Selesaikan
                    </button>
                `;
                }

                html += `</div></div></div>`;
            });

            $('#driverOrders').html(html);
        });
    }

    $(document).on('click', '.btn-shipping', function() {
        let id = $(this).data('id');

        $.post('/driver/shipping/' + id, {
            _token: csrf
        }, function() {
            loadDriverOrders();
        });
    });

    $(document).on('click', '.btn-complete', function() {
        let id = $(this).data('id');

        $.post('/driver/complete/' + id, {
            _token: csrf
        }, function() {
            loadDriverOrders();
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
