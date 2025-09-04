<?= $this->extend('user/main.php'); ?>
<?= $this->section('content'); ?>
<section class="latest_blog_area section_gap">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title_color"><?= $karier->karier_judul  ?></h2>
        </div>

        <div class="row mb-4">
            <img class="img-fluid img-thumbnail" src="<?= base_url('/') ?>assets/img/karier/<?= $karier->karier_flyer ?>" class="rounded" alt="Gambar expo" style="height:250px; object-fit:cover">

        </div>
        <div class="mt-4 mb-4">
            <h6>Tanggal : <?= $karier->karier_tanggal ?></h6>
        </div>
        <div class="row mb_30">
            <?= $karier->karier_isi ?>
        </div>
        
        
    </div>
</section>
<?= $this->endSection(); ?>