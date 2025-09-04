<?= $this->extend('user/main.php'); ?>
<?= $this->section('content'); ?>
<section class="latest_blog_area section_gap">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title_color"><?= $kerjasama->kerjasama_nama  ?></h2>
        </div>

        <div class="mt-4 mb-4">
            <center>
                <img class="img-fluid" src="<?= base_url('/') ?>assets/images/<?= $kerjasama->kerjasama_gambar ?>" class="rounded" alt="Gambar kerjasama" style="width:500px;">
            </center>
        </div>

        <div class="mb-4">
            <center>Kerja sama <?= $kerjasama->kerjasama_jenis ?></center>
        </div>

        <div class="row mb_30">
            <?= $kerjasama->kerjasama_isi ?>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>