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
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/expo') ?>">Expo</a>
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
            <h5 class="card-title">Form Data Expo</h5>
            <hr />
            <form action="<?= base_url('admin/expo/' . $url) ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="expo_id" value="<?= $expo->expo_id ?>">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Tajuk expo</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" class="form-control <?= (isset(session('errors')['expo_judul'])) ? 'is-invalid' : '' ?>" id="expo_judul" name="expo_judul" value="<?= old('expo_judul', $expo->expo_judul) ?>">
                        <div class="invalid-feedback">
                            <?php if (isset(session('errors')['expo_judul'])) : ?>
                                <?= session('errors')['expo_judul'] ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Tahun</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="year" class="form-control <?= (isset(session('errors')['expo_tahun'])) ? 'is-invalid' : '' ?>" id="expo_tahun" name="expo_tahun" value="<?= old('expo_tahun', $expo->expo_tahun) ?>">
                        <div class="invalid-feedback">
                            <?php if (isset(session('errors')['expo_tahun'])) : ?>
                                <?= session('errors')['expo_tahun'] ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Periode</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" class="form-control <?= (isset(session('errors')['expo_periode'])) ? 'is-invalid' : '' ?>" id="expo_periode" name="expo_periode" value="<?= old('expo_periode', $expo->expo_periode) ?>">
                        <div class="invalid-feedback">
                            <?php if (isset(session('errors')['expo_periode'])) : ?>
                                <?= session('errors')['expo_periode'] ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Tanggal</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="date" class="form-control <?= (isset(session('errors')['expo_tanggal'])) ? 'is-invalid' : '' ?>" id="expo_tanggal" name="expo_tanggal" value="<?= old('expo_tanggal', $expo->expo_tanggal) ?>">
                        <div class="invalid-feedback">
                            <?php if (isset(session('errors')['expo_tanggal'])) : ?>
                                <?= session('errors')['expo_tanggal'] ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Isi</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <textarea id="editor" name="expo_isi" aria-hidden="true" style="display: none;" required><?= old('expo_isi', $expo->expo_isi) ?></textarea>
                        <div class="invalid-feedback">
                            <?php if (isset(session('errors')['expo_isi'])) : ?>
                                <?= session('errors')['expo_isi'] ?>
                            <?php endif; ?>
                        </div>
                        <div class="invalid-feedback">
                            <?php if (isset(session('errors')['expo_isi'])) : ?>
                                <?= session('errors')['expo_isi'] ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="submit" class="btn btn-primary px-4" value="Simpan expo" />
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