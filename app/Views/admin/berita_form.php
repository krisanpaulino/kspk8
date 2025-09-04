<?= $this->extend('layout_admin'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3"><?= $title ?></div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/berita') ?>">Berita</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <?php if (session()->has('success')) : ?>
        <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
            <div class="text-white"><?= session('success') ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>
    <?php if (session()->has('danger')) : ?>
        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
            <div class="text-white"><?= session('danger') ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Form Berita</h5>
            <hr />
            <form action="<?= base_url('admin/berita/' . $url) ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="berita_id" value="<?= $berita->berita_id ?>">
                <div class="form-group mb-4">
                    <label for="berita_judul"><span class="txt-danger">*</span>Judul</label>
                    <input type="text" class="form-control <?= (isset(session('errors')['berita_judul'])) ? 'is-invalid' : '' ?>" id="berita_judul" name="berita_judul" value="<?= old('berita_judul', $berita->berita_judul) ?>">
                    <div class="invalid-feedback">
                        <?php if (isset(session('errors')['berita_judul'])) : ?>
                            <?= session('errors')['berita_judul'] ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="berita_isi"><span class="txt-danger">*</span>Isi</label>
                    <textarea rows="30" class="form-control <?= (isset(session('errors')['berita_isi'])) ? 'is-invalid' : '' ?>" id="editor2" name="berita_isi"><?= old('berita_isi', $berita->berita_isi) ?></textarea>
                    <div class="invalid-feedback">
                        <?php if (isset(session('errors')['berita_isi'])) : ?>
                            <?= session('errors')['berita_isi'] ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <button type="submit" class="btn btn-primary">Simpan Berita</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
<script>
    CKEDITOR.replace('editor');
    CKEDITOR.replace('editor1');
    CKEDITOR.replace('editor2');
</script>
<?= $this->endSection(); ?>