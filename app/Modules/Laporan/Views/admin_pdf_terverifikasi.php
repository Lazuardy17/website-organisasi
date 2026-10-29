<?php
/**
 * Laporan semua OPD yang sudah TERVERIFIKASI.
 * Kolom:  No. | Nama OPD | Hasil Akhir | Opini
 *
 * Variabel dari controller:
 *   $periode  => baris periode_penilaian
 *   $daftar   => penilaian berstatus TERVERIFIKASI (nama_opd, total_skor, kesimpulan)
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan OPD Terverifikasi</title>
<style>
    /* Margin halaman asli (berlaku di SETIAP halaman, termasuk halaman lanjutan).
       Jangan menambahkan "html, body { margin: 0 }" — itu menimpa margin @page di Dompdf. */
    @page { size: letter portrait; margin: 54pt 50pt; }

    body { font-family: 'XCalibri', sans-serif; color: #000; font-size: 11pt; }

    .ttl {
        text-align: center;
        font-weight: bold;
        line-height: 15pt;
        margin-bottom: 18pt;
    }
    .ttl h1 { font-size: 12pt; margin: 0; }

    .tbl {
        width: 100%;
        border-collapse: collapse;
    }
    .tbl th, .tbl td {
        border: 0.75pt solid #000;
        padding: 5pt 8pt;
        vertical-align: middle;
        line-height: normal;
    }
    .tbl th {
        background: #FFFF00;
        text-align: center;
        font-weight: bold;
    }
    .tbl td.ctr { text-align: center; }
    .tbl tr { page-break-inside: avoid; }
</style>
</head>
<body>

<div class="ttl">
    <h1>LAPORAN HASIL PENILAIAN KEMATANGAN PERANGKAT DAERAH</h1>
    <h1>KOTA BANJARBARU</h1>
</div>

<table class="tbl">
    <thead>
        <tr>
            <th style="width: 8%;">No.</th>
            <th style="width: 50%;">Nama OPD</th>
            <th style="width: 18%;">Hasil Akhir</th>
            <th style="width: 24%;">Opini</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($daftar as $i => $d): ?>
            <tr>
                <td class="ctr"><?= $i + 1 ?>.</td>
                <td><?= esc($d['nama_opd'] ?? '-') ?></td>
                <td class="ctr"><?= number_format((float) ($d['total_skor'] ?? 0), 0) ?></td>
                <td class="ctr"><?= esc(($d['kesimpulan'] ?? '') ?: '-') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>