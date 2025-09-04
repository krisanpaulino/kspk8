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
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/cerita-alumni') ?>"><i class="bx bx-home-alt"></i></a>
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
            <h5 class="card-title">Cerita Alumni</h5>
            <hr />

            <?php if ($cerita->cerita_status == 'pending') : ?>
                <div class="d-flex justify-content-between mb-4">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#approve" data-id="<?= $cerita->cerita_id ?>" class="btn btn-primary">Approve</button>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#reject" data-id="<?= $cerita->cerita_id ?>" class="btn btn-danger">Reject</button>
                </div>
            <?php endif ?>
            <span class="text-small text-muted"> By <?= $cerita->cerita_nama ?></span> <br>
            <span class="text-small text-muted"> On <?= $cerita->cerita_tanggal ?></span>

            <div class="text-center">
                <h1 class="display-4"><?= $cerita->cerita_judul ?></h1>
            </div>

            <div class="mb-4">
                <?= $cerita->cerita_isi ?>
            </div>
            <?php if ($cerita->cerita_status == 'pending') : ?>
                <div class="d-flex justify-content-between mb-4">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#approve" data-id="<?= $cerita->cerita_id ?>" class="btn btn-primary">Approve</button>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#reject" data-id="<?= $cerita->cerita_id ?>" class="btn btn-danger">Reject</button>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
<div class="modal fade in" id="approve" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Approve</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/cerita-alumni/approve') ?>" method="post">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <input type="hidden" name="cerita_id" id="kodeitemapprove" class="d-flex d-none">
                    <h5>Anda yakin ingin approve cerita alumni?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade in" id="reject" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi reject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/cerita-alumni/reject') ?>" method="post">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <input type="hidden" name="cerita_id" id="kodeitemreject" class="d-flex d-none">
                    <h5>Anda yakin ingin reject cerita alumni?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
<script>
    $('#approve').on('show.bs.modal', function(event) {
        console.log('Here');
        var kode = $(event.relatedTarget).data('id');
        $(this).find('#kodeitemapprove').attr("value", kode);
        // $(this).find('#namaitem').attr("value", nama);
    });
    $('#reject').on('show.bs.modal', function(event) {
        console.log('Here');
        var kode = $(event.relatedTarget).data('id');
        $(this).find('#kodeitemreject').attr("value", kode);
        // $(this).find('#namaitem').attr("value", nama);
    });
</script>
<?= $this->endSection(); ?>