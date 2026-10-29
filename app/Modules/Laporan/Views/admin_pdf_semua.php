<?php
/**
 * Laporan semua OPD — struktur kolom sama dengan halaman Rekapitulasi Data
 * (tanpa kolom Aksi):  No | Nama OPD | Tanggal Submit | Perubahan Terakhir | Skor | Predikat | Status
 *
 * Variabel dari controller:
 *   $periode  => baris periode_penilaian
 *   $daftar   => semua OPD aktif (LEFT JOIN penilaian periode ini; OPD tanpa penilaian: kolom penilaian NULL)
 */
$orientasi = $orientasi ?? 'landscape';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Semua OPD</title>
<style>
    /* Margin halaman asli (berlaku di SETIAP halaman, termasuk halaman lanjutan).
       Jangan menambahkan "html, body { margin: 0 }" — itu menimpa margin @page di Dompdf. */
    @page { size: letter <?= $orientasi ?>; margin: 40pt; }

    body { font-family: 'XCalibri', sans-serif; color: #000; font-size: 10pt; }

    .ttl {
        text-align: center;
        font-weight: bold;
        line-height: 14pt;
        margin-bottom: 16pt;
    }
    .ttl h1 { font-size: 11pt; margin: 0; }

    .tbl {
        width: 100%;
        border-collapse: collapse;
        font-size: 10pt;
    }
    .tbl th, .tbl td {
        border: 0.75pt solid #000;
        padding: 5pt 8pt;
        vertical-align: middle;
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
            <th style="width: 5%;">No</th>
            <th style="width: 31%;">Nama OPD</th>
            <th style="width: 14%;">Tanggal Submit</th>
            <th style="width: 14%;">Perubahan Terakhir</th>
            <th style="width: 6%;">Skor</th>
            <th style="width: 12%;">Predikat</th>
            <th style="width: 15%;">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($daftar as $i => $d): ?>
            <?php $adaPenilaian = !empty($d['status']); ?>
            <tr>
                <td class="ctr"><?= $i + 1 ?></td>
                <td><?= esc($d['nama_opd'] ?? '-') ?></td>
                <td class="ctr"><?= tanggal_indonesia($d['diajukan_pada'] ?? null) ?></td>
                <td class="ctr"><?= $adaPenilaian ? tanggal_indonesia(($d['diperbarui_pada'] ?? null) ?: ($d['dibuat_pada'] ?? null)) : '-' ?></td>
                <td class="ctr"><?= ($d['total_skor'] ?? 0) > 0 ? number_format($d['total_skor'], 0) : '-' ?></td>
                <td class="ctr"><?= esc(($d['kesimpulan'] ?? '') ?: '-') ?></td>
                <td class="ctr"><?= $adaPenilaian ? esc(str_replace('_', ' ', $d['status'])) : 'BELUM MENGISI' ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>