<?= $this->extend('user/main.php'); ?>
<?= $this->section('content'); ?>
<section class="latest_blog_area section_gap">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title_color">KSPK - Unwira</h2>
        </div>
        <div class="col">
            <?= $page->page_content ?>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>