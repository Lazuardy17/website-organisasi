<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penilaian</title>
    <style>
        @page {
            margin: 20mm 15mm;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #000;
            line-height: 1.4;
        }

        /* ===== Header ===== */
        .header {
            text-align: center;
            margin-bottom: 16px;
        }
        .header h1 {
            font-size: 12px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }
        .header h2 {
            font-size: 11px;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
        }

        /* ===== Tabel ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: top;
        }
        table th {
            background: #FFFF00;
            font-weight: bold;
            text-align: center;
        }
        table.data-rekap td.center {
            text-align: center;
        }
        table.data-rekap td.right {
            text-align: right;
        }

        /* ===== Sheet 4 — Rekap ===== */
        .rekap-summary {
            width: 50%;
            margin-left: auto;
            margin-top: 4px;
            border-collapse: collapse;
            font-size: 9px;
        }
        .rekap-summary td {
            border: 1px solid #000;
            padding: 4px 8px;
        }
        .rekap-summary td.label {
            background: #FFF;
            font-weight: normal;
        }
        .rekap-summary td.value {
            text-align: center;
            font-weight: bold;
        }

        /* ===== Tanda Tangan ===== */
        .ttd {
            margin-top: 30px;
            text-align: center;
            page-break-inside: avoid;
        }
        .ttd .mengetahui {
            margin-bottom: 60px;
        }
        .ttd .nama {
            font-weight: bold;
            text-decoration: underline;
        }
        .ttd .jabatan {
            margin: 4px 0;
        }

        /* ===== Page Break ===== */
        .page-break {
            page-break-after: always;
        }

        /* ===== Variabel Title ===== */
        .variabel-title {
            font-size: 11px;
            font-weight: bold;
            margin: 16px 0 8px 0;
        }

        /* ===== Footer ===== */
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            color: #555;
            border-top: 1px solid #ccc;
            padding-top: 6px;
        }
    </style>
</head>
<body>

<?php
    $totalSkor = 0;
    foreach ($detail as $d) {
        $totalSkor += (float) $d['nilai_skor'];
    }
    $kesimpulanText = $penilaian['kesimpulan'] ?? '-';
?>

<!-- ============================================================
     SHEET 4 — REKAPITULASI HASIL
============================================================ -->
<?php if ($format === 'sheet4' || $format === 'gabungan'): ?>

    <div class="header">
        <h1>REKAPITULASI HASIL PENILAIAN KEMATANGAN PENATAAN PERANGKAT DAERAH</h1>
        <h2><?= esc($opd['nama']) ?></h2>
        <h2>KOTA BANJARBARU</h2>
    </div>

    <table class="data-rekap">
        <thead>
            <tr>
                <th style="width: 8%;">NO.</th>
                <th style="width: 55%;">VARIABEL</th>
                <th style="width: 12%;">SKOR</th>
                <th style="width: 25%;">BUKTI DUKUNG</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detail as $d): ?>
                <tr>
                    <td class="center"><?= $d['nomor_urutan'] ?></td>
                    <td><?= esc($d['nama_variabel']) ?></td>
                    <td class="center"><?= number_format($d['nilai_skor'], 0) ?></td>
                    <td class="center">Ada</td>
                </tr>
            <?php endforeach; ?>
            <!-- Baris Total -->
            <tr>
                <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL SKOR</td>
                <td class="center" style="font-weight: bold;"><?= number_format($totalSkor, 0) ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <!-- Ringkasan Hasil Akhir + Opini -->
    <table class="rekap-summary" style="width: 45%; margin-left: auto; margin-top: 4px;">
        <tr>
            <td class="label" style="width: 50%; text-align: right; border: none;">Hasil Akhir</td>
            <td class="value" style="border: 1px solid #000;"><?= number_format($totalSkor, 0) ?></td>
        </tr>
        <tr>
            <td class="label" style="text-align: right; border: none;">Opini</td>
            <td class="value" style="border: 1px solid #000;"><?= strtoupper(esc($kesimpulanText)) ?></td>
        </tr>
    </table>

    <!-- Tanda Tangan -->
    <div class="ttd">
        <div class="mengetahui">
            Mengetahui<br>
            <strong><?= esc($opd['nomenklatur_jabatan'] ?? 'Kepala Perangkat Daerah') ?></strong>
        </div>
        <div class="nama"><?= esc($opd['nama_kepala'] ?? '...................') ?></div>
        <div class="jabatan"><?= esc($opd['pangkat_kepala'] ?? '...................') ?></div>
        <div><?= esc($opd['nip_kepala'] ?? '...................') ?></div>
    </div>

    <?php if ($format === 'gabungan'): ?>
        <div class="page-break"></div>
    <?php endif; ?>

