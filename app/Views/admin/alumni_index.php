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
                    <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#form">Tambah</button>
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#excel">Upload Excel</button>
            <!-- Modal -->
            <div class="modal fade" id="form" tabindex="-1" aria-labelledby="formLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="formLabel">Tambah Alumni</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('admin/alumni/insert') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="modal-body">
                                <div class="form-group mb-4">
                                    <label for="alumni_nama">Nama Alumni</label>
                                    <input type="text" class="form-control <?= (isset(session('errors')['alumni_nama'])) ? 'is-invalid' : '' ?>" id="alumni_nama" name="alumni_nama" value="<?= old('alumni_nama') ?>">
                                    <div class="invalid-feedback">
                                        <?php if (isset(session('errors')['alumni_nama'])) : ?>
                                            <?= session('errors')['alumni_nama'] ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="prodi_id">Prodi</label>
                                    <select class="form-select <?= (isset(session('errors')['prodi_id'])) ? 'is-invalid' : '' ?>" id="prodi_id" name="prodi_id">
                                        <option value="">Pilih Prodi</option>
                                        <?php foreach ($prodi as $p) : ?>
                                            <option value="<?= $p->prodi_id ?>" <?= (old('prodi_id') == $p->prodi_id) ? 'selected' : '' ?>><?= $p->prodi_nama ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?php if (isset(session('errors')['prodi_id'])) : ?>
                                            <?= session('errors')['prodi_id'] ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="alumni_nim">NIM</label>
                                    <input type="text" class="form-control <?= (isset(session('errors')['alumni_nim'])) ? 'is-invalid' : '' ?>" id="alumni_nim" name="alumni_nim" value="<?= old('alumni_nim') ?>">
                                    <div class="invalid-feedback">
                                        <?php if (isset(session('errors')['alumni_nim'])) : ?>
                                            <?= session('errors')['alumni_nim'] ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="alumni_tahunlulus">Tahun Lulus</label>
                                    <input type="text" class="form-control <?= (isset(session('errors')['alumni_tahunlulus'])) ? 'is-invalid' : '' ?>" id="alumni_tahunlulus" name="alumni_tahunlulus" value="<?= old('alumni_tahunlulus') ?>">
                                    <div class="invalid-feedback">
                                        <?php if (isset(session('errors')['alumni_tahunlulus'])) : ?>
                                            <?= session('errors')['alumni_tahunlulus'] ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="alumni_jeniskelamin">Jenis Kelamin</label>
                                    <select class="form-select <?= (isset(session('errors')['alumni_jeniskelamin'])) ? 'is-invalid' : '' ?>" id="alumni_jeniskelamin" name="alumni_jeniskelamin" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" <?= (old('alumni_jeniskelamin') == 'L') ? 'selected' : '' ?>>Laki - Laki</option>
                                        <option value="P" <?= (old('alumni_jeniskelamin') == 'P') ? 'selected' : '' ?>>Perempuan</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?php if (isset(session('errors')['alumni_jeniskelamin'])) : ?>
                                            <?= session('errors')['alumni_jeniskelamin'] ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="alumni_email">Email</label>
                                    <input type="text" class="form-control <?= (isset(session('errors')['alumni_email'])) ? 'is-invalid' : '' ?>" id="alumni_email" name="alumni_email" value="<?= old('alumni_email') ?>">
                                    <div class="invalid-feedback">
                                        <?php if (isset(session('errors')['alumni_email'])) : ?>
                                            <?= session('errors')['alumni_email'] ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="alumni_telepon">No. HP</label>
                                    <input type="text" class="form-control <?= (isset(session('errors')['alumni_telepon'])) ? 'is-invalid' : '' ?>" id="alumni_telepon" name="alumni_telepon" value="<?= old('alumni_telepon') ?>">
                                    <div class="invalid-feedback">
                                        <?php if (isset(session('errors')['alumni_telepon'])) : ?>
                                            <?= session('errors')['alumni_telepon'] ?>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="excel" tabindex="-1" aria-labelledby="formLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="formLabel">Upload Data Alumni</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('admin/alumni/upload') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="modal-body">
                                <div class="form-group mb-4">
                                    <label for="file">File Excel</label>
                                    <input type="file" class="form-control <?= (isset(session('errors')['file'])) ? 'is-invalid' : '' ?>" id="file" name="file" value="<?= old('file') ?>">
                                    <div class="invalid-feedback">
                                        <?php if (isset(session('errors')['file'])) : ?>
                                            <?= session('errors')['file'] ?>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
            <h5 class="card-title">Data Alumni Unwira</h5>
            <hr />
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>JK</th>
                            <th>Tahun Lulus</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alumni as $row) : ?>
                            <tr>
                                <td><?= $row->alumni_nama ?></td>
                                <td><?= $row->alumni_nim ?></td>
                                <td><?= $row->alumni_jeniskelamin ?></td>
                                <td><?= $row->alumni_tahunlulus ?></td>
                                <td>
                                    <a href="<?= base_url('admin/alumni/' . $row->alumni_id) ?>" class="badge bg-info">Detail</a>
                                    <a href="javascript;" data-bs-toggle="modal" data-bs-target="#hapus" data-id="<?= $row->alumni_id ?>" class="badge bg-danger">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade in" id="hapus" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/alumni/delete') ?>" method="post">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <input type="hidden" name="alumni_id" id="kodeitem" class="d-flex d-none">
                    <h5>Anda yakin ingin menghapus data alumni?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
<script>
    $('#hapus').on('show.bs.modal', function(event) {
        console.log('Here');
        var kode = $(event.relatedTarget).data('id');
        $(this).find('#kodeitem').attr("value", kode);
        // $(this).find('#namaitem').attr("value", nama);
    });
</script>
<?= $this->endSection(); ?>