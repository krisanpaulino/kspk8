<?= $this->extend('user/main.php'); ?>
<?= $this->section('content'); ?>
<section class="single-post-area">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title_color">KSPK - Unwira</h2>
        </div>
        <div class="single-post row">
            <div class="col">
                <?= sanitize_html_content($page->page_content) ?>
            </div>
        </div>

    </div>
</section>
<?= $this->endSection(); ?>