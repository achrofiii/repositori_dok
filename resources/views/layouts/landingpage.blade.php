<!doctype html>
<html class="no-js" lang="zxx">


<!-- Mirrored from quomodosoft.com/html/library/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 10 Jun 2025 06:53:59 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Home</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" href="{{ asset('assetLP') }}/images/apple-touch-icon.png">
    <link rel="shortcut icon" type="image/ico" href="{{ asset('assetLP') }}/images/favicon.ico" />

    <!-- Plugin-CSS -->
    <link rel="stylesheet" href="{{ asset('assetLP') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assetLP') }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('assetLP') }}/css/icofont.css">
    <link rel="stylesheet" href="{{ asset('assetLP') }}/css/animate.css">
    <link rel="stylesheet" href="{{ asset('assetLP') }}/css/cardslider.css">
    <link rel="stylesheet" href="{{ asset('assetLP') }}/css/responsiveslides.css">

    <!-- Main-Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assetLP') }}/css/normalize.css">
    <link rel="stylesheet" href="{{ asset('assetLP') }}/css/overright.css">
    <link rel="stylesheet" href="{{ asset('assetLP') }}/css/theme.css">
    <link rel="stylesheet" href="{{ asset('assetLP') }}/style.css">
    <link rel="stylesheet" href="{{ asset('assetLP') }}/css/responsive.css">
    <script src="{{ asset('assetLP') }}/js/vendor/modernizr-2.8.3.min.js"></script>
    <style>
        .custom-pagination {
          display: flex;
          gap: 8px;
          flex-wrap: wrap;
          justify-content: center;
          margin-bottom: 30px;
        }

        .custom-pagination .page-link {
          padding: 6px 12px;
          background-color: #f2f2f2;
          color: #333;
          text-decoration: none;
          border-radius: 4px;
          border: 1px solid #ddd;
          font-size: 14px;
        }

        .custom-pagination .page-link:hover {
          background-color: #e0e0e0;
        }

        .custom-pagination .current {
          background-color: #007bff;
          color: white;
          pointer-events: none;
        }
      </style>

</head>

