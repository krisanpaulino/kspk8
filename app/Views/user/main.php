<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?= base_url('/') ?>assets-user/image/favicon.png" type="<?= base_url('/') ?>assets-user/image/png">
    <title><?= $title ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('/') ?>assets-user/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url('/') ?>assets-user/vendors/linericon/style.css">
    <link rel="stylesheet" href="<?= base_url('/') ?>assets-user/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url('/') ?>assets-user/vendors/owl-carousel/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url('/') ?>assets-user/vendors/bootstrap-datepicker/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="<?= base_url('/') ?>assets-user/vendors/nice-select/css/nice-select.css">
    <link rel="stylesheet" href="<?= base_url('/') ?>assets-user/vendors/owl-carousel/owl.carousel.min.css">
    <!-- DATATABLES -->
    <link rel="stylesheet" href="<?= base_url('/') ?>assets-user/datatables/css/lib/datatable/dataTables.bootstrap.min.css">
    <!-- DATATABLES -->
    <!-- main css -->
    <link rel="stylesheet" href="<?= base_url('/') ?>assets-user/css/style.css">
    <link rel="stylesheet" href="<?= base_url('/') ?>assets-user/css/responsive.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!--================Header Area =================-->
    <header class="header_area">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h" href="<?= base_url('/') ?>"><img src="<?= base_url('/') ?>assets-user/image/logo_unwira.png" alt="" width="50"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('/') ?>">Home</a></li>
                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tentang kami</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link" href="<?= base_url('/page/profil') ?>">Profil KSPK</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= base_url('/page/struktur') ?>">Struktur Organisasi</a></li>
                            </ul>
                        </li>

                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Kerja sama</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link" href="<?= base_url('/kerjasama/Lokal') ?>">Kerja sama lokal</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= base_url('/kerjasama/Nasional') ?>">Kerja sama nasional</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= base_url('/kerjasama/Internasional') ?>">Kerja sama internasional</a></li>
                            </ul>
                        </li>

                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Alumni</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link" href="<?= base_url('/alumni') ?>">Data alumni</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= base_url('/page/ikawira') ?>">IKAWIRA</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= base_url('/kartualumni') ?>">Kartu alumni</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= base_url('/cerita') ?>">Cerita alumni</a></li>
                            </ul>
                        </li>

                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tracer study</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link" href="<?= base_url('/page/tracerstudy') ?>">Tutorial pengisian</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= base_url('/') ?>" target="_blank">Isi tracer study</a></li>
                            </ul>
                        </li>

                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Layanan karier</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link" href="<?= base_url('/page/karier') ?>">Tentang</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= base_url('/karier') ?>" target="_blank">Kelas persiapan</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= base_url('/expo') ?>">Career expo</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= base_url('/page/partner') ?>">Mitra</a></li>
                            </ul>
                        </li>

                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Humas dan publikasi</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link" href="<?= base_url('/page/wartawan') ?>">Wartawan kampus</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= base_url('/page/partner') ?>">Media partner</a></li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <!--================Header Area =================-->
    <div class="container">
        <?= $this->renderSection('content'); ?>
    </div>

    <!--================ start footer Area  =================-->
    <footer class="footer-area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-footer-widget">
                        <h6 class="footer_title">KSPK - Unwira</h6>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nobis, quam deserunt assumenda officiis eaque perspiciatis adipisci quasi eveniet laboriosam. Illum eos fugit ipsa vero sed quia repudiandae. Nobis, rerum veniam.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-footer-widget">

                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="single-footer-widget instafeed">
                        <h6 class="footer_title" style="text-align: right;">Kontak</h6>
                        <ul class="list_style" style="text-align: right;">
                            <li>Email : </li>
                            <li>Telp :</li>
                            <li>Address :</li>
                            <li><a href="https://unwira.ac.id/" target="_blank">Unwira.ac.id</a></li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="border_line"></div>
            <div class="row footer-bottom d-flex justify-content-between align-items-center">
                <p class="col-lg-4 col-sm-12 footer-text m-0"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;<script>
                        document.write(new Date().getFullYear());
                    </script>
                    <!-- All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a> -->
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </p>
                <div class="col-lg-4 col-sm-12">
                    <center>By : <a href="https://unwira.ac.id/" target="_blank">PDTI Unwira</a></center>
                </div>
                <div class="col-lg-4 col-sm-12 footer-social">
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-dribbble"></i></a>
                    <a href="#"><i class="fa fa-behance"></i></a>
                </div>
            </div>
        </div>
    </footer>
    <!--================ End footer Area  =================-->


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?= base_url('/') ?>assets-user/js/jquery-3.2.1.min.js"></script>
    <script src="<?= base_url('/') ?>assets-user/js/popper.js"></script>
    <script src="<?= base_url('/') ?>assets-user/js/bootstrap.min.js"></script>
    <script src="<?= base_url('/') ?>assets-user/vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="<?= base_url('/') ?>assets-user/js/jquery.ajaxchimp.min.js"></script>
    <script src="<?= base_url('/') ?>assets-user/js/mail-script.js"></script>
    <script src="<?= base_url('/') ?>assets-user/vendors/bootstrap-datepicker/bootstrap-datetimepicker.min.js"></script>
    <script src="<?= base_url('/') ?>assets-user/vendors/nice-select/js/jquery.nice-select.js"></script>
    <script src="<?= base_url('/') ?>assets-user/js/mail-script.js"></script>
    <script src="<?= base_url('/') ?>assets-user/js/stellar.js"></script>
    <script src="<?= base_url('/') ?>assets-user/vendors/lightbox/simpleLightbox.min.js"></script>
    <script src="<?= base_url('/') ?>assets-user/js/custom.js"></script>
    <script src="<?= base_url('/') ?>assets/plugins/chartjs/js/chart.min.js"></script>
    <script src="<?= base_url('/') ?>assets/js/ckeditor/ckeditor.js"></script>

    <?= $this->renderSection('scripts'); ?>
</body>

</html>