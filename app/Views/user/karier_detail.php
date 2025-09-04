<?= $this->extend('user/main.php'); ?>
<?= $this->section('content'); ?>
<section class="latest_blog_area section_gap">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title_color"><?= $expo->karier_judul  ?></h2>
        </div>
        <div class="mt-4 mb-4">
            <?= date('d-M-Y h:i:sa', strtotime($karier->karier_tanggal)) ?>
        </div>
        <div class="row mb-4">
            <img class="img-fluid img-thumbnail" src="<?= base_url('/') ?>assets/images/<?= $row->expo_gambar ?>" class="rounded" alt="Gambar expo" style="height:250px; object-fit:cover">

        </div>
        <div class="row mb_30">
            <?= $karier->karier_isi ?>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>