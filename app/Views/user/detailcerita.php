<?= $this->extend('user/main.php'); ?>
<?= $this->section('content'); ?>
<section class="latest_blog_area section_gap">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title_color"><?= $cerita->cerita_judul  ?></h2>
        </div>
        <div class="mt-4 mb-4">
            <?= date('d-M-Y h:i:sa', strtotime($cerita->cerita_tanggal)) ?><br>
            <?= $cerita->cerita_nama ?> (<?= $cerita->alumni_nim ?>)<br>
        </div>
        <div class="row mb_30">
            <?= $cerita->cerita_isi ?>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>