<?= $this->extend('layout_admin'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tambah Cerita Alumni</h5>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal!</strong> <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if ($validationErrors = session()->getFlashdata('validation')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal!</strong>
                    <?= $validationErrors->listErrors() ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/cerita-alumni/create') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="cerita_nama" class="form-label"><span class="text-danger">*</span> Nama Alumni</label>
                    <input type="text" class="form-control <?= (isset(session('errors')['cerita_nama'])) ? 'is-invalid' : '' ?>" id="cerita_nama" name="cerita_nama" value="<?= old('cerita_nama') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="cerita_judul" class="form-label"><span class="text-danger">*</span> Judul Cerita</label>
                    <input type="text" class="form-control <?= (isset(session('errors')['cerita_judul'])) ? 'is-invalid' : '' ?>" id="cerita_judul" name="cerita_judul" value="<?= old('cerita_judul') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="cerita_isi" class="form-label"><span class="text-danger">*</span> Isi Cerita</label>
                    <textarea rows="10" class="form-control <?= (isset(session('errors')['cerita_isi'])) ? 'is-invalid' : '' ?>" id="editor2" name="cerita_isi" required><?= old('cerita_isi') ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan</button>
                <a href="<?= base_url('admin/cerita-alumni') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<!-- <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script> -->
<script>
    CKEDITOR.replace('editor2', {
        extraPlugins: ['justify', 'btgrid']
    });
</script>
<?= $this->endSection(); ?>