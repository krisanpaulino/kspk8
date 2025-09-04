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
        </div>
        <!-- Modal -->
        <div class="modal fade" id="form" tabindex="-1" aria-labelledby="formLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formLabel">Tambah Kelas Persiapan Karier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= base_url('admin/karier/insert') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="modal-body">
                            <div class="form-group mb-4">
                                <label for="karier_judul">Nama Kelas</label>
                                <input type="text" class="form-control <?= (isset(session('errors')['karier_judul'])) ? 'is-invalid' : '' ?>" id="karier_judul" name="karier_judul" value="<?= old('karier_judul') ?>">
                                <div class="invalid-feedback">
                                    <?php if (isset(session('errors')['karier_judul'])) : ?>
                                        <?= session('errors')['karier_judul'] ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="karier_tanggal">Tanggal</label>
                                <input type="text" class="form-control <?= (isset(session('errors')['karier_tanggal'])) ? 'is-invalid' : '' ?>" id="karier_tanggal" name="karier_tanggal" value="<?= old('karier_tanggal') ?>">
                                <div class="invalid-feedback">
                                    <?php if (isset(session('errors')['karier_tanggal'])) : ?>
                                        <?= session('errors')['karier_tanggal'] ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="karier_isi">Deskripsi Kelas Persiapan Karier</label>
                                <textarea type="text" class="form-control <?= (isset(session('errors')['karier_isi'])) ? 'is-invalid' : '' ?>" id="karier_isi" name="karier_isi"><?= old('karier_isi') ?></textarea>
                                <div class="invalid-feedback">
                                    <?php if (isset(session('errors')['karier_isi'])) : ?>
                                        <?= session('errors')['karier_isi'] ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="karier_flyer">Flyer</label>
                                <input type="file" class="form-control <?= (isset(session('errors')['karier_flyer'])) ? 'is-invalid' : '' ?>" id="karier_flyer" name="karier_flyer">
                                <div class="invalid-feedback">
                                    <?php if (isset(session('errors')['karier_flyer'])) : ?>
                                        <?= session('errors')['karier_flyer'] ?>
                                    <?php endif; ?>
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
        <h5 class="card-title">Data Kelas Persiapan Karier</h5>
        <hr />
        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered" >
                <thead>
                    <tr>
                        <th>Nama Kelas</th>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($karier as $row) : ?>
                        <tr>
                            <td><?= $row->karier_judul ?></td>
                            <td><?= $row->karier_tanggal ?></td>
                            <td><?= substr(strip_tags(preg_replace("/<img[^>]+\>/i", "", $row->karier_isi)), 0, 50) ?> ...</td>
                            <td>
                                <a href="<?= base_url('admin/karier/' . $row->karier_id) ?>" class="badge bg-info">Edit</a>
                                <a href="javascript;" data-bs-toggle="modal" data-bs-target="#hapus" data-id="<?= $row->karier_id ?>" class="badge bg-danger">Hapus</a>
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
            <form action="<?= base_url('admin/karier/delete') ?>" method="post">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <input type="hidden" name="karier_id" id="kodeitem" class="d-flex d-none">
                    <h5>Anda yakin ingin menghapus data kelas persiapan karier?</h5>
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