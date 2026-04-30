<!doctype html>
<html class="color-sidebar sidebarcolor8 color-header headercolor2" lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="<?= base_url() ?>/assets-user/image/favicon.png" type="image/png" />
    <!--plugins-->
    <link href="<?= base_url() ?>/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="<?= base_url() ?>/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="<?= base_url() ?>/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="<?= base_url() ?>/assets/css/pace.min.css" rel="stylesheet" />
    <script src="<?= base_url() ?>/assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="<?= base_url() ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/css/app.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/css/icons.css" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/dark-theme.css" />
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/semi-dark.css" />
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/header-colors.css" />
    <link rel="stylesheet" type="text/css" id="mce-u0" referrerpolicy="origin" href="https://cdn.tiny.cloud/1/no-origin/tinymce/5.10.7-133/skins/ui/oxide/skin.min.css">
    <title><?= $title ?> | KSPK Unwira</title>
    <style>
        body {
            background-color: rgb(243, 243, 250);
        }

        .page-footer {
            background-color: rgb(198, 198, 199);
        }
    </style>
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                </div>
                <div>
                    <h4 class="logo-text">KSPK</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
                </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <li>
                    <a href="<?= base_url('admin') ?>">
                        <div class="parent-icon"><i class='bx bx-home-circle'></i>
                        </div>
                        <div class="menu-title">Dashboard</div>
                    </a>
                </li>
                <li class="menu-label">Alumni</li>

                <li>
                    <a href="<?= base_url('admin/alumni') ?>">
                        <div class="parent-icon"><i class="bx bx-user-circle"></i>
                        </div>
                        <div class="menu-title">Data Alumni</div>
                    </a>
                </li>
                <li class="menu-label">KSPK</li>
                <li>
                    <a href="<?= base_url('admin/kerjasama') ?>">
                        <div class="parent-icon"><i class="bx bx-book-alt"></i>
                        </div>
                        <div class="menu-title">Kerjasama</div>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/expo') ?>">
                        <div class="parent-icon"><i class="bx bx-book-alt"></i>
                        </div>
                        <div class="menu-title">Carrier Expo</div>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/karier') ?>">
                        <div class="parent-icon"><i class="bx bx-book-alt"></i>
                        </div>
                        <div class="menu-title">Persiapan Karier</div>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/upcoming') ?>">
                        <div class="parent-icon"><i class="bx bx-bookmarks"></i>
                        </div>
                        <div class="menu-title">Upcoming</div>
                    </a>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
                        </div>
                        <div class="menu-title">Cerita Alumni</div>
                    </a>
                    <ul>
                        <li> <a href="<?= base_url('admin/cerita-alumni') ?>"><i class='bx bx-radio-circle'></i>Pending</a>
                        <li> <a href="<?= base_url('admin/cerita-alumni/approved') ?>"><i class='bx bx-radio-circle'></i>Approved</a>
                        <li> <a href="<?= base_url('admin/cerita-alumni/rejected') ?>"><i class='bx bx-radio-circle'></i>Rejected</a>
                        </li>
                    </ul>
                </li>
                <li class="menu-label">Utility</li>
                <li>
                    <a href="<?= base_url('admin/profile') ?>">
                        <div class="parent-icon"><i class="bx bx-user"></i>
                        </div>
                        <div class="menu-title">Profile</div>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/page') ?>">
                        <div class="parent-icon"><i class="bx bx-detail"></i>
                        </div>
                        <div class="menu-title">Pages</div>
                    </a>
                </li>
            </ul>
            <!--end navigation-->
        </div>
        <!--end sidebar wrapper -->
        <!--start header -->
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                    </div>
                    <div class="search-bar flex-grow-1">
                        <div class="position-relative search-bar-box">
                            <!-- <input type="text" class="form-control search-control" placeholder="Type to search..."> <span class="position-absolute top-50 search-show translate-middle-y"><i class='bx bx-search'></i></span>
                            <span class="position-absolute top-50 search-close translate-middle-y"><i class='bx bx-x'></i></span> -->


                        </div>
                    </div>
                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center">
                            <li class="nav-item mobile-search-icon">
                                <a class="nav-link" href="#"> <i class='bx bx-search'></i>
                                </a>
                            </li>
                            <li class="nav-item dropdown dropdown-large">
                                <!-- <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count">7</span>
                                    <i class='bx bx-bell'></i>
                                </a> -->
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- <a href="javascript:;">
                                        <div class="msg-header">
                                            <p class="msg-header-title">Notifications</p>
                                            <p class="msg-header-clear ms-auto">Marks all as read</p>
                                        </div>
                                    </a> -->
                                    <div class="header-notifications-list"> </div>
                                    <!-- <a href="javascript:;">
                                        <div class="text-center msg-footer">View All Notifications</div>
                                    </a> -->
                                </div>
                            </li>
                            <li class="nav-item dropdown dropdown-large">
                                <!-- <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count">8</span>
                                    <i class='bx bx-comment'></i>
                                </a> -->
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- <a href="javascript:;">
                                        <div class="msg-header">
                                            <p class="msg-header-title">Messages</p>
                                            <p class="msg-header-clear ms-auto">Marks all as read</p>
                                        </div>
                                    </a> -->
                                    <div class="header-message-list"></div>
                                    <!-- <a href="javascript:;">
                                        <div class="text-center msg-footer">View All Messages</div>
                                    </a> -->
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="user-box dropdown">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?= base_url() ?>/assets-user/image/favicon.png" class="user-img" alt="user avatar">
                            <div class="user-info ps-3">
                                <p class="user-name mb-0"><?= 'admin' ?></p>
                                <p class="designattion mb-0">Admin</p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= base_url('admin/profile') ?>"><i class="bx bx-user"></i><span>Profile</span></a>
                            </li>
                            <li><a class="dropdown-item" href="<?= base_url('admin/profile') ?>"><i class="bx bx-key"></i><span>Ubah Password</span></a>
                            </li>
                            <li>
                                <div class="dropdown-divider mb-0"></div>
                            </li>
                            <li>
                                <form action="<?= base_url('auth/logout') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <button class="dropdown-item" type="submit"><i class='bx bx-log-out-circle'></i><span>Logout</span></button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!--end header -->
        <!--start page wrapper -->
        <div class="page-wrapper">
            <?= $this->renderSection('content'); ?>
            <!--end page content -->
        </div>
        <!--end page wrapper -->
        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        <footer class="page-footer">
            <p class="mb-0">Copyright © 2025. All right reserved.</p>
        </footer>
    </div>
    <!--end wrapper-->
    <!--start switcher-->
    <!--end switcher-->
    <!-- Bootstrap JS -->
    <script src="<?= base_url() ?>/assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="<?= base_url() ?>/assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/chartjs/js/chart.min.js"></script>
    <script src="<?= base_url('assets/js/') ?>ckeditor/ckeditor.js"></script>
    <!--app JS-->
    <script src="<?= base_url() ?>/assets/js/app.js"></script>
    <?= $this->renderSection('scripts'); ?>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>

</body>

</html>