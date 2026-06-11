<?= $this->extend('user/main.php'); ?>
<?= $this->section('content'); ?>

<!--================Banner Area =================-->
<section class="banner_area">
    <div class="booking_table d_flex align-items-center">
        <div class="overlay bg-parallax" data-stellar-ratio="0.9" data-stellar-vertical-offset="0" data-background=""></div>
        <div class="container">
            <div class="banner_content text-center">
                <h6>Welcome...</h6>
                <h2>U N W I R A</h2>
                <p>Selamat datang di sistem Kerja sama dan Layanan karier <br> Universitas Katolik Widya Mandira Kupang</p>
                <a href="<?= base_url('/cerita') ?>" class="btn theme_btn button_hover">Lihat cerita alumni</a>
            </div>
        </div>
    </div>
</section>
<!--================Banner Area =================-->

<!--================ LATEST ARTIKEL AREA =================-->
<section class="latest_blog_area section_gap">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title_color">Artikel Terbaru</h2>
            <p>Ikuti informasi terbaru dari artikel KSPK UNWIRA.</p>
        </div>
        <div class="row mb_30">
            <?php if (! empty($artikel_latest)) : ?>
                <?php foreach ($artikel_latest as $row) : ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="single-recent-blog-post">
                            <div class="thumb">
                                <img class="img-fluid" src="<?= base_url('/') ?><?= esc($row->thumbnail ?: 'assets/images/default.jpg') ?>" alt="<?= esc($row->judul) ?>" style="height:250px; object-fit:cover">
                            </div>
                            <div class="details">
                                <a href="<?= base_url('/detailartikel/' . esc($row->id)) ?>">
                                    <h4 class="sec_h4"><?= esc($row->judul) ?></h4>
                                </a>
                                <p><?= esc(substr(strip_tags(preg_replace('/<img[^>]+>/i', '', sanitize_html_content($row->isi))), 0, 110)) ?>...</p>
                                <h6 class="date title_color"><?= esc(date('d-M-Y', strtotime($row->published_at ?? $row->created_at))) ?></h6>
                                <a class="button_hover" href="<?= base_url('/detailartikel/' . esc($row->id)) ?>">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else : ?>
                <div class="col-12">
                    <p class="text-center">Belum ada artikel terbaru untuk ditampilkan.</p>
                </div>
            <?php endif ?>
        </div>
        <div class="d-flex justify-content-center mt-4">
            <a class="btn theme_btn button_hover" href="<?= base_url('/artikel') ?>">Semua Artikel</a>
        </div>
    </div>
</section>
<!--================ END LATEST ARTIKEL AREA =================-->

<!--================ DATA ALUMNI  =================-->
<section class="about_history_area section_gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 align-items-center">
                <div class="card w-100 radius-10">
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($tahunalumni as $row) : ?>
                                <div class="col-lg-6 mt-2">
                                    <div class="card radius-10 border shadow-none">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <p class="mb-0 font-13">Jumlah alumni tahun <?= $row->alumni_tahunlulus ?></p>
                                                    <center>
                                                        <h3 class="my-1" id="counter-<?= $row->alumni_tahunlulus ?>" data-count="<?= number_format($row->jumlah) ?>"></h3>
                                                    </center>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
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
        </div>
    </div>
</section>
<!--================ END DATA ALUMNI  =================-->



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

<script>
    $(document).ready(function() {
        $('[id^="counter-"]').each(function() {
            var totalLulusan = parseInt($(this).attr('data-count').replace(/,/g, ''), 10);

            $(this).prop('Counter', 0).animate({
                Counter: totalLulusan
            }, {
                duration: 5000,
                easing: 'swing',
                step: function(now) {
                    $(this).text(Math.ceil(now).toLocaleString());
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>