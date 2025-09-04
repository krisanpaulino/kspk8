<?= $this->extend('user/main.php'); ?>
<?= $this->section('content'); ?>
<section class="latest_blog_area section_gap">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title_color">Alumni Unwira</h2>
        </div>
        <div class="mb-4">
            <!-- <a href="<?= base_url('/alumnidownload') ?>" target="_blank" class="btn btn-md btn-info"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download</a> -->
        </div>
        <div class="row mb_30">
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered mb-0 table-sm" id="bootstrap-data-table">
                    <thead>
                        <tr class="text-dark">
                            <th>No.</th>
                            <th>Nama alumni</th>
                            <th>Tahun lulus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($alumni as $row) :
                        ?>
                            <tr>
                                <td><?= $no++ ?>.</td>
                                <td><?= $row->alumni_nama ?></td>
                                <td><?= $row->alumni_tahunlulus ?></td>
                            </tr>
                        <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
<!-- DATATABLE -->
<script src="<?= base_url('/') ?>assets-user/datatables/js/lib/data-table/datatables.min.js"></script>
<script src="<?= base_url('/') ?>assets-user/datatables/js/lib/data-table/dataTables.bootstrap.min.js"></script>
<script src="<?= base_url('/') ?>assets-user/datatables/js/lib/data-table/dataTables.buttons.min.js"></script>
<script src="<?= base_url('/') ?>assets-user/datatables/js/lib/data-table/buttons.bootstrap.min.js"></script>
<script src="<?= base_url('/') ?>assets-user/datatables/js/lib/data-table/jszip.min.js"></script>
<script src="<?= base_url('/') ?>assets-user/datatables/js/lib/data-table/vfs_fonts.js"></script>
<script src="<?= base_url('/') ?>assets-user/datatables/js/lib/data-table/buttons.html5.min.js"></script>
<script src="<?= base_url('/') ?>assets-user/datatables/js/lib/data-table/buttons.print.min.js"></script>
<script src="<?= base_url('/') ?>assets-user/datatables/js/lib/data-table/buttons.colVis.min.js"></script>
<script src="<?= base_url('/') ?>assets-user/datatables/js/init/datatables-init.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#bootstrap-data-table-export').DataTable();
    });
</script>
<!-- DATATABLE -->
<?= $this->endSection(); ?>