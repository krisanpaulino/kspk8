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

        <form action="<?= base_url('/cetakkartu') ?>" target="_blank" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="row mb_30">
                <div class="col-lg-12">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>NOTES</strong>: Kartu alumni ini bersifat pribadi, dan hanya bisa dicetak sekali. Jika sudah mencetaknya, harap untuk disimpan sebaik-baiknya, dan dipergunakan sebagaimana mestinya. Jika anda tidak bisa mencetaknya, hubungi admin KSPK Unwira!
                    </div>
                    <br>
                    <label for="alumni_nim"><span class="text-danger">*</span>Masukan NIM alumni</label>
                    <input type="text" class="form-control <?= (isset(session('errors')['alumni_nim'])) ? 'is-invalid' : '' ?>" id="alumni_nim" name="alumni_nim" value="<?= old('alumni_nim') ?>">
                </div>
            </div>

            <div class="form-group mb-4 mt-4">
                <input type="submit" name="simpan" class="btn btn-primary mt-4" value="Cetak kartu">
            </div>
        </form>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    CKEDITOR.replace('editor');
    CKEDITOR.replace('editor1');
    CKEDITOR.replace('editor2');
</script>
<?= $this->endSection(); ?>