<body data-spy="scroll" data-target="#mainmenu" data-offset="50">
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <header class="relative" id="sc1">
        <!-- Header-background-markup -->
        <div class="header-bg relative home-slide">
            <div class="item">
                <img src="{{ asset('assetLP') }}/images/slide/slide4.webp" alt="library">
            </div>
        </div>
        <!-- Mainmenu-markup-start -->
        <div class="mainmenu-area navbar-fixed-top" data-spy="affix" data-offset-top="10">
            <nav class="navbar">
                <div class="container">
                    <div class="navbar-header">
                        <div class="space-10"></div>
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainmenu">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <!--Logo-->
                        <a href="#sc1" class="navbar-left show"><img width="300px"
                                src="{{ asset('assetLP') }}/images/logo_unibamadura.png" alt="library"></a>
                        <div class="space-10"></div>
                    </div>
                    <!--Toggle-button-->

                    <!--Active User-->
                    <div class="nav navbar-right">
                        <div class="navbar-left active">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="{{ route('login') }}" class="btn btn-primary" style="margin-top:10px;">
                                        <i class="icofont icofont-login"></i> Login
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--Mainmenu list-->
                    <div class="navbar-right in fade" id="mainmenu">
                        <ul class="nav navbar-nav nav-white text-uppercase">
                            <li class="active">
                                <a href="{{ route('landingpage.home') }}#sc1">Beranda</a>
                            </li>
                            <li>
                                <a href="{{ route('landingpage.home') }}#sc2">Tentang</a>
                            </li>
                            <li>
                                <a href="{{ route('landingpage.home') }}#sc5">Kategori</a>
                            </li>
                            <li>
                                <a href="{{ route('landingpage.home') }}#sc4">Populer</a>
                            </li>
                            <li>
                                <a href="{{ route('landingpage.documents') }}">Dokumen</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="space-100"></div>
        <!-- Mainmenu-markup-end -->
        <!-- Header-jumbotron -->
        @yield('content-header')
        <!-- Header-jumbotron-end -->
    </header>

    <div class="content">
        @yield('content')
    </div>

    <footer class="black-bg text-white">
        <div class="space-100"></div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <a href="#"><img width="300px" src="{{ asset('assetLP') }}/images/logo_unibamadura.png"
                            alt="library"></a>
                    <div class="space-20"></div>
                    <p>Karya Ilmiah Mahasiswa dan Dosen dalam Genggaman
                        Dari skripsi hingga jurnal, temukan semua dokumen akademik dalam satu tempat.</p>
                    <div class="space-10"></div>
                    <ul class="list-inline list-unstyled social-list">
                        <li><a href="#"><i class="icofont icofont-social-facebook"></i></a></li>
                        <li><a href="#"><i class="icofont icofont-social-twitter"></i></a></li>
                        <li><a href="#"><i class="icofont icofont-social-behance"></i></a></li>
                        <li><a href="#"><i class="icofont icofont-brand-linkedin"></i></a></li>
                    </ul>
                    <div class="space-10"></div>
                    <ul class="list-unstyled list-inline tip yellow">
                        <li><i class="icofont icofont-square"></i></li>
                        <li><i class="icofont icofont-square"></i></li>
                        <li><i class="icofont icofont-square"></i></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-3 col-md-offset-1">
                    <h4 class="text-white">Kontak Kami</h4>
                    <div class="space-20"></div>
                    <table class="table border-none addr-dt">
                        <tr>
                            <td><i class="icofont icofont-social-google-map"></i></td>
                            <td>
                                <address>Jl. Raya Lenteng No. 10, Batuan, Sumenep - Madura.
                                </address>
                            </td>
                        </tr>
                        <tr>
                            <td><i class="icofont icofont-email"></i></td>
                            <td>info@unibamadura.ac.id</td>
                        </tr>
                        <tr>
                            <td><i class="icofont icofont-phone"></i></td>
                            <td>(0328) 6771010</td>
                        </tr>
                    </table>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-3 col-md-offset-1">
                    <h4 class="text-white">Tautan Cepat</h4>
                    <div class="space-20"></div>
                    <ul class="list-unstyled menu-tip">
                        <li class="active">
                            <a href="{{ route('landingpage.home') }}#sc1">Beranda</a>
                        </li>
                        <li>
                            <a href="{{ route('landingpage.home') }}#sc2">Tentang</a>
                        </li>
                        <li>
                            <a href="{{ route('landingpage.home') }}#sc5">Kategori</a>
                        </li>
                        <li>
                            <a href="{{ route('landingpage.home') }}#sc4">Populer</a>
                        </li>
                        <li>
                            <a href="{{ route('landingpage.documents') }}">Dokumen</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="space-100"></div>
    </footer>

    <!-- Vandor-JS -->
    <script src="{{ asset('assetLP') }}/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="{{ asset('assetLP') }}/js/vendor/bootstrap.min.js"></script>
    <!-- Plugin-JS -->
    <script src="{{ asset('assetLP') }}/js/owl.carousel.min.js"></script>
    <script src="{{ asset('assetLP') }}/js/responsiveslides.min.js"></script>
    <script src="{{ asset('assetLP') }}/js/jquery.cardslider.min.js"></script>
    <script src="{{ asset('assetLP') }}/js/pagination.js"></script>
    <script src="{{ asset('assetLP') }}/js/scrollUp.min.js"></script>
    <script src="{{ asset('assetLP') }}/js/wow.min.js"></script>
    <script src="{{ asset('assetLP') }}/js/plugins.js"></script>
    <!-- Active-JS -->
    <script src="{{ asset('assetLP') }}/js/main.js"></script>

</body>


<!-- Mirrored from quomodosoft.com/html/library/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 10 Jun 2025 06:54:25 GMT -->

</html>
