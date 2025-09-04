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
            <a type="button" class="btn btn-primary" href="javascript:;" data-bs-toggle="modal" data-bs-target="#tambah">Tambah</a>
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
            <h5 class="card-title">Data Agenda Unwira</h5>
            <hr />
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Deskripsi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($agenda as $row) : ?>
                            <tr>
                                <td><?= $row->agenda_judul ?></td>
                                <td><?= $row->agenda_tanggal ?></td>
                                <td><?= $row->agenda_waktu ?></td>
                                <td><?= $row->agenda_deskripsi ?></td>
                                <td>
                                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#edit" data-id="<?= $row->agenda_id ?>" data-judul="<?= $row->agenda_judul ?>" data-tanggal="<?= $row->agenda_tanggal ?>" data-waktu="<?= $row->agenda_waktu ?>" data-deskripsi="<?= $row->agenda_deskripsi ?>" class="badge bg-info">Edit</a>
                                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#hapus" data-id="<?= $row->agenda_id ?>" class="badge bg-danger">Hapus</a>
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
            <form action="<?= base_url('admin/upcoming/delete') ?>" method="post">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <input type="hidden" name="agenda_id" id="kodeitem" class="d-flex d-none">
                    <h5>Anda yakin ingin menghapus data agenda??</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade in" id="tambah" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Agenda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/upcoming/insert') ?>" method="post">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <input type="hidden" name="agenda_id" id="kodeitem" class="d-flex d-none">
                    <div class="form-group mb-4">
                        <label for="agenda_judul">Kegiatan</label>
                        <input type="text" class="form-control <?= (isset(session('errors')['agenda_judul'])) ? 'is-invalid' : '' ?>" id="agenda_judul" name="agenda_judul" value="<?= old('agenda_judul') ?>">
                        <div class="invalid-feedback">
                            <?php if (isset(session('errors')['agenda_judul'])) : ?>
                                <?= session('errors')['agenda_judul'] ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="agenda_tanggal">Tanggal</label>
                        <input type="text" class="form-control <?= (isset(session('errors')['agenda_tanggal'])) ? 'is-invalid' : '' ?>" id="agenda_tanggal" name="agenda_tanggal" value="<?= old('agenda_tanggal') ?>">
                        <div class="invalid-feedback">
                            <?php if (isset(session('errors')['agenda_tanggal'])) : ?>
                                <?= session('errors')['agenda_tanggal'] ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="agenda_waktu">Waktu</label>
                        <input type="text" class="form-control <?= (isset(session('errors')['agenda_waktu'])) ? 'is-invalid' : '' ?>" id="agenda_waktu" name="agenda_waktu" value="<?= old('agenda_waktu') ?>">
                        <div class="invalid-feedback">
                            <?php if (isset(session('errors')['agenda_waktu'])) : ?>
                                <?= session('errors')['agenda_waktu'] ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="agenda_deskripsi">Deskripsi singkat kegiatan</label>
                        <textarea type="text" class="form-control <?= (isset(session('errors')['agenda_deskripsi'])) ? 'is-invalid' : '' ?>" id="agenda_deskripsi" name="agenda_deskripsi"><?= old('agenda_deskripsi') ?></textarea>
                        <div class="invalid-feedback">
                            <?php if (isset(session('errors')['agenda_deskripsi'])) : ?>
                                <?= session('errors')['agenda_deskripsi'] ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade in" id="edit" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Agenda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/upcoming/update') ?>" method="post">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <input type="hidden" name="agenda_id" id="kodeitemupdate" class="d-flex d-none">
                    <div class="form-group mb-4">
                        <label for="agenda_judul">Kegiatan</label>
                        <input type="text" class="form-control <?= (isset(session('errors')['agenda_judul'])) ? 'is-invalid' : '' ?>" id="judul" name="agenda_judul" value="">
                        <div class="invalid-feedback">
                            <?php if (isset(session('errors')['agenda_judul'])) : ?>
                                <?= session('errors')['agenda_judul'] ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="agenda_tanggal">Tanggal</label>
                        <input type="text" class="form-control <?= (isset(session('errors')['agenda_tanggal'])) ? 'is-invalid' : '' ?>" id="tanggal" name="agenda_tanggal" value="">
                        <div class="invalid-feedback">
                            <?php if (isset(session('errors')['agenda_tanggal'])) : ?>
                                <?= session('errors')['agenda_tanggal'] ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="agenda_waktu">Waktu</label>
                        <input type="text" class="form-control <?= (isset(session('errors')['agenda_waktu'])) ? 'is-invalid' : '' ?>" id="waktu" name="agenda_waktu" value="">
                        <div class="invalid-feedback">
                            <?php if (isset(session('errors')['agenda_waktu'])) : ?>
                                <?= session('errors')['agenda_waktu'] ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="agenda_deskripsi">Deskripsi singkat kegiatan</label>
                        <textarea type="text" class="form-control <?= (isset(session('errors')['agenda_deskripsi'])) ? 'is-invalid' : '' ?>" id="deskripsi" name="agenda_deskripsi"></textarea>
                        <div class="invalid-feedback">
                            <?php if (isset(session('errors')['agenda_deskripsi'])) : ?>
                                <?= session('errors')['agenda_deskripsi'] ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
    $('#edit').on('show.bs.modal', function(event) {
        var kode = $(event.relatedTarget).data('id');
        var judul = $(event.relatedTarget).data('judul');
        var tanggal = $(event.relatedTarget).data('tanggal');
        var waktu = $(event.relatedTarget).data('waktu');
        var deskripsi = $(event.relatedTarget).data('deskripsi');
        console.log(deskripsi);
        $(this).find('#kodeitemupdate').attr("value", kode);
        $(this).find('#judul').attr("value", judul);
        $(this).find('#tanggal').attr("value", tanggal);
        $(this).find('#waktu').attr("value", waktu);
        $(this).find('#deskripsi').val(deskripsi);
        // $(this).find('#namaitem').attr("value", nama);
    });
</script>
<?= $this->endSection(); ?>