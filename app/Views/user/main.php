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
    <style>
        .article-content {
            max-width: 100%;
            margin: 0 auto;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .article-title {
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1rem;
            font-size: 2rem;
        }

        .article-meta {
            font-size: 0.9rem;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 1rem;
        }

        .article-body {
            line-height: 1.8;
            font-size: 1.1rem;
            color: #495057;
        }

        /* CKEditor Content Styles */
        .ck-content-wrapper {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 100%;
        }

        .ck-content-wrapper h1,
        .ck-content-wrapper h2,
        .ck-content-wrapper h3,
        .ck-content-wrapper h4,
        .ck-content-wrapper h5,
        .ck-content-wrapper h6 {
            margin-top: 2.5rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
            line-height: 1.3;
        }

        .ck-content-wrapper h1 {
            font-size: 2.5rem;
        }

        .ck-content-wrapper h2 {
            font-size: 2rem;
        }

        .ck-content-wrapper h3 {
            font-size: 1.75rem;
        }

        .ck-content-wrapper h4 {
            font-size: 1.5rem;
        }

        .ck-content-wrapper h5 {
            font-size: 1.25rem;
        }

        .ck-content-wrapper h6 {
            font-size: 1rem;
        }

        .ck-content-wrapper p {
            margin-bottom: 1.5rem;
        }

        .ck-content-wrapper ul,
        .ck-content-wrapper ol {
            margin-bottom: 1.5rem;
            padding-left: 2rem;
        }

        .ck-content-wrapper li {
            margin-bottom: 0.5rem;
        }

        .ck-content-wrapper blockquote {
            font-style: italic;
            margin: 2rem 0;
            padding: 1rem 2rem;
            border-left: 4px solid #ccc;
            background-color: #f9f9f9;
        }

        .ck-content-wrapper pre {
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 1rem;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            margin-bottom: 1.5rem;
        }

        .ck-content-wrapper code {
            background-color: #f4f4f4;
            padding: 0.2rem 0.4rem;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
        }

        .ck-content-wrapper table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem;
        }

        .ck-content-wrapper th,
        .ck-content-wrapper td {
            border: 1px solid #ddd;
            padding: 0.75rem;
            text-align: left;
        }

        .ck-content-wrapper th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .ck-content-wrapper img {
            max-width: 100%;
            height: auto;
            margin: 1rem 0;
        }

        .ck-content-wrapper figure {
            margin: 2rem 0;
            text-align: center;
        }

        .ck-content-wrapper figcaption {
            font-size: 0.9rem;
            color: #666;
            margin-top: 0.5rem;
        }

        .ck-content-wrapper hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 2rem 0;
        }

        .ck-content-wrapper .text-center {
            text-align: center;
        }

        .ck-content-wrapper .text-left {
            text-align: left;
        }

        .ck-content-wrapper .text-right {
            text-align: right;
        }

        .ck-content-wrapper .text-justify {
            text-align: justify;
        }

        .ck-content-wrapper strong,
        .ck-content-wrapper b {
            font-weight: 600;
        }

        .ck-content-wrapper em,
        .ck-content-wrapper i {
            font-style: italic;
        }

        .ck-content-wrapper u {
            text-decoration: underline;
        }

        .ck-content-wrapper s,
        .ck-content-wrapper strike {
            text-decoration: line-through;
        }

        .ck-content-wrapper mark {
            background-color: #fff3cd;
            padding: 0.2rem;
        }

        .ck-content-wrapper sub {
            vertical-align: sub;
            font-size: 0.8em;
        }

        .ck-content-wrapper sup {
            vertical-align: super;
            font-size: 0.8em;
        }

        .ck-content-wrapper small {
            font-size: 0.875em;
        }
    </style>
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
                        <p>Dengan membentuk Kantor Kerja Sama dan Pusat Karier (KSPK) UNWIRA berkomitmen untuk meningkatkan kerja sama dengan berbagai Instansi/mitra untuk dapat membangun keunggulan dan kesiapan mahasiswa/i dalam menghadapi perubahan sosial, budaya, kemajuan ilmu pengetahuan dan teknologi serta kemajuan dunia industri atau dunia kerja yang dinamis, pesat dan variatif.

                        </p>
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
                            <li>Email : kspk@unwira.ac.id</li>
                            <li>Telp : 081238317060</li>
                            <li>Address : Jalan San Juan Penfui Timur</li>
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