<?= $this->extend('user/main.php'); ?>
<?= $this->section('content'); ?>
<section class="latest_blog_area section_gap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <article class="article-content bg-white p-4 rounded shadow-sm">
                    <header class="article-header text-center mb-4">
                        <h1 class="article-title display-4 text-dark"><?= esc($cerita->cerita_judul) ?></h1>
                        <div class="article-meta text-muted">
                            <span>By <?= esc($cerita->cerita_nama) ?></span> |
                            <span><?= esc(date('d-M-Y h:i:sa', strtotime($cerita->cerita_tanggal))) ?></span>
                        </div>
                    </header>
                    <div class="article-body ck-content-wrapper">
                        <?= sanitize_html_content($cerita->cerita_isi) ?>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>