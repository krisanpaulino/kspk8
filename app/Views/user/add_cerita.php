<?= $this->extend('user/main.php'); ?>
<?= $this->section('content'); ?>
<section class="latest_blog_area section_gap">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title_color"><?= $title ?></h2>
        </div>
        <?php
        if (session()->getFlashdata('success')) {
        ?>
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil !</strong> <?= session()->getFlashdata('success') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        <?php
        }
        ?>

        <?php
        if (session()->getFlashdata('error')) {
        ?>
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal !</strong> <?= session()->getFlashdata('error') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        <?php
        }
        ?>

        <?php
        if ($validationErrors = session()->getFlashdata('validation')) {
        ?>
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal !</strong>
                    <?= $validationErrors->listErrors() ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        <?php
        }
        ?>

        <form action="<?= base_url('/create_cerita') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="row mb_30">
                <div class="col-lg-6">
                    <label for="cerita_nama"><span class="text-danger">*</span>Nama alumni</label>
                    <input type="text" class="form-control <?= (isset(session('errors')['cerita_nama'])) ? 'is-invalid' : '' ?>" id="cerita_nama" name="cerita_nama" value="<?= old('cerita_nama') ?>">
                </div>
                <div class="col-lg-12">
                    <label for="cerita_judul"><span class="text-danger">*</span>Judul</label>
                    <input type="text" class="form-control <?= (isset(session('errors')['cerita_judul'])) ? 'is-invalid' : '' ?>" id="cerita_judul" name="cerita_judul" value="<?= old('cerita_judul') ?>">
                </div>
                <div class="col-lg-12">
                    <div class="form-group mb-4">
                        <label for="cerita_isi"><span class="txt-danger">*</span>Isi cerita</label>
                        <textarea rows="10" class="form-control <?= (isset(session('errors')['cerita_isi'])) ? 'is-invalid' : '' ?>" id="editor2" name="cerita_isi" required><?= old('cerita_isi') ?></textarea>
                    </div>
                </div>
            </div>

            <div class="form-group mb-4">
                <input type="submit" name="simpan" class="btn btn-primary mt-4" value="Simpan">
            </div>
        </form>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    CKEDITOR.replace('editor2', {
        extraPlugins: 'justify'
    });
</script>
<?= $this->endSection(); ?>