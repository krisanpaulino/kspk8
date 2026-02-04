<?= $this->extend('layout_admin'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Edit Cerita Alumni</h5>
            <form action="<?= base_url('admin/cerita-alumni/update') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="cerita_id" value="<?= $cerita->cerita_id ?>">
                <div class="mb-3">
                    <label for="cerita_nama" class="form-label"><span class="text-danger">*</span> Nama Alumni</label>
                    <input type="text" class="form-control <?= (isset(session('errors')['cerita_nama'])) ? 'is-invalid' : '' ?>" id="cerita_nama" name="cerita_nama" value="<?= old('cerita_nama') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="cerita_judul" class="form-label">Judul Cerita</label>
                    <input type="text" class="form-control" id="cerita_judul" name="cerita_judul" value="<?= esc($cerita->cerita_judul) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="cerita_isi" class="form-label">Isi Cerita</label>
                    <textarea class="form-control" id="editor2" name="cerita_isi" rows="10" required><?= $cerita->cerita_isi ?></textarea>
                </div>
                <button type="submit" class="btn btn-success"><i class="bx bx-save"></i> Simpan</button>
                <a href="<?= base_url('admin/cerita-alumni') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<!-- CKEditor CDN, same as add_cerita.php -->
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor2', {
        extraPlugins: 'justify'
    });
</script>
<?= $this->endSection(); ?>