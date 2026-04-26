function loadMenu() {

    let kategori = [];
    $('.filter-kategori:checked').each(function () {
        kategori.push($(this).val());
    });

    let is_ready = $('input[name="filter_ready"]:checked').val();
    let status = $('input[name="filter_status"]:checked').val();
    let search = $('#search-menu').val();

    showSkeleton();

    $.ajax({
        url: '/daftar-menu/data',
        type: 'GET',
        data: {
            status: status,
            kategori: kategori,
            is_ready: is_ready,
            search: search
        },
        success: function (res) {

            let container = $('#menu-container');
            container.hide().html('');

            if (res.data.length === 0) {
                container.html('<p class="text-center">Data tidak ditemukan</p>');
            } else {
                res.data.forEach(menu => {
                    container.append(generateMenuCard(menu));
                });
            }

            container.fadeIn(300);
        }
    });
}

function renderMenu(data) {
    let container = $('#menu-container');
    container.html('');

    if (data.length === 0) {
        container.html('<p class="text-center">Data kosong</p>');
        return;
    }

    data.forEach(menu => {
        let img = '/storage/default.png';

        if (menu.foto_menus && menu.foto_menus.length > 0) {
            img = '/storage/' + menu.foto_menus[0].foto_path;
        }

        let html = `
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="product-box">

                        <div class="product-img">
                            <div class="ribbon ribbon-success ribbon-right">
                                ${menu.kategori_menu.nama_kategori}
                            </div>
                            <img class="img-fluid" src="${img}">
                            
                            <div class="product-hover">
                                <ul>
                                    <li class="btn-delete" data-id="${menu.id}">
                                        <button class="btn">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </li>
                                    <li class="edit-btn" data-id="${menu.id}">
                                        <button class="btn">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="product-details">
                            <h4>${menu.nama_menu}</h4>
                            <p>${menu.deskripsi ?? ''}</p>

                            <div class="row align-items-center">
                                <div class="col-9">
                                    <div class="product-price">
                                        Rp ${formatRupiah(menu.harga)}
                                    </div>
                                </div>
                                <div class="col-3 d-flex justify-content-end">
                                    <div class="form-check form-switch m-0">
                                        <input class="form-check-input switch-ready" 
                                            type="checkbox" 
                                            data-id="${menu.id}" 
                                            ${menu.is_ready ? 'checked' : ''}>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            `;

        container.append(html);
    });
}

function generateMenuCard(menu) {

    let img = '/storage/default.png';

    if (menu.foto_menus && menu.foto_menus.length > 0) {
        img = '/storage/' + menu.foto_menus[0].foto_path;
    }

    return `
    <div class="col-xl-3 col-sm-6">
        <div class="card ${menu.is_ready == 1 ? '' : 'opacity-50'}">
            <div class="product-box">

                <div class="product-img">
                    <div class="ribbon ribbon-success ribbon-right">
                        ${menu.kategori_menu?.nama_kategori ?? ''}
                    </div>
                    <img class="img-fluid" src="${img}">
                    
                    <div class="product-hover">
                        <ul>
                            <li class="btn-delete" data-id="${menu.id}">
                                <button class="btn">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </li>
                            <li class="edit-btn" data-id="${menu.id}">
                                <button class="btn">
                                    <i class="fa fa-pencil-square-o"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="product-details">
                    <h4>${menu.nama_menu}</h4>
                    <p>${menu.deskripsi ?? ''}</p>

                    <div class="row">
                        <div class="col-9">
                            <div class="product-price">
                                Rp ${formatRupiah(menu.harga)}
                            </div>
                        </div>
                        <div class="col-3 d-flex justify-content-end radius-none">
                            <div class="form-check product-price form-switch m-0">
                                <input class="form-check-input switch-ready" 
                                    type="checkbox" 
                                    data-id="${menu.id}" 
                                    ${menu.is_ready ? 'checked' : ''}>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    `;
}

function showSkeleton() {
    let skeleton = '';

    for (let i = 0; i < 8; i++) {
        skeleton += `
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="product-box">
                    <div class="skeleton-img"></div>
                    <div class="product-details">
                        <div class="skeleton-text mb-2"></div>
                        <div class="skeleton-text small"></div>
                    </div>
                </div>
            </div>
        </div>`;
    }

    $('#menu-container').html(skeleton);
}