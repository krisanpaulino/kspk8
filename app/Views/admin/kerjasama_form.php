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
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/kerjasama') ?>">Kerjasama</a>
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
            <h5 class="card-title">Tambah Data Kerjasama</h5>
            <hr />
            <form action="<?= base_url('admin/kerjasama/' . $url) ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="kerjasama_id" value="<?= $kerjasama->kerjasama_id ?>">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Tajuk Kerjasama</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" class="form-control <?= (isset(session('errors')['kerjasama_nama'])) ? 'is-invalid' : '' ?>" id="kerjasama_nama" name="kerjasama_nama" value="<?= old('kerjasama_nama', $kerjasama->kerjasama_nama) ?>">
                        <div class="invalid-feedback">
                            <?php if (isset(session('errors')['kerjasama_nama'])) : ?>
                                <?= session('errors')['kerjasama_nama'] ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Jenis kerjasama</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <select class="form-select <?= (isset(session('errors')['kerjasama_jenis'])) ? 'is-invalid' : '' ?>" id="kerjasama_jenis" name="kerjasama_jenis" required>
                            <option value="">Pilih Jenis kerjasama</option>
                            <option value="Lokal" <?= (old('kerjasama_jenis', $kerjasama->kerjasama_jenis) == 'Lokal') ? 'selected' : '' ?>>Lokal</option>
                            <option value="Nasional" <?= (old('kerjasama_jenis', $kerjasama->kerjasama_jenis) == 'Nasional') ? 'selected' : '' ?>>Nasional</option>
                            <option value="Internasional" <?= (old('kerjasama_jenis', $kerjasama->kerjasama_jenis) == 'Internasional') ? 'selected' : '' ?>>Internasional</option>
                        </select>
                        <div class="invalid-feedback">
                            <?php if (isset(session('errors')['kerjasama_jenis'])) : ?>
                                <?= session('errors')['kerjasama_jenis'] ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Deskripsi Singkat</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <textarea type="text" class="form-control <?= (isset(session('errors')['kerjasama_deskripsi'])) ? 'is-invalid' : '' ?>" id="kerjasama_deskripsi" name="kerjasama_deskripsi"><?= old('kerjasama_deskripsi', $kerjasama->kerjasama_deskripsi) ?></textarea>
                        <div class="invalid-feedback">
                            <?php if (isset(session('errors')['kerjasama_deskripsi'])) : ?>
                                <?= session('errors')['kerjasama_deskripsi'] ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Isi</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <textarea id="editor" name="kerjasama_isi" aria-hidden="true" style="display: none;" required><?= old('kerjasama_isi', $kerjasama->kerjasama_isi) ?></textarea>
                        <div class="invalid-feedback">
                            <?php if (isset(session('errors')['kerjasama_isi'])) : ?>
                                <?= session('errors')['kerjasama_isi'] ?>
                            <?php endif; ?>
                        </div>
                        <div class="invalid-feedback">
                            <?php if (isset(session('errors')['kerjasama_nama'])) : ?>
                                <?= session('errors')['kerjasama_nama'] ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="submit" class="btn btn-primary px-4" value="Simpan Kerjasama" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
<script src="<?= base_url() ?>/assets/plugins/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor', {
        extraPlugins: 'justify'
    });
</script>
<?= $this->endSection(); ?>