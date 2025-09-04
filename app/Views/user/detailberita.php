<?= $this->extend('user/main.php'); ?>
<?= $this->section('content'); ?>
<section class="latest_blog_area section_gap">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title_color"><?= $berita->berita_judul  ?></h2>
        </div>
        <div class="mt-4 mb-4">
            <?= date('d-M-Y h:i:sa', strtotime($berita->berita_tanggal)) ?>
        </div>
        <div class="row mb_30">
            <?= $berita->berita_isi ?>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>