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
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/page') ?>">Page</a>
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
            <h5 class="card-title">Form Page</h5>
            <hr />
            <form action="<?= base_url('admin/page/update') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="page_id" value="<?= $page->page_id ?>">
                <div class="form-group mb-4">
                    <label for="">Page Tag : <b><?= $page->page_tag ?></b></label>
                </div>
                <div class="form-group mb-4">
                    <label for="page_content"><span class="txt-danger">*</span>Isi</label>
                    <textarea rows="30" class="form-control <?= (isset(session('errors')['page_content'])) ? 'is-invalid' : '' ?>" id="editor2" name="page_content"><?= old('page_content', $page->page_content) ?></textarea>
                    <div class="invalid-feedback">
                        <?php if (isset(session('errors')['page_content'])) : ?>
                            <?= session('errors')['page_content'] ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <button type="submit" class="btn btn-primary">Simpan Page</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
<script>
    CKEDITOR.replace('editor2', {
        extraPlugins: ['justify', 'btgrid']
    });
</script>
<?= $this->endSection(); ?>