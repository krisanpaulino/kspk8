<?= $this->extend('user/main.php'); ?>
<?= $this->section('content'); ?>
<section class="latest_blog_area section_gap">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title_color">Berita</h2>
        </div>

        <div class="row mb_30">
            <?php
            foreach ($berita as $row) {
            ?>
                <div class="col-lg-4 col-md-6">
                    <div class="single-recent-blog-post">
                        <div class="thumb">
                            <img class="img-fluid" src="<?= base_url('/') ?>assets/images/<?= $row->berita_thumbnail ?>" class="rounded" alt="Gambar berita" style="height:250px; object-fit:cover">
                        </div>
                        <div class="details">
                            <a href="<?= base_url('/detailberita/' . esc($row->berita_id)) ?>">
                                <h4 class="sec_h4"><?= esc($row->berita_judul) ?></h4>
                            </a>
                            <?= substr(strip_tags(preg_replace("/<img[^>]+\>/i", "", sanitize_html_content($row->berita_isi))), 0, 150) ?>
                            <h6 class="date title_color"><?= esc(date('d-M-Y, h:i:sa', strtotime($row->berita_tanggal))) ?></h6>
                        </div>
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