<?php endif; ?>


<!-- ============================================================
     SHEET 5 — FORMULIR PER VARIABEL
============================================================ -->
<?php if ($format === 'sheet5' || $format === 'gabungan'): ?>

    <?php foreach ($variabelList as $index => $v): ?>

        <!-- Header lengkap HANYA di halaman pertama Sheet 5 -->
        <?php if ($index === 0): ?>
            <div class="header">
                <h1>FORMULIR PENILAIAN KEMATANGAN PENATAAN PERANGKAT DAERAH KOTA BANJARBARU</h1>
                <h2><?= esc($opd['nama']) ?></h2>
            </div>
        <?php endif; ?>

        <div class="variabel-title">VARIABEL <?= $v['nomor_urutan'] ?></div>

        <table>
            <thead>
                <tr>
                    <th rowspan="2" style="width: 12%;">Tingkat</th>
                    <th rowspan="2" style="width: 45%;">Indikator</th>
                    <th rowspan="2" style="width: 10%;">Penilaian Mandiri PD</th>
                    <th colspan="2" style="width: 13%;">Bukti Dukung</th>
                    <th rowspan="2" style="width: 20%;">Keterangan</th>
                </tr>
                <tr>
                    <th style="width: 7%;">Ada</th>
                    <th style="width: 6%;">Tidak Ada</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($v['tingkat'] as $t): ?>
                    <?php
                        $terpilih = false;
                        $skor     = '';
                        $tautan   = '';
                        if ($v['detail'] && $v['detail']['tingkat_id'] == $t['id']) {
                            $terpilih = true;
                            $skor     = number_format($v['detail']['nilai_skor'], 0);
                            $tautan   = $v['detail']['tautan_bukti'] ?? '';
                        }
                    ?>
                    <tr>
                        <td class="center" style="text-align: center;"><?= esc($t['nama_tingkat']) ?></td>
                        <td><?= esc($t['indikator']) ?></td>
                        <td style="text-align: center; font-weight: bold;"><?= $terpilih ? $skor : '' ?></td>
                        <td style="text-align: center; font-weight: bold;"><?= $terpilih ? 'Y' : '' ?></td>
                        <td></td>
                        <td style="word-break: break-all; font-size: 8px;">
                            <?= $terpilih ? esc($tautan) : '' ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Page break antar variabel, KECUALI variabel terakhir (kalau bukan gabungan) -->
        <?php if ($index < count($variabelList) - 1): ?>
            <div class="page-break"></div>
        <?php endif; ?>

    <?php endforeach; ?>

    <!-- Tanda Tangan di akhir Sheet 5 -->
    <div class="ttd">
        <div class="mengetahui">
            Mengetahui<br>
            <strong><?= esc($opd['nomenklatur_jabatan'] ?? 'Kepala Perangkat Daerah') ?></strong>
        </div>
        <div class="nama"><?= esc($opd['nama_kepala'] ?? '...................') ?></div>
        <div class="jabatan"><?= esc($opd['pangkat_kepala'] ?? '...................') ?></div>
        <div><?= esc($opd['nip_kepala'] ?? '...................') ?></div>
    </div>

<?php endif; ?>

</body>
</html>