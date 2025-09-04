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
<!--================ DATA ALUMNI  =================-->



<!--================ Accomodation Area  =================-->
<!-- <section class="accomodation_area section_gap">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title_color">Hotel Accomodation</h2>
            <p>We all live in an age that belongs to the young at heart. Life that is becoming extremely fast, </p>
        </div>
        <div class="row mb_30">
            <div class="col-lg-3 col-sm-6">
                <div class="accomodation_item text-center">
                    <div class="hotel_img">
                        <img src="<?= base_url('/') ?>assets-user/image/room1.jpg" alt="">
                        <a href="#" class="btn theme_btn button_hover">Book Now</a>
                    </div>
                    <a href="#">
                        <h4 class="sec_h4">Double Deluxe Room</h4>
                    </a>
                    <h5>$250<small>/night</small></h5>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="accomodation_item text-center">
                    <div class="hotel_img">
                        <img src="<?= base_url('/') ?>assets-user/image/room2.jpg" alt="">
                        <a href="#" class="btn theme_btn button_hover">Book Now</a>
                    </div>
                    <a href="#">
                        <h4 class="sec_h4">Single Deluxe Room</h4>
                    </a>
                    <h5>$200<small>/night</small></h5>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="accomodation_item text-center">
                    <div class="hotel_img">
                        <img src="<?= base_url('/') ?>assets-user/image/room3.jpg" alt="">
                        <a href="#" class="btn theme_btn button_hover">Book Now</a>
                    </div>
                    <a href="#">
                        <h4 class="sec_h4">Honeymoon Suit</h4>
                    </a>
                    <h5>$750<small>/night</small></h5>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="accomodation_item text-center">
                    <div class="hotel_img">
                        <img src="<?= base_url('/') ?>assets-user/image/room4.jpg" alt="">
                        <a href="#" class="btn theme_btn button_hover">Book Now</a>
                    </div>
                    <a href="#">
                        <h4 class="sec_h4">Economy Double</h4>
                    </a>
                    <h5>$200<small>/night</small></h5>
                </div>
            </div>
        </div>
    </div>
</section> -->
<!--================ Accomodation Area  =================-->



<!--================ BERITA  =================-->

<!--================ BERITA  =================-->


<!--================ About History Area  =================-->
<!-- <section class="about_history_area section_gap">
    <div class="container">
        <div class="row">
            <div class="col-md-6 d_flex align-items-center">
                <div class="about_content ">
                    <h2 class="title title_color">About Us <br>Our History<br>Mission & Vision</h2>
                    <p>inappropriate behavior is often laughed off as “boys will be boys,” women face higher conduct standards especially in the workplace. That’s why it’s crucial that, as women, our behavior on the job is beyond reproach. inappropriate behavior is often laughed.</p>
                    <a href="#" class="button_hover theme_btn_two">Request Custom Price</a>
                </div>
            </div>
            <div class="col-md-6">
                <img class="img-fluid" src="<?= base_url('/') ?>assets-user/image/about_bg.jpg" alt="img">
            </div>
        </div>
    </div>
</section> -->
<!--================ About History Area  =================-->

<!--================ Testimonial Area  =================-->
<!-- <section class="testimonial_area section_gap">
    <div class="container">
        <div class="section_title text-center">
            <h2 class="title_color">Testimonial from our Clients</h2>
            <p>The French Revolution constituted for the conscience of the dominant aristocratic class a fall from </p>
        </div>
        <div class="testimonial_slider owl-carousel">
            <div class="media testimonial_item">
                <img class="rounded-circle" src="<?= base_url('/') ?>assets-user/image/testtimonial-1.jpg" alt="">
                <div class="media-body">
                    <p>As conscious traveling Paupers we must always be concerned about our dear Mother Earth. If you think about it, you travel across her face, and She is the </p>
                    <a href="#">
                        <h4 class="sec_h4">Fanny Spencer</h4>
                    </a>
                    <div class="star">
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star-half-o"></i></a>
                    </div>
                </div>
            </div>
            <div class="media testimonial_item">
                <img class="rounded-circle" src="<?= base_url('/') ?>assets-user/image/testtimonial-1.jpg" alt="">
                <div class="media-body">
                    <p>As conscious traveling Paupers we must always be concerned about our dear Mother Earth. If you think about it, you travel across her face, and She is the </p>
                    <a href="#">
                        <h4 class="sec_h4">Fanny Spencer</h4>
                    </a>
                    <div class="star">
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star-half-o"></i></a>
                    </div>
                </div>
            </div>
            <div class="media testimonial_item">
                <img class="rounded-circle" src="<?= base_url('/') ?>assets-user/image/testtimonial-1.jpg" alt="">
                <div class="media-body">
                    <p>As conscious traveling Paupers we must always be concerned about our dear Mother Earth. If you think about it, you travel across her face, and She is the </p>
                    <a href="#">
                        <h4 class="sec_h4">Fanny Spencer</h4>
                    </a>
                    <div class="star">
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star-half-o"></i></a>
                    </div>
                </div>
            </div>
            <div class="media testimonial_item">
                <img class="rounded-circle" src="<?= base_url('/') ?>assets-user/image/testtimonial-1.jpg" alt="">
                <div class="media-body">
                    <p>As conscious traveling Paupers we must always be concerned about our dear Mother Earth. If you think about it, you travel across her face, and She is the </p>
                    <a href="#">
                        <h4 class="sec_h4">Fanny Spencer</h4>
                    </a>
                    <div class="star">
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star"></i></a>
                        <a href="#"><i class="fa fa-star-half-o"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->
<!--================ Testimonial Area  =================-->


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