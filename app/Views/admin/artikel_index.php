<?= $this->extend('layout_admin'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3"><?= $title ?></div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a class="btn btn-primary" href="<?= base_url('admin/artikel/tambah') ?>">Tambah</a>
        </div>
    </div>

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
            <h5 class="card-title">Data Artikel</h5>
            <hr />
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="table-layout:fixed; width:100%">
                    <thead>
                        <tr>
                            <th style="width:5%">No</th>
                            <th style="width:45%">Judul</th>
                            <th style="width:15%">Status</th>
                            <th style="width:20%">Published</th>
                            <th style="width:15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($artikel as $row) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td style="max-width:400px; word-wrap:break-word; white-space:normal;"><?= esc($row->judul) ?></td>
                                <td><?= esc($row->status) ?></td>
                                <td><?= esc($row->published_at ?? '-') ?></td>
                                <td>
                                    <a href="<?= base_url('admin/artikel/' . esc($row->id)) ?>" class="badge bg-info text-light">Detail</a>
                                    <a href="<?= base_url('admin/artikel/edit/' . esc($row->id)) ?>" class="badge bg-primary text-light">Edit</a>
                                    <a href="javascript:;" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#hapus" data-id="<?= esc($row->id) ?>">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="hapus" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/artikel/delete') ?>" method="post">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" id="kodeitem" class="d-none">
                    <h5>Anda yakin ingin menghapus artikel ini?</h5>
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
        var kode = $(event.relatedTarget).data('id');
        $(this).find('#kodeitem').attr('value', kode);
    });
</script>
<?= $this->endSection(); ?>