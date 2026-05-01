<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>{{ config('app.name') }} - Order Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('marketplace_assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-50">

    <div id="overlay" class="overlay fixed inset-0 bg-black/50"></div>

    <aside id="sidebar" class="sidebar fixed top-0 left-0 w-72 h-full bg-white shadow-2xl z-50 flex flex-col">
        <div class="p-5 border-b flex justify-between items-center">
            <h2 class="text-xl font-bold text-orange-600">
                <img src="{{ asset('own_assets/logo/logo.png') }}" width="20%">
            </h2>
            <button id="closeSidebarBtn" class="text-gray-500 text-2xl"><i class="fas fa-times"></i></button>
        </div>
        <nav class="flex-1 p-4 space-y-3">
            <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-orange-50 transition"><i
                    class="fas fa-home w-6 text-orange-500"></i><span>Beranda</span></a>
            <a href="#" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-orange-50 transition"><i
                    class="fas fa-history w-6 text-orange-500"></i><span>Pesanan</span></a>
        </nav>
        <div class="p-5 border-t bg-gray-50">
            <h3 class="font-semibold text-gray-700 mb-3"><i class="fas fa-address-card mr-2"></i>Kontak Kami</h3>
            <div class="space-y-2 text-sm text-gray-600">
                <p><i class="fab fa-whatsapp w-5 text-green-600"></i> +62 812-3456-7890</p>
                <p><i class="fas fa-phone-alt w-5 text-blue-500"></i> (021) 1234 5678</p>
                <p><i class="fas fa-envelope w-5 text-red-400"></i> halo@restoran.id</p>
                <p><i class="fas fa-map-marker-alt w-5 text-gray-600"></i> Jl. Kuliner No. 88, Jakarta</p>
            </div>
            <div class="flex mt-4 space-x-3">
                <i class="fab fa-instagram text-2xl text-pink-500"></i>
                <i class="fab fa-facebook text-2xl text-blue-700"></i>
                <i class="fab fa-tiktok text-2xl text-black"></i>
            </div>
        </div>
    </aside>

    <main class="pb-28">
        <header class="bg-white shadow-sm sticky top-0 z-20">
            <div class="container mx-auto px-4 py-4 flex items-center gap-4">
                <button id="menuToggleBtn" class="text-2xl text-orange-600 focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="text-xl font-bold text-gray-800">
                    <img src="{{ asset('own_assets/logo/logo.png') }}" width="20%">
                </h1>
            </div>
        </header>

        <div class="container mx-auto px-4 mt-4">
            <div class="w-full h-40 md:h-56 rounded-2xl overflow-hidden shadow-md">
                <img src="https://picsum.photos/id/106/1200/400" alt="Banner Makanan"
                    class="w-full h-full object-cover">
            </div>
        </div>

        <div class="container mx-auto px-4 mt-6">
            <div class="flex overflow-x-auto space-x-3 pb-2 no-scrollbar scroll-smooth" id="categoryTabs">
                <button
                    class="tab-category flex items-center gap-2 px-4 md:px-5 py-2 rounded-full border border-gray-300 bg-white text-gray-700 font-medium whitespace-nowrap transition hover:shadow flex-shrink-0"
                    data-cat="0">
                    <img src="{{ asset('own_assets/icon/all_kategori.png') }}" class="w-5 h-5">
                    <span>Semua</span>
                </button>
                @foreach ($kategori as $kat)
                    <button
                        class="tab-category flex items-center gap-2 px-4 md:px-5 py-2 rounded-full border border-gray-300 bg-white text-gray-700 font-medium whitespace-nowrap transition hover:shadow flex-shrink-0"
                        data-cat="{{ $kat->id }}">

                        @if ($kat->id == 1)
                            <img src="{{ asset('own_assets/icon/fish.png') }}" class="w-5 h-5">
                        @elseif ($kat->id == 2)
                            <img src="{{ asset('own_assets/icon/plant.png') }}" class="w-5 h-5">
                        @endif

                        <span class="pr-1">{{ $kat->nama_kategori }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="container mx-auto px-4 mt-6">
            <h2 id="categoryTitle" class="text-xl font-bold text-gray-800 border-l-4 border-orange-500 pl-3 mb-4">
                Makanan</h2>
            <div id="menuList" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">

            </div>
        </div>
    </main>

    <!-- FLOATING CART BUTTON -->
    <div id="floatCartBtn" class="float-cart">
        <i class="fas fa-shopping-bag text-2xl"></i>
        <span id="cartCountBadge">0</span>
    </div>

    <!-- BOTTOM SHEET OVERLAY & SHEET -->
    <div id="sheetOverlay" class="sheet-overlay"></div>
    <div id="bottomSheet" class="bottom-sheet">
        <div class="sticky top-0 bg-white rounded-t-2xl border-b px-5 py-3 flex justify-between items-center">
            <h3 class="font-bold text-lg">Tambah Pesanan</h3>
            <button id="closeSheetBtn" class="text-gray-500 text-2xl"><i class="fas fa-times-circle"></i></button>
        </div>
        <div class="p-5">
            <div class="flex items-center gap-4 mb-4">
                <img id="sheetMenuImg" src="" alt="preview"
                    class="w-16 h-16 rounded-xl object-cover bg-gray-100">
                <div>
                    <h4 id="sheetMenuName" class="font-bold text-gray-800">Nama Menu</h4>
                    <p id="sheetMenuPrice" class="text-orange-600 font-semibold">Rp 0</p>
                </div>
            </div>
            <div class="flex items-center justify-between bg-gray-100 rounded-full p-2 mb-6">
                <button id="qtyMinus"
                    class="w-10 h-10 rounded-full bg-white shadow text-xl font-bold text-gray-700">-</button>
                <span id="qtyValue" class="text-xl font-semibold w-12 text-center">1</span>
                <button id="qtyPlus"
                    class="w-10 h-10 rounded-full bg-white shadow text-xl font-bold text-gray-700">+</button>
            </div>
            <button id="addToCartBtn"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-2xl transition flex items-center justify-center gap-2"><i
                    class="fas fa-cart-plus"></i>Tambahkan Pesanan</button>
        </div>
    </div>

    <!-- MODAL CART -->
    <!-- OVERLAY -->
    <div id="cartOverlay" class="fixed inset-0 bg-black/50 hidden z-40"></div>

    <!-- MODAL -->
    <div id="modalCart" class="fixed inset-0 flex items-center justify-center hidden z-50 px-4">
        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-xl overflow-hidden">

            <!-- HEADER -->
            <div class="flex justify-between items-center p-4 border-b">
                <h5 class="font-semibold text-lg flex items-center gap-2">
                    <i class="fas fa-bag-shopping"></i> Keranjang Belanja
                </h5>
                <button id="closeCartModal" class="text-gray-500 text-xl">&times;</button>
            </div>

            <!-- BODY -->
            <div class="p-4 max-h-[60vh] overflow-y-auto">
                <div id="cartList"></div>
            </div>

            <!-- FOOTER -->
            <div class="flex justify-between items-center p-4 border-t">
                <div class="text-sm font-medium">
                    Total: <span id="cartTotalFooter">Rp 0</span>
                </div>

                <div class="flex gap-2">
                    <button id="closeCartBtn" class="px-4 py-2 bg-gray-200 rounded-lg">
                        Tutup
                    </button>
                    <button id="checkoutBtn" class="px-4 py-2 bg-orange-500 text-white rounded-lg">
                        Checkout
                    </button>
                </div>
            </div>

        </div>
    </div>

    <div id="paymentModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50">
        <div class="bg-white rounded-2xl p-6 w-80 text-center animate-scale">
            <div id="paymentIcon" class="text-5xl mb-3"></div>
            <h3 id="paymentTitle" class="text-xl font-bold mb-2"></h3>
            <p id="paymentDesc" class="text-gray-500 mb-4"></p>

            <button onclick="closePaymentModal()" class="w-full bg-orange-500 text-white py-2 rounded-xl">
                OK
            </button>
        </div>
    </div>

    <div id="loadingCheckout"
        class="fixed inset-0 hidden z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white px-6 py-4 rounded-xl text-center">
            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-orange-500 mx-auto mb-3"></div>
            <p class="text-sm text-gray-600">Mencari driver & menghitung ongkir...</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        function showPaymentPopup(type) {

            let icon = '';
            let title = '';
            let desc = '';

            if (type === 'success') {
                icon = '<i class="fas fa-circle-check text-green-500"></i>';
                title = 'Pembayaran Berhasil';
                desc = 'Pesanan kamu sedang diproses';
            }

            if (type === 'failed') {
                icon = '<i class="fas fa-circle-xmark text-red-500"></i>';
                title = 'Pembayaran Gagal';
                desc = 'Silakan coba lagi';
            }

            if (type === 'pending') {
                icon = '<i class="fas fa-clock text-yellow-500"></i>';
                title = 'Menunggu Pembayaran';
                desc = 'Selesaikan pembayaran kamu';
            }

            $('#paymentIcon').html(icon);
            $('#paymentTitle').text(title);
            $('#paymentDesc').text(desc);

            $('#paymentModal').removeClass('hidden').addClass('flex');
        }

        function closePaymentModal() {
            $('#paymentModal').addClass('hidden').removeClass('flex');
        }

        function startCheckingStatus(orderId) {

            if (checkInterval) clearInterval(checkInterval);

            checkInterval = setInterval(() => {

                $.get(`/order/status/${orderId}`, function(res) {

                    console.log('status:', res.status);

                    if (res.status === 'paid') {

                        clearInterval(checkInterval);
                        showStatusPopup('success', 'Pembayaran berhasil');

                        cart = [];
                        updateCart();

                        setTimeout(() => location.reload(), 1500);
                    }

                    if (res.status === 'failed' || res.status === 'deny' || res.status === 'cancelled') {

                        clearInterval(checkInterval);
                        showStatusPopup('error', 'Pembayaran gagal');
                    }

                });

            }, 2000); // ⏱ tiap 2 detik
        }

        $(document).ready(function() {

            let activeCategory = null;
            let cart = [];
            let selectedMenu = null;
            let qty = 1;
            let orderIdGlobal = null;
            let intervalCheck = null;

            let firstTab = $('.tab-category').first();

            if (firstTab.length) {
                activeCategory = firstTab.data('cat');
                firstTab.addClass('bg-orange-500 text-white active').removeClass('bg-white text-gray-700');
                loadMenu(activeCategory);
                $('#categoryTitle').text(firstTab.text());
            }

            $(document).on('click', '.tab-category', function() {

                $('.tab-category')
                    .removeClass('bg-orange-500 text-white')
                    .addClass('bg-white text-gray-700');

                $(this)
                    .addClass('bg-orange-500 text-white')
                    .removeClass('bg-white text-gray-700');

                activeCategory = $(this).data('cat');

                $('#categoryTitle').text($(this).text());

                loadMenu(activeCategory);
            });

            function loadMenu(kategori) {

                $('#menuList').html('<div class="text-center py-5">Loading...</div>');

                $.get('/daftar-produk/load-data', {
                    kategori: kategori
                }, function(res) {

                    if (!res.data.length) {
                        $('#menuList').html(
                            '<div class="text-center py-5 text-gray-400">Menu kosong</div>');
                        return;
                    }

                    let html = '';

                    res.data.forEach(menu => {

                        let img = '/storage/default.png';

                        if (menu.foto_produk && menu.foto_produk.length > 0) {
                            img = '/storage/' + menu.foto_produk[0].image;
                        }

                        html += `
                            <div class="menu-card bg-white rounded-2xl shadow hover:shadow-lg overflow-hidden transition">

                                <div class="w-full aspect-[1/1] overflow-hidden">
                                    <img src="${img}" class="w-full h-full object-cover">
                                </div>

                                <div class="p-4">
                                    <h3 class="font-bold text-gray-800">${menu.name}</h3>
                                    <p class="text-orange-600 font-semibold mt-1">
                                        Rp ${formatRupiah(menu.price)}
                                    </p>

                                    <button class="btn-add mt-3 w-full bg-orange-100 hover:bg-orange-200 text-orange-700 py-2 rounded-xl"
                                        data-menu='${JSON.stringify(menu)}'>
                                        Pesan +
                                    </button>
                                </div>
                            </div>
                            `;
                    });

                    $('#menuList').html(html);
                });
            }

            $(document).on('click', '.btn-add', function() {

                selectedMenu = $(this).data('menu');
                qty = 1;

                $('#qtyValue').text(qty);
                $('#sheetMenuName').text(selectedMenu.name);
                $('#sheetMenuPrice').text('Rp ' + formatRupiah(selectedMenu.price));

                let img = '/storage/default.png';
                if (selectedMenu.foto_produk && selectedMenu.foto_produk.length > 0) {
                    img = '/storage/' + selectedMenu.foto_produk[0].image;
                }

                $('#sheetMenuImg').attr('src', img);

                openBottomSheet();
            });

            function openBottomSheet() {
                $('#bottomSheet').addClass('open');
                $('#sheetOverlay').addClass('active');
                $('body').css('overflow', 'hidden');
            }

            function closeBottomSheet() {
                $('#bottomSheet').removeClass('open');
                $('#sheetOverlay').removeClass('active');
                $('body').css('overflow', '');
            }

            $('#closeSheetBtn, #sheetOverlay').click(closeBottomSheet);

            $('#qtyPlus').click(function() {
                qty++;
                $('#qtyValue').text(qty);
            });

            $('#qtyMinus').click(function() {
                if (qty > 1) {
                    qty--;
                    $('#qtyValue').text(qty);
                }
            });

            $('#addToCartBtn').click(function() {
                let exist = cart.find(i => i.id === selectedMenu.id);

                if (exist) {
                    exist.qty += qty;
                } else {
                    cart.push({
                        id: selectedMenu.id,
                        nama: selectedMenu.name,
                        harga: selectedMenu.price,
                        qty: qty,
                        note: ''
                    });
                }

                updateCart();
                closeBottomSheet();
            });

            function updateCart() {

                let total = cart.reduce((sum, i) => sum + i.qty, 0);
                $('#cartCountBadge').text(total);
            }

            toastr.options = {
                "closeButton": false,
                "progressBar": true,
                "positionClass": "toast-bottom-right",
                "timeOut": "2000",
                "extendedTimeOut": "1000"
            };

            // buka modal
            $('#floatCartBtn').click(function() {

                if (!cart.length) {
                    toastr.warning('Keranjang masih kosong');
                    return;
                }

                renderCart();

                $('#modalCart').removeClass('hidden');
                $('#cartOverlay').removeClass('hidden');
            });

            // close modal
            function closeCartModal() {
                $('#modalCart').addClass('hidden');
                $('#cartOverlay').addClass('hidden');
            }

            $('#closeCartModal, #closeCartBtn, #cartOverlay').click(function() {
                closeCartModal();
            });

            $('#menuToggleBtn').click(function() {
                $('#sidebar').addClass('open');
                $('#overlay').addClass('active');
            });

            $('#closeSidebarBtn, #overlay').click(function() {
                $('#sidebar').removeClass('open');
                $('#overlay').removeClass('active');
            });

            $(document).on('click', '.btn-remove', function() {
                let id = $(this).data('id');

                cart = cart.filter(i => i.id !== id);

                updateCartBadge();

                if (!cart.length) {
                    closeCartModal();
                    return;
                }

                renderCart();
            });

            function renderCart() {

                let html = '';
                let total = 0;

                console.log(cart)

                cart.forEach(item => {

                    let subtotal = item.harga * item.qty;
                    total += subtotal;

                    html += `
                        <div class="border-b pb-4 mb-4">

                            <div class="flex justify-between items-start">

                                <div class="flex-1 pr-3">
                                    <h6 class="font-semibold text-gray-800">${item.nama}</h6>

                                    <p class="text-sm text-gray-500">
                                        Rp ${formatRupiah(item.harga)}
                                    </p>

                                    <input type="text"
                                        class="mt-2 w-full border rounded-lg px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 note-input"
                                        placeholder="Tambah catatan..."
                                        data-id="${item.id}"
                                        value="${item.note ?? ''}">
                                </div>

                                <div class="flex flex-col items-end gap-2">

                                    <!-- HARGA -->
                                    <span class="font-semibold text-orange-600">
                                        Rp ${formatRupiah(subtotal)}
                                    </span>

                                    <!-- QTY CONTROL -->
                                    <div class="flex items-center gap-2 bg-gray-100 rounded-lg px-2 py-1">

                                        <button class="qty-minus text-lg px-2" data-id="${item.id}">-</button>

                                        <span class="w-6 text-center">${item.qty}</span>

                                        <button class="qty-plus text-lg px-2" data-id="${item.id}">+</button>

                                    </div>

                                    <!-- DELETE -->
                                    <button class="btn-remove text-red-500 text-sm" data-id="${item.id}">
                                        Hapus
                                    </button>

                                </div>

                            </div>

                        </div>
                        `;
                });

                $('#cartList').html(html);
                $('#cartTotalFooter').text('Rp ' + formatRupiah(total));
            }

            function updateCartBadge() {
                let total = 0;

                cart.forEach(item => {
                    total += item.qty;
                });

                if (total < 0) {
                    total = 0;
                }

                $('#cartCountBadge').text(total);
                $('#cartCountBadge').show();
            }

            function formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            $(document).on('click', '.qty-plus', function() {
                let id = $(this).data('id');

                let item = cart.find(i => i.id === id);
                item.qty++;

                renderCart();
                updateCartBadge();
            });

            $(document).on('click', '.qty-minus', function() {
                let id = $(this).data('id');

                let item = cart.find(i => i.id === id);

                if (item.qty > 1) {
                    item.qty--;
                }

                renderCart();
                updateCartBadge();
            });

            $(document).on('input', '.note-input', function() {
                let id = $(this).data('id');
                let value = $(this).val();

                let item = cart.find(i => i.id === id);
                item.note = value;
            });

            $('#checkoutBtn').click(function() {

                if (!cart.length) {
                    toastr.warning('Keranjang kosong');
                    return;
                }

                let items = cart.map(i => ({
                    id: i.id,
                    qty: i.qty,
                    note: i.note
                }));

                $('#loadingCheckout').removeClass('hidden');

                $.ajax({
                    url: '/checkout',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        items: items,
                    },
                    success: function(res) {

                        let ongkir = res.ongkir;
                        let total = res.total;
                        let driver = res.driver;

                        // tampilkan popup modern
                        Swal.fire({
                            title: 'Konfirmasi Pembayaran',
                            html: `
            <div style="text-align:left">
                <p>🚚 <b>Driver:</b> ${driver.name}</p>
                <p>⭐ Rating: ${driver.rating}</p>
                <p>🚗 Kendaraan: ${driver.vehicle}</p>

                <hr>

                <p>📦 Ongkir: <b>Rp ${formatRupiah(ongkir)}</b></p>
                <p>💰 Total: <b>Rp ${formatRupiah(total)}</b></p>
            </div>
        `,
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonText: 'Bayar Sekarang',
                            cancelButtonText: 'Batal',
                            confirmButtonColor: '#f97316'
                        }).then((result) => {

                            if (result.isConfirmed) {

                                orderIdGlobal = res.order_id;

                                snap.pay(res.snap_token, {
                                    onSuccess: function() {
                                        snap.hide();
                                        showPaymentPopup('success');

                                        cart = [];
                                        updateCartBadge();
                                    },
                                    onPending: function() {
                                        startCheckingStatus(res.order_id);
                                    },
                                    onError: function() {
                                        showPaymentPopup('failed');
                                    }
                                });

                            }

                        });
                    },
                    error: function(err) {

                        $('#loadingCheckout').addClass('hidden');

                        if (err.responseJSON?.message) {
                            toastr.error(err.responseJSON.message);
                        } else {
                            toastr.error('Checkout gagal');
                        }
                    }
                });
            });

        });
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</body>

</html>
