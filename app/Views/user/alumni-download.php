<!DOCTYPE html>
<html>

<head>
    <title>PDF Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h1 {
            text-align: center;
        }

        .content {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Alumni Unwira</h1>
    <div class="content">
        <table>
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
</body>

</html>