<?= $this->extend('layout_admin'); ?>
<?= $this->section('content'); ?>
<div class="page-content">
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
            <div class="card radius-10 border-start border-0 border-4 border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Alumni Terdaftar</p>
                            <h4 class="my-1 text-info"><?= $alumni ?></h4>
                            <p class="mb-0 font-13">Data sejak tahun 2019</p>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i class="bx bxs-user"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col">
            <div class="card radius-10 border-start border-0 border-4 border-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Revenue</p>
                            <h4 class="my-1 text-danger">$84,245</h4>
                            <p class="mb-0 font-13">+5.4% from last week</p>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto"><i class="bx bxs-wallet"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-0 border-4 border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Bounce Rate</p>
                            <h4 class="my-1 text-success">34.6%</h4>
                            <p class="mb-0 font-13">-4.5% from last week</p>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class="bx bxs-bar-chart-alt-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-0 border-4 border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Customers</p>
                            <h4 class="my-1 text-warning">8.4K</h4>
                            <p class="mb-0 font-13">+8.4% from last week</p>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i class="bx bxs-group"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
    <div class="row">
        <div class="col-12 col-lg-7 col-xl-8">
            <div class="card w-100 radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Agenda Terakhir</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Agenda</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($agenda as $row): ?>
                                    <tr>
                                        <td><?= $row->agenda_judul ?></td>
                                        <td><?= $row->agenda_tanggal ?></td>
                                        <td><?= $row->agenda_waktu ?></td>
                                        <td><?= $row->agenda_deskripsi ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <a href="<?= base_url('admin/agenda') ?>" class="txt-primary">Lihat Lainnya >></a>
                    </div>
                </div>
            </div>
            <div class="card w-100 radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Persiapan Karier</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tajuk</th>
                                    <th>Flyer</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($karier as $row): ?>
                                    <tr>
                                        <td><?= $row->karier_judul ?></td>
                                        <td><img src="<?= base_url('assets/img/karier/' . $row->karier_flyer) ?>" class="product-img-2" alt="product img"></td>
                                        <td><?= $row->karier_tanggal ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <a href="<?= base_url('admin/karier') ?>" class="txt-primary">Lihat Lainnya >></a>
                    </div>
                </div>
            </div>
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Alumni 5 Tahun Terakhir</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container-1 mt-3">
                        <canvas id="chart4" width="345" height="325" style="display: block; box-sizing: border-box; height: 260px; width: 276px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-5 col-xl-4 d-flex">

            <div class="card w-100 radius-10">
                <div class="card-body">
                    <?php foreach ($tahunalumni as $row) : ?>
                        <div class="card radius-10 border shadow-none">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary"><?= $row->alumni_tahunlulus ?></p>
                                        <h4 class="my-1"><?= number_format($row->jumlah) ?></h4>
                                        <p class="mb-0 font-13">Data jumlah alumni tahun <?= $row->alumni_tahunlulus ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>

            </div>

        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
<script>
    var ctx = document.getElementById('chart4').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [<?php foreach ($chart_alumni as $row) : ?>
                    <?= $row->alumni_tahunlulus . ', ' ?>
                <?php endforeach ?>
            ],
            datasets: [{
                data: [
                    <?php foreach ($chart_alumni as $row) : ?>
                        <?= $row->jumlah . ', ' ?>
                    <?php endforeach ?>
                ],
                backgroundColor: [
                    '#0d6efd',
                    '#6f42c1',
                    '#d63384',
                    '#fd7e14',
                    '#15ca20',
                ],
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    display: true,
                }
            },

        }
    });
</script>
<?= $this->endSection(); ?>