<?php
// --- MENYIAPKAN LOGO ---
$pathToLogo = FCPATH . 'assets/img/logo.png'; 
$logoData = file_get_contents($pathToLogo);
$logoBase64 = 'data:image/' . pathinfo($pathToLogo, PATHINFO_EXTENSION) . ';base64,' . base64_encode($logoData);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <style>
        body { 
            font-family: 'Helvetica', sans-serif; 
            font-size: 12px;
        }

        /* ===== PERUBAHAN HEADER DIMULAI DI SINI ===== */
        .header-outer-table {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header-inner-table {
            /* Trik untuk menengahkan tabel di dalam sel tabel induk */
            margin: 0 auto; 
        }
        .logo {
            width: 80px;
            height: auto;
        }
        .header-text {
            /* Teks di dalam blok ini tetap rata kiri */
            text-align: left;
        }
        .header-text h1 {
            margin: 0 0 5px 0; 
            font-size: 18px;
            font-weight: bold;
        }
        .header-text p {
            margin: 0;
            font-size: 12px;
            line-height: 1.4; 
        }
        /* ===== AKHIR PERUBAHAN HEADER ===== */

        .content-title { 
            text-align: center; 
            margin-top: 20px;
            margin-bottom: 20px;
            font-size: 16px;
            font-weight: bold;
        }
        .data-table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        .data-table th, .data-table td { 
            border: 1px solid #dddddd; padd
            ing: 8px; 
            text-align: left; 
        }
        .data-table th { 
            background-color: #f2f2f2; 
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- ===== PERUBAHAN STRUKTUR HTML HEADER ===== -->
    <table class="header-outer-table">
        <tr>
            <td>
                <!-- Tabel ini untuk mengelompokkan logo dan teks agar bisa ditengahkan bersama -->
                <table class="header-inner-table">
                    <tr>
                        <!-- Kolom untuk Logo -->
                        <td style="padding-right: 40px; vertical-align: middle;">
                            <img src="<?= $logoBase64 ?>" class="logo">
                        </td>
                        <!-- Kolom untuk Teks Header -->
                        <td style="vertical-align: middle;">
                            <div class="header-text">
                                <h1>PONDOK PESANTREN TERPADU AL-MULTAZAM</h1>
                                <p>Desa Maniskidul , Kec. Jalaksana, Kab. Kuningan - Jawa Barat | Pos : 45554</p>
                                <p>Telepon: (0232) 613805 | Web: almultazam.id</p>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <h3 class="content-title"><?= esc($title) ?></h3>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th>Tanggal Scan</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Tanggal Pengembalian</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($scanHistory)) : ?>
                <?php $i = 1; ?>
                <?php foreach ($scanHistory as $scan) : ?>
                    <tr>
                        <td class="text-center"><?= $i++ ?></td>
                        <td><?= esc(date('d-m-Y H:i:s', strtotime($scan['created_at']))) ?></td>
                        <td><?= esc($scan['student']) ?></td>
                        <td><?= esc($scan['class_name']) ?></td>
                        <td><?php
                        if (empty($scan['date'])) {
                            echo "-";
                        }else{
                            echo esc($scan['date']);
                        } ?></td>
                        <td><?php
                        if (empty($scan['note'])) {
                            echo "-";
                        }else{
                            echo esc($scan['note']);
                        } ?></td>
                        <td><?= esc($scan['status']) ?></td>
                        <td><?= esc($scan['employee']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data untuk ditampilkan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
