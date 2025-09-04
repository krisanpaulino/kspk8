<?= $this->extend('user/main.php'); ?>
<?= $this->section('content'); ?>
<section class="latest_blog_area section_gap">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title_color"><?= $title ?></h2>
        </div>
        <div class="row">
            <a href="<?= base_url('/add_cerita') ?>" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> Tulis cerita anda</a>
        </div>
        <div class="row mb_30 mt-4">
            <?php
            if (session()->getFlashdata('success')) {
            ?>
                <div class="container">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil !</strong> <?= session()->getFlashdata('success') ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            <?php
            }
            ?>

            <?php
            if (session()->getFlashdata('error')) {
            ?>
                <div class="container">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal !</strong> <?= session()->getFlashdata('error') ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            <?php
            }
            ?>

            <!-- LIST CERITA -->
            <?php
            foreach ($cerita as $row) {
            ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="single-recent-blog-post mx-4">
                            <div class="details">
                                <div class="tags">
                                    <p class="tag_btn"><?= $row->cerita_nama ?></p>
                                </div>
                                <a href="<?= base_url('/detailcerita/' . $row->cerita_id) ?>">
                                    <h4 class="sec_h4"><?= $row->cerita_judul ?></h4>
                                </a>
                                <?= substr(strip_tags(preg_replace("/<img[^>]+\>/i", "", $row->cerita_isi)), 0, 150) ?>
                                <h6 class="date title_color mt-3"><?= date('d-M-Y, h:i:sa', strtotime($row->cerita_tanggal)) ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>