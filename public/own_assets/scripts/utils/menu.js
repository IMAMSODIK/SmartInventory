function loadMenu() {

    let kategori = [];
    $('.filter-kategori:checked').each(function () {
        kategori.push($(this).val());
    });

    // let is_ready = $('input[name="filter_ready"]:checked').val();
    // let status = $('input[name="filter_status"]:checked').val();
    let search = $('#search-menu').val();

    showSkeleton();

    $.ajax({
        url: '/daftar-produk/data',
        type: 'GET',
        data: {
            kategori: kategori,
            search: search
        },
        success: function (res) {
            let container = $('#menu-container');
            container.hide().html('');

            if (!res.check_profile) {
                container.html('<p class="text-center">Silahkan Update Profile Usaha</p><br><a href="/profile-usaha" class="btn btn-success">Update Profile Usaha</button>');
            } else {
                if (res.data.length === 0) {
                    container.html('<p class="text-center">Data tidak ditemukan</p>');
                } else {
                    res.data.forEach(menu => {
                        container.append(generateMenuCard(menu));
                    });
                }
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

        if (menu.foto_produk && menu.foto_produk.length > 0) {
            img = '/storage/' + menu.foto_produk[0].image;
        }

        let html = `
            <div class="col-xl-3 col-sm-6 produk-item" data-id="${menu.id}">
                <div class="card">
                    <div class="product-box">

                        <div class="product-img">
                            <div class="ribbon ribbon-success ribbon-right">
                                ${menu.kategori.nama_kategori}
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
                            <h4>${menu.name}</h4>
                            <p>${menu.deskripsi ?? ''}</p>

                            <div class="row align-items-center">
                                <div class="col-9">
                                    <div class="product-price">
                                        Rp ${formatRupiah(menu.price)}
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-12">
                                    
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

    if (menu.foto_produk && menu.foto_produk.length > 0) {
        img = '/storage/' + menu.foto_produk[0].image;
    }

    let actionButton = '';

    if (menu.is_approved) {
        actionButton = `
        <button class="btn btn-sm btn-warning suspend-btn w-100" data-id="${menu.id}">
            <i class="fa fa-ban"></i> Suspend
        </button>
    `;
    } else {
        actionButton = `
        <button class="btn btn-sm btn-success approve-btn w-100" data-id="${menu.id}">
            <i class="fa fa-check"></i> Approve
        </button>
    `;
    }

    return `
    <div class="col-xl-3 col-sm-6 produk-item" data-id="${menu.id}">
        <div class="card">
            <div class="product-box">

                <div class="product-img">
                    <div class="ribbon ribbon-success ribbon-right">
                        ${menu.kategori?.nama_kategori ?? ''}
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
                    <h4>${menu.name}</h4>
                    <p>${menu.deskripsi ?? ''}</p>

                    <div class="row">
                        <div class="col-9">
                            <div class="product-price">
                                Rp ${formatRupiah(menu.price)}
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-12">
                            ${actionButton}
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