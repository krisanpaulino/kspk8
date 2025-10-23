<?= $this->extend('layout_admin'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tambah Cerita Alumni</h5>
            <form action="<?= base_url('admin/cerita-alumni/create') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="alumni_nim" class="form-label">NIM Alumni</label>
                    <input type="text" class="form-control" id="alumni_nim" name="alumni_nim" value="<?= old('alumni_nim') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="cerita_nama" class="form-label">Nama Alumni</label>
                    <input type="text" class="form-control" id="cerita_nama" name="cerita_nama" value="<?= old('cerita_nama') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="cerita_judul" class="form-label">Judul Cerita</label>
                    <input type="text" class="form-control" id="cerita_judul" name="cerita_judul" value="<?= old('cerita_judul') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="cerita_isi" class="form-label">Isi Cerita</label>
                    <textarea class="form-control" id="editor2" name="cerita_isi" rows="10" required><?= old('cerita_isi') ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan</button>
                <a href="<?= base_url('admin/cerita-alumni') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    CKEDITOR.replace('editor2', {
        extraPlugins: ['justify', 'grid']
    });
</script>
<?= $this->endSection(); ?>