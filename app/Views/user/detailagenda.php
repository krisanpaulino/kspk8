<?= $this->extend('user/main.php'); ?>
<?= $this->section('content'); ?>
<section class="latest_blog_area section_gap">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title_color"><?= $agenda->agenda_judul  ?></h2>
        </div>
        <div class="mt-4 mb-4">
            <?= $agenda->agenda_tanggal ?>, <?= $agenda->agenda_waktu ?>
        </div>
        <div class="row mb_30">
            <?= $agenda->agenda_deskripsi ?>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>