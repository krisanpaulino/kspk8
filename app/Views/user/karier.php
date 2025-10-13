<?= $this->extend('user/main.php'); ?>
<?= $this->section('content'); ?>

<section class="latest_blog_area section_gap">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title_color">Kelas Persiapan Karier</h2>
        </div>
        <div class="row mb_30">
            <?php
            foreach ($karier as $row) {
            ?>
                <div class="col-lg-4 col-md-6">
                    <div class="thumb">
                        <img class="img-fluid" src="<?= base_url('/') ?>assets/img/karier/<?= $row->karier_flyer ?>" class="rounded" alt="Flyer Persiapan Karier" style="height:250px; object-fit:cover">
                    </div>
                    <div class="details">
                        <!-- <div class="tags">
                                <a href="#" class="button_hover tag_btn">Travel</a>
                                <a href="#" class="button_hover tag_btn">Life Style</a>
                            </div> -->
                        <a href="<?= base_url('/karier/' . $row->karier_id) ?>">
                            <h4 class="sec_h4"><?= $row->karier_judul ?></h4>
                        </a>
                        <?= substr(strip_tags(preg_replace("/<img[^>]+\>/i", "", $row->karier_isi)), 0, 150) ?>
                        <h6 class="date title_color"><?= $row->karier_tanggal ?></h6>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="d-flex justify-content-center mt-4">
            <?= $pager->links('paginasi', 'custom_pagination') ?>
        </div>
    </div>
</section>


<?= $this->endSection(); ?>