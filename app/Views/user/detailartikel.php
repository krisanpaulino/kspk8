<?= $this->extend('user/main.php'); ?>
<?= $this->section('content'); ?>
<section class="latest_blog_area section_gap">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title_color"><?= esc($artikel->judul) ?></h2>
        </div>
        <div class="text-center mb-4">
            <span class="date title_color"><?= esc(date('d-M-Y h:i:sa', strtotime($artikel->published_at ?? $artikel->created_at))) ?></span>
        </div>
        <div class="row mb_30">
            <div class="col-12 mb-4 text-center">
                <img class="img-fluid" src="<?= base_url('/') ?>assets/images/<?= esc($artikel->thumbnail ?: 'default.jpg') ?>" alt="<?= esc($artikel->judul) ?>" style="max-height: 450px; object-fit: cover; width:100%;">
            </div>
            <div class="col-12">
                <div class="ck-content-wrapper">
                    <?= sanitize_html_content($artikel->isi) ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>