<?= $this->extend('user/main.php'); ?>
<?= $this->section('content'); ?>
<section class="latest_blog_area section_gap">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title_color">Upcoming</h2>
        </div>

        <div class="row mb_30">
            <?php
            foreach ($agenda as $row) {
            ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="single-recent-blog-post ml-3 mr-3">
                            <div class="details">
                                <a href="<?= base_url('/detailagenda/' . $row->agenda_id) ?>">
                                    <h4 class="sec_h4"><?= $row->agenda_judul ?></h4>
                                </a>
                                <?= substr(strip_tags(preg_replace("/<img[^>]+\>/i", "", $row->agenda_deskripsi)), 0, 100) ?>
                                <hr>
                                <h6 class="date title_color"><?= $row->agenda_tanggal ?>, <?= $row->agenda_waktu ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <hr style="margin-top: 50px;">
        <div class="d-flex justify-content-center mt-4" style="margin-top: 50px;">
            <?= $pager->links('paginasi', 'custom_pagination') ?>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>