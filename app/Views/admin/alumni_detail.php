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
                    <li class="breadcrumb-item active" aria-current="page"><a href="<?= base_url('admin/alumni') ?>">Alumni</a></li>
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
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-8">
                    <form action="<?= base_url('admin/alumni/update') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="alumni_id" value="<?= $alumni->alumni_id ?>">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Data Alumni</h5>
                                <hr />
                                <input type="hidden" name="alumni_id" value="<?= $alumni->alumni_id ?>">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Nama Lengkap</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control <?= (isset(session('errors')['alumni_nama'])) ? 'is-invalid' : '' ?>" id="alumni_nama" name="alumni_nama" value="<?= old('alumni_nama', $alumni->alumni_nama) ?>">
                                        <div class="invalid-feedback">
                                            <?php if (isset(session('errors')['alumni_nama'])) : ?>
                                                <?= session('errors')['alumni_nama'] ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">NIM</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control <?= (isset(session('errors')['alumni_nim'])) ? 'is-invalid' : '' ?>" id="alumni_nim" name="alumni_nim" value="<?= old('alumni_nim', $alumni->alumni_nim) ?>">
                                        <div class="invalid-feedback">
                                            <?php if (isset(session('errors')['alumni_nim'])) : ?>
                                                <?= session('errors')['alumni_nim'] ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Prodi</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <select class="form-select <?= (isset(session('errors')['prodi_id'])) ? 'is-invalid' : '' ?>" id="prodi_id" name="prodi_id">
                                            <option value="">Pilih Prodi</option>
                                            <?php foreach ($prodi as $p) : ?>
                                                <option value="<?= $p->prodi_id ?>" <?= (old('prodi_id', $alumni->prodi_id) == $p->prodi_id) ? 'selected' : '' ?>><?= $p->prodi_nama ?></option>
                                            <?php endforeach ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?php if (isset(session('errors')['prodi_id'])) : ?>
                                                <?= session('errors')['prodi_id'] ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Tahun Lulus</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="year" class="form-control <?= (isset(session('errors')['alumni_tahunlulus'])) ? 'is-invalid' : '' ?>" id="alumni_tahunlulus" name="alumni_tahunlulus" value="<?= old('alumni_tahunlulus', $alumni->alumni_tahunlulus) ?>">
                                        <div class="invalid-feedback">
                                            <?php if (isset(session('errors')['alumni_tahunlulus'])) : ?>
                                                <?= session('errors')['alumni_tahunlulus'] ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Jenis Kelamin</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <select class="form-select <?= (isset(session('errors')['alumni_jeniskelamin'])) ? 'is-invalid' : '' ?>" id="alumni_jeniskelamin" name="alumni_jeniskelamin" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="L" <?= (old('alumni_jeniskelamin', $alumni->alumni_jeniskelamin) == 'L') ? 'selected' : '' ?>>Laki - Laki</option>
                                            <option value="P" <?= (old('alumni_jeniskelamin', $alumni->alumni_jeniskelamin) == 'P') ? 'selected' : '' ?>>Perempuan</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?php if (isset(session('errors')['alumni_jeniskelamin'])) : ?>
                                                <?= session('errors')['alumni_jeniskelamin'] ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">No. HP</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control <?= (isset(session('errors')['alumni_telepon'])) ? 'is-invalid' : '' ?>" id="alumni_telepon" name="alumni_telepon" value="<?= old('alumni_telepon', $alumni->alumni_telepon) ?>">
                                        <div class="invalid-feedback">
                                            <?php if (isset(session('errors')['alumni_telepon'])) : ?>
                                                <?= session('errors')['alumni_telepon'] ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control <?= (isset(session('errors')['alumni_email'])) ? 'is-invalid' : '' ?>" id="alumni_email" name="alumni_email" value="<?= old('alumni_email', $alumni->alumni_email) ?>">
                                        <div class="invalid-feedback">
                                            <?php if (isset(session('errors')['alumni_email'])) : ?>
                                                <?= session('errors')['alumni_email'] ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- Image here -->
                                <!-- <div class="form-group mb-4">
                                    <label for="alumni_foto">Foto (Biarkan kosong jika tidak ingin merubah)</label>
                                    <input type="file" class="form-control <?= (isset(session('errors')['alumni_foto'])) ? 'is-invalid' : '' ?>" id="alumni_foto" name="alumni_foto">
                                    <div class="invalid-feedback">
                                        <?php if (isset(session('errors')['alumni_foto'])) : ?>
                                            <?= session('errors')['alumni_foto'] ?>
                                        <?php endif; ?>
                                    </div>
                                </div> -->
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
    </div>
</div>
<?= $this->endSection(); ?>