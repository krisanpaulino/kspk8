<?php
$bgDepan = realpath(FCPATH . 'assets-user/image/template-card-depan.png');
$bgBelakang = realpath(FCPATH . 'assets-user/image/template-card-belakang.png');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .kartu {
            width: 500px;
            height: 300px;
            /* position: relative; */
        }

        .bg-depan {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background-image: url("data:image/jpeg;base64, <?= $depan ?>");
            background-size: cover;
            background-repeat: no-repeat;
            /* Prevents image from repeating if it doesn't perfectly fill */
            background-position: center center;
            /* Centers the image within the container */
        }

        .bg-belakang {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background-image: url("data:image/jpeg;base64, <?= $belakang ?>");
            background-size: cover;
            background-repeat: no-repeat;
            /* Prevents image from repeating if it doesn't perfectly fill */
            background-position: center center;
            /* Centers the image within the container */
        }

        .nama {
            position: absolute;
            top: 120px;
            left: 40px;
            font-size: 20px;
            font-weight: bold;
            color: #000;
        }

        .info {
            position: absolute;
            top: 170px;
            left: 40px;
            font-size: 16px;
            line-height: 16px;
            color: #000;
        }

        .qr {
            position: absolute;
            bottom: 30px;
            right: 20px;
            width: 80px;
            height: 80px;
        }

        .ketentuan {
            position: absolute;
            top: 50px;
            left: 20px;
            font-size: 12px;
            width: 460px;
            color: #000;
        }

        .signatures {
            position: absolute;
            bottom: 20px;
            width: 100%;
            display: flex;
            justify-content: space-around;
            font-size: 10px;
            text-align: center;
        }

        .signatures img {
            width: 70px;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <!-- Halaman Depan -->
    <div class="kartu bg-depan">

        <div class="nama"><?= $alumni->alumni_nama; ?></div>
        <div class="info">
            <?= $alumni->alumni_nim; ?><br><br>
            <?= $prodi; ?><br><br><br>
            Diwisudakan: <?= $alumni->alumni_tahunlulus; ?>
        </div>
    </div>

    <!-- Halaman Belakang -->
    <div class="kartu bg-belakang" style="page-break-before: always;">
    </div>

</body>

</html>