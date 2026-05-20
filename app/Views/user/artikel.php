<?= $this->extend('user/main.php'); ?>
<?= $this->section('content'); ?>
<section class="latest_blog_area section_gap">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title_color">Artikel</h2>
            <p>Telusuri artikel terbaru dan cari topik yang Anda butuhkan.</p>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-lg-8">
                <form action="<?= base_url('/artikel') ?>" method="get" class="form-inline d-flex justify-content-center">
                    <input type="text" name="keyword" class="form-control mr-2" placeholder="Cari artikel..." value="<?= esc($keyword ?? '') ?>">
                    <button type="submit" class="btn theme_btn button_hover">Cari</button>
                </form>
            </div>
        </div>

        <?php if (! empty($keyword)) : ?>
            <div class="row mb-3">
                <div class="col-12 text-center">
                    <p>Hasil pencarian untuk: <strong><?= esc($keyword) ?></strong></p>
                </div>
            </div>
        <?php endif ?>

        <div class="row mb_30">
            <?php if (! empty($artikel)) : ?>
                <?php foreach ($artikel as $row) : ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-recent-blog-post">
                            <div class="thumb">
                                <img class="img-fluid" src="<?= base_url('/') ?>assets/images/<?= esc($row->thumbnail ?: 'default.jpg') ?>" alt="<?= esc($row->judul) ?>" style="height:250px; object-fit:cover">
                            </div>
                            <div class="details">
                                <a href="<?= base_url('/detailartikel/' . esc($row->id)) ?>">
                                    <h4 class="sec_h4"><?= esc($row->judul) ?></h4>
                                </a>
                                <p><?= esc(substr(strip_tags(preg_replace('/<img[^>]+>/i', '', sanitize_html_content($row->isi))), 0, 120)) ?>...</p>
                                <h6 class="date title_color"><?= esc(date('d-M-Y', strtotime($row->published_at ?? $row->created_at))) ?></h6>
                                <a class="button_hover" href="<?= base_url('/detailartikel/' . esc($row->id)) ?>">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else : ?>
                <div class="col-12">
                    <p class="text-center">Belum ada artikel yang sesuai.</p>
                </div>
            <?php endif ?>
        </div>

        <?php if (! empty($pager)) : ?>
            <div class="d-flex justify-content-center mt-4">
                <?= $pager->links('paginasi', 'custom_pagination') ?>
            </div>
        <?php endif ?>
    </div>
</section>
<?= $this->endSection(); ?>