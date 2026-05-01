<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Solartec - Renewable Energy Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('landing_assets/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing_assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('landing_assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('landing_assets/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    {{-- <div class="container-fluid bg-dark p-0">
        <div class="row gx-0 d-none d-lg-flex">
            <div class="col-lg-7 px-5 text-start">
                <div class="h-100 d-inline-flex align-items-center me-4">
                    <small class="fa fa-map-marker-alt text-primary me-2"></small>
                    <small>123 Street, New York, USA</small>
                </div>
                <div class="h-100 d-inline-flex align-items-center">
                    <small class="far fa-clock text-primary me-2"></small>
                    <small>Mon - Fri : 09.00 AM - 09.00 PM</small>
                </div>
            </div>
            <div class="col-lg-5 px-5 text-end">
                <div class="h-100 d-inline-flex align-items-center me-4">
                    <small class="fa fa-phone-alt text-primary me-2"></small>
                    <small>+012 345 6789</small>
                </div>
                <div class="h-100 d-inline-flex align-items-center mx-n2">
                    <a class="btn btn-square btn-link rounded-0 border-0 border-end border-secondary" href=""><i
                            class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-square btn-link rounded-0 border-0 border-end border-secondary" href=""><i
                            class="fab fa-twitter"></i></a>
                    <a class="btn btn-square btn-link rounded-0 border-0 border-end border-secondary" href=""><i
                            class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-square btn-link rounded-0" href=""><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0">
        <a href="index.html" class="navbar-brand d-flex align-items-center border-end px-4 px-lg-5">
            <h2 class="m-0 text-primary">Smart Invertor</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.html" class="nav-item nav-link active">Home</a>
                <a href="#about" class="nav-item nav-link">About</a>
                <a href="#service" class="nav-item nav-link">Service</a>
                <a href="#team" class="nav-item nav-link">Team</a>
                <a href="#contact" class="nav-item nav-link">Contact</a>
            </div>
            <a href="#register" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block">Join Now<i
                    class="fa fa-arrow-right ms-3"></i></a>
            <a href="/marketplace" class="btn btn-warning rounded-0 py-4 px-lg-5 d-none d-lg-block text-white">Shop Now<i
                    class="fa fa-arrow-right ms-3"></i></a>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0 pb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="owl-carousel header-carousel position-relative">
            <div class="owl-carousel-item position-relative"
                data-dot="<img src='{{ asset('landing_assets/img/hero1.png') }}'>">
                <img class="img-fluid" src="{{ asset('landing_assets/img/hero1.png') }}" alt="">
                <div class="owl-carousel-inner">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-10 col-lg-8">
                                <h1 class="display-2 text-white animated slideInDown">Connecting Farms and Oceans to
                                    Your Doorstep</h1>
                                <p class="fs-5 fw-medium text-white mb-4 pb-3">VFresh commodities, directly from farmers
                                    and fishermen. <br>fast, transparent, and reliable.</p>
                                <a href="#register"
                                    class="btn btn-primary rounded-pill py-3 px-5 animated slideInLeft">Join Now!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel-item position-relative"
                data-dot="<img src='{{ asset('landing_assets/img/hero2.png') }}'>">
                <img class="img-fluid" src="{{ asset('landing_assets/img/hero2.png') }}" alt="">
                <div class="owl-carousel-inner">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-10 col-lg-8">
                                <h1 class="display-2 text-white animated slideInDown">From Harvest and Catch to
                                    Market—Seamlessly</h1>
                                <p class="fs-5 fw-medium text-white mb-4 pb-3">Get the freshest vegetables and seafood
                                    with a smarter, shorter supply chain.</p>
                                <a href="#register"
                                    class="btn btn-primary rounded-pill py-3 px-5 animated slideInLeft">Join Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel-item position-relative"
                data-dot="<img src='{{ asset('landing_assets/img/hero3.jpeg') }}'>">
                <img class="img-fluid" src="{{ asset('landing_assets/img/hero3.jpeg') }}" alt="">
                <div class="owl-carousel-inner">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-10 col-lg-8">
                                <h1 class="display-2 text-white animated slideInDown">One Platform. Farmers, Fishermen,
                                    Buyers, and Couriers.</h1>
                                <p class="fs-5 fw-medium text-white mb-4 pb-3">Empowering local producers and
                                    delivering freshness across every mile.</p>
                                <a href="#register"
                                    class="btn btn-primary rounded-pill py-3 px-5 animated slideInLeft">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- About Start -->
    <div class="container-fluid bg-light overflow-hidden my-5 px-lg-0" id="about">
        <div class="container about px-lg-0">
            <div class="row g-0 mx-lg-0">
                <div class="col-lg-6 ps-lg-0 wow fadeIn" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute img-fluid w-100 h-100"
                            src="{{ asset('landing_assets/img/hero3.jpeg') }}" style="object-fit: cover;"
                            alt="">
                    </div>
                </div>
                <div class="col-lg-6 about-text py-5 wow fadeIn" data-wow-delay="0.5s">
                    <div class="p-lg-5 pe-lg-0">
                        <h6 class="text-primary">About Us</h6>
                        <h3 class="mb-4">A platform connecting farmers, fishermen, buyers, and couriers in one
                            seamless fresh commodity ecosystem.</h3>
                        <p>We aim to simplify the supply chain by bringing products directly from the source—farms and
                            oceans—straight to consumers and businesses.</p>
                        <a href="" class="btn btn-primary rounded-pill py-3 px-5 mt-3">Explore More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Service Start -->
    <div class="container-xxl py-5" id="service">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="text-primary">Our Services</h6>
                <h1 class="mb-4">We Are Pioneers In The World Of Renewable Energy</h1>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item rounded overflow-hidden">
                        <img class="img-fluid" src="{{ asset('landing_assets/img/service1.jpg') }}" alt="">
                        <div class="position-relative p-4 pt-0">
                            <div class="service-icon">
                                <span style="font-size: 50px">🛍️</span>
                            </div>
                            <h4 class="mb-3">Local Product Marketplace</h4>
                            <p>Discover a wide range of quality products from trusted local sellers in one convenient
                                platform.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item rounded overflow-hidden">
                        <img class="img-fluid" src="{{ asset('landing_assets/img/service2.jpg') }}" alt="">
                        <div class="position-relative p-4 pt-0">
                            <div class="service-icon">
                                <span style="font-size: 50px">🚚</span>
                            </div>
                            <h4 class="mb-3">Fast & Reliable Delivery</h4>
                            <p>Orders are processed quickly with an efficient delivery system and real-time tracking.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item rounded overflow-hidden">
                        <img class="img-fluid" src="{{ asset('landing_assets/img/service3.jpg') }}" alt="">
                        <div class="position-relative p-4 pt-0">
                            <div class="service-icon">
                                <span style="font-size: 50px">📊</span>
                            </div>
                            <h4 class="mb-3">Smart Business Management</h4>
                            <p>Easily manage your products and orders with an intelligent dashboard to grow your
                                business.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->


    <!-- Quote Start -->
    <div class="container-fluid bg-light overflow-hidden my-5 px-lg-0" id="register">
        <div class="container quote px-lg-0">
            <div class="row g-0 mx-lg-0">
                <div class="col-lg-6 ps-lg-0 wow fadeIn" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute img-fluid w-100 h-100"
                            src="{{ asset('landing_assets/img/hero2.png') }}" style="object-fit: cover;"
                            alt="">
                    </div>
                </div>
                <div class="col-lg-6 quote-text py-5 wow fadeIn" data-wow-delay="0.5s">
                    <div class="p-lg-5 pe-lg-0">
                        <h6 class="text-primary">Start Selling Today</h6>
                        <h1 class="mb-4">Grow Your Business with Us</h1>
                        <p class="mb-4 pb-2">
                            Join our platform and connect with more customers easily. Manage your products, track
                            orders, and grow your business with a simple and powerful system designed for modern
                            sellers.
                        </p>
                        <form id="registerForm">
                            <div class="row g-3">

                                <div class="col-12 col-sm-6">
                                    <input type="text" name="name" class="form-control border-0"
                                        placeholder="Nama Lengkap" style="height:55px;">
                                    <small class="text-danger name_error"></small>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <input type="email" name="email" class="form-control border-0"
                                        placeholder="Email" style="height:55px;">
                                    <small class="text-danger email_error"></small>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <input type="text" name="phone" class="form-control border-0"
                                        placeholder="Nomor HP" style="height:55px;">
                                    <small class="text-danger phone_error"></small>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <select name="role" class="form-select border-0" style="height:55px;">
                                        <option value="">Pilih Role</option>
                                        <option value="pedagang">Pedagang</option>
                                        <option value="pembeli">Pembeli</option>
                                        <option value="kurir">Kurir</option>
                                    </select>
                                    <small class="text-danger role_error"></small>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <input type="password" name="password" class="form-control border-0"
                                        placeholder="Password" style="height:55px;">
                                    <small class="text-danger password_error"></small>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <input type="password" name="password_confirmation" class="form-control border-0"
                                        placeholder="Konfirmasi Password" style="height:55px;">
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary rounded-pill py-3 px-5" type="submit">
                                        Daftar Sekarang
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quote End -->


    <!-- Team Start -->
    <div class="container-xxl pt-5" id="team">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="text-primary">Team Member</h6>
                <h1 class="mb-4">Experienced Team Members</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item rounded overflow-hidden">
                        <div class="d-flex">
                            <img class="img-fluid w-75" src="{{ asset('landing_assets/img/team-1.jpg') }}"
                                alt="">
                            <div class="team-social w-25">
                                <a class="btn btn-lg-square btn-outline-primary rounded-circle mt-3" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-lg-square btn-outline-primary rounded-circle mt-3" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-lg-square btn-outline-primary rounded-circle mt-3" href=""><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="p-4">
                            <h5>Full Name</h5>
                            <span>Designation</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item rounded overflow-hidden">
                        <div class="d-flex">
                            <img class="img-fluid w-75" src="{{ asset('landing_assets/img/team-2.jpg') }}"
                                alt="">
                            <div class="team-social w-25">
                                <a class="btn btn-lg-square btn-outline-primary rounded-circle mt-3" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-lg-square btn-outline-primary rounded-circle mt-3" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-lg-square btn-outline-primary rounded-circle mt-3" href=""><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="p-4">
                            <h5>Full Name</h5>
                            <span>Designation</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item rounded overflow-hidden">
                        <div class="d-flex">
                            <img class="img-fluid w-75" src="{{ asset('landing_assets/img/team-3.jpg') }}"
                                alt="">
                            <div class="team-social w-25">
                                <a class="btn btn-lg-square btn-outline-primary rounded-circle mt-3" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-lg-square btn-outline-primary rounded-circle mt-3" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-lg-square btn-outline-primary rounded-circle mt-3" href=""><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="p-4">
                            <h5>Full Name</h5>
                            <span>Designation</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->


    <!-- Contact Start -->
    {{-- <div class="container-fluid bg-light overflow-hidden px-lg-0" style="margin: 6rem 0;">
        <div class="container contact px-lg-0">
            <div class="row g-0 mx-lg-0">
                <div class="col-lg-6 contact-text py-5 wow fadeIn" data-wow-delay="0.5s">
                    <div class="p-lg-5 ps-lg-0">
                        <h6 class="text-primary">Contact Us</h6>
                        <h1 class="mb-4">Feel Free To Contact Us</h1>
                        <h4 class="mb-4">Receive messages instantly with our PHP and Ajax contact form - available in
                            the <a href="https://htmlcodex.com/downloading/?item=2439">Pro Version</a> only.</h4>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name"
                                            placeholder="Your Name">
                                        <label for="name">Your Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email"
                                            placeholder="Your Email">
                                        <label for="email">Your Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="subject"
                                            placeholder="Subject">
                                        <label for="subject">Subject</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a message here" id="message" style="height: 100px"></textarea>
                                        <label for="message">Message</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary rounded-pill py-3 px-5" type="submit">Send
                                        Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 pe-lg-0" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <iframe class="position-absolute w-100 h-100" style="object-fit: cover;"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3001156.4288297426!2d-78.01371936852176!3d42.72876761954724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4ccc4bf0f123a5a9%3A0xddcfc6c1de189567!2sNew%20York%2C%20USA!5e0!3m2!1sen!2sbd!4v1603794290143!5m2!1sen!2sbd"
                            frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Contact End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-body footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s" id="contact">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-6 col-md-6">
                    <h5 class="text-white mb-4">Address</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-square btn-outline-light btn-social" href=""><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-outline-light btn-social" href=""><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-outline-light btn-social" href=""><i
                                class="fab fa-youtube"></i></a>
                        <a class="btn btn-square btn-outline-light btn-social" href=""><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <h5 class="text-white mb-4">Quick Links</h5>
                    <a class="btn btn-link" href="#about">About Us</a>
                    <a class="btn btn-link" href="#contact">Contact Us</a>
                    <a class="btn btn-link" href="#service">Our Services</a>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a href="#">Smart Inventory</a>, All Right Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        Designed By <a href="#">SMA N 1 Medan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
            class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('landing_assets/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('landing_assets/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('landing_assets/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('landing_assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('landing_assets/js/main.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        });

        $('#registerForm').submit(function(e) {
            e.preventDefault();

            $('.text-danger').text('');

            $.ajax({
                url: '/register',
                type: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },

                beforeSend: function() {
                    $('button[type="submit"]').prop('disabled', true);
                    Swal.fire({
                        title: 'Memproses...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });
                },

                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message
                    });

                    $('#registerForm')[0].reset();
                },

                error: function(xhr) {

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        $.each(errors, function(key, val) {
                            $('.' + key + '_error').text(val[0]);
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi gagal',
                            text: 'Silakan periksa kembali input Anda'
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server error',
                            text: 'Terjadi kesalahan'
                        });
                    }
                },
                complete: function() {
                    $('button[type="submit"]').prop('disabled', false);
                }
            });
        });
    </script>
</body>

</html>
