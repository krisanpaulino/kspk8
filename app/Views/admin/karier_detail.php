<?= $this->extend('layout_admin'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3"><?= $title ?></div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="<?= base_url('admin/karier') ?>">Karier</a></li>
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
    <div class="row">
        <div class="col-lg-4">
            <div class="card bg-dark text-white">
                <img src="<?= base_url('assets/img/karier/' . $karier->karier_flyer) ?>" class="card-img" alt="...">
                <div class="card-img-overlay">
                    <h5 class="card-title text-white">Flyer</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <form action="<?= base_url('admin/karier/update') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="karier_id" value="<?= $karier->karier_id ?>">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Karier</h5>
                        <hr />
                        <input type="hidden" name="karier_id" value="<?= $karier->karier_id ?>">
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Nama Kelas</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" class="form-control <?= (isset(session('errors')['karier_judul'])) ? 'is-invalid' : '' ?>" id="karier_judul" name="karier_judul" value="<?= old('karier_judul', $karier->karier_judul) ?>">
                                <div class="invalid-feedback">
                                    <?php if (isset(session('errors')['karier_judul'])) : ?>
                                        <?= session('errors')['karier_judul'] ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Tanggal</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="text" class="form-control <?= (isset(session('errors')['karier_tanggal'])) ? 'is-invalid' : '' ?>" id="karier_tanggal" name="karier_tanggal" value="<?= old('karier_tanggal', $karier->karier_tanggal) ?>">
                                <div class="invalid-feedback">
                                    <?php if (isset(session('errors')['karier_tanggal'])) : ?>
                                        <?= session('errors')['karier_tanggal'] ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Deskripsi Kelas Persiapan Karier</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <textarea type="text" class="form-control <?= (isset(session('errors')['karier_isi'])) ? 'is-invalid' : '' ?>" id="karier_isi" name="karier_isi"><?= old('karier_isi', $karier->karier_isi) ?></textarea>
                                <div class="invalid-feedback">
                                    <?php if (isset(session('errors')['karier_isi'])) : ?>
                                        <?= session('errors')['karier_isi'] ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Flyer (Kosongkan jika tidak diubah)</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="file" class="form-control <?= (isset(session('errors')['karier_flyer'])) ? 'is-invalid' : '' ?>" id="karier_flyer" name="karier_flyer">
                                <div class="invalid-feedback">
                                    <?php if (isset(session('errors')['karier_flyer'])) : ?>
                                        <?= session('errors')['karier_flyer'] ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9 text-secondary">
                                <input type="submit" class="btn btn-primary px-4" value="Simpan Perubahan" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>