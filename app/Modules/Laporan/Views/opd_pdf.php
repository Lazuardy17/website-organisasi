<?php
/**
 * App\Modules\Laporan\Views\opd_pdf
 *
 * Meniru layout Excel (Sheet4 = Rekap, Sheet5 = Formulir) pada Dompdf.
 *
 * CARA KERJA UKURAN
 * Semua angka di bawah ini DIUKUR dari PDF ekspor Excel (satuan "unit" = pt
 * pada skala 100%). Lalu dikalikan skala cetak Excel (Page Setup > Scale):
 *   Sheet4 = 75%  -> $K4
 *   Sheet5 = 79%  -> $K5
 * Kertas Excel = Letter (8.5x11in), margin L/R 0.7in, T/B 0.75in.
 *
 * View ini dirender per sheet: $format = 'sheet4' atau 'sheet5'.
 * (Format gabungan = dua PDF digabung di controller.)
 */

$K4 = 0.75;
$K5 = 0.79;
$p4 = fn($n) => round($n * $K4, 3) . 'pt';
$p5 = fn($n) => round($n * $K5, 3) . 'pt';

// Kalibrasi: kalau baris di PDF web sedikit lebih tinggi/rendah dari Excel,
// ubah angka ini (satuan unit, mis. -0.4 atau 0.4) lalu ekspor ulang.
$ADJ_ROW4 = -0.8;   // garis tabel menambah ±0.8 unit per baris
$ADJ_ROW5 = -0.6;

// HASIL UKUR Dompdf 3.1.6: line-height dalam pt tampil ±1,333x lebih besar.
// Faktor koreksi (kalau nanti Dompdf diperbarui dan sudah normal, ubah jadi 1).
$LHF = 0.75;
$l4 = fn($n) => round($n * $K4 * $LHF, 3) . 'pt';
$l5 = fn($n) => round($n * $K5 * $LHF, 3) . 'pt';

// Lebar sel di Dompdf = lebar ISI (padding + garis ditambahkan di luar),
// jadi lebar target dikurangi padding kiri-kanan dan garis.
$W4 = fn($n) => round(($n - 2 * 2.3 - 0.6) * $K4, 3) . 'pt';
$W5 = fn($n) => round(($n - 2 * 2.5 - 0.8) * $K5, 3) . 'pt';

// Margin kertas Excel (0.75in atas, 0.7in kiri) dipasang manual lewat padding,
// karena @page margin tidak diterapkan Dompdf pada hasil ekspor sebelumnya.
$MARGIN_TOP  = '54pt';
$MARGIN_LEFT = '50.4pt';

$totalSkor = 0;
foreach ($detail as $d) {
    $totalSkor += (float) $d['nilai_skor'];
}
$kesimpulanText = $penilaian['kesimpulan'] ?? '-';

$namaOpd = esc(mb_strtoupper($opd['nama'], 'UTF-8'));

// "(outcome)" dicetak miring seperti di Excel
$indikator = fn($s) => str_ireplace('(outcome)', '(<i>outcome</i>)', esc($s));

// Pecah tautan panjang supaya tidak keluar dari sel (Dompdf tidak punya word-break)
$pecah = function ($s, $n = 32) {
    $s = (string) $s;
    return esc(implode(' ', mb_str_split($s, $n)));
};

// Blok tanda tangan. $rowH = tinggi baris Excel, $marginLeft = posisi blok.
$ttd = function (callable $p, callable $l, float $rowH, float $marginLeft) use ($opd) {
    $ln = 'height:' . $p($rowH) . ';line-height:' . $l($rowH) . ';';
    ?>
    <div class="sg" style="margin-left:<?= $p($marginLeft) ?>; width:<?= $p(240) ?>;">
        <div style="<?= $ln ?>">Mengetahui</div>
        <div style="<?= $ln ?>"><?= esc($opd['nomenklatur_jabatan'] ?? 'Kepala Perangkat Daerah') ?></div>
        <div style="height:<?= $p($rowH * 4) ?>;"></div>
        <div style="<?= $ln ?> text-decoration:underline;"><?= esc($opd['nama_kepala'] ?? '...................') ?></div>
        <div style="<?= $ln ?>"><?= esc($opd['pangkat_kepala'] ?? '...................') ?></div>
        <div style="<?= $ln ?>"><?= esc($opd['nip_kepala'] ?? '...................') ?></div>
    </div>
    <?php
};
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Penilaian</title>
<style>
    /* Font XCalibri & XBookman didaftarkan dari controller (registerFont) */

    /* ===== Kertas: Letter, margin sama dengan Excel (0.75in atas/bawah, 0.7in kiri/kanan) ===== */
    @page { size: letter <?= $format === 'sheet5' ? 'landscape' : 'portrait' ?>; margin: 0; }

    html, body { margin: 0; padding: 0; }
    body { font-family: 'XCalibri', sans-serif; color: #000; }
    table { border-collapse: collapse; border-spacing: 0; empty-cells: show; }
    .ctr { text-align: center; }

    /* =====================================================================
       SHEET 4 — REKAP   (font Calibri 11, skala 75%)
       Lebar kolom (unit): B 70.2 | C 306.6 | D 112.9 | E 80.6  (total 570.3)
       Offset kiri tabel (kolom A kosong): 51.2
    ===================================================================== */
    .pg4 { font-size: <?= $p4(11) ?>; padding: <?= $MARGIN_TOP ?> 0 0 <?= $MARGIN_LEFT ?>; }
    .t4 { margin-left: <?= $p4(51.2) ?>; width: <?= $p4(570.3) ?>; }
    .t4 td, .t4 th {
        padding: 0 <?= $p4(2.3) ?>;
        height: <?= $p4(14.55 + $ADJ_ROW4) ?>;
        line-height: <?= $l4(14.55 + $ADJ_ROW4) ?>;
        vertical-align: middle;
        font-weight: normal;
        border: <?= round(0.75 * $K4, 3) ?>pt solid #000;
        overflow: hidden;
    }
    .t4 .c1 { width: <?= $W4(70.2) ?>; }
    .t4 .c2 { width: <?= $W4(306.6) ?>; }
    .t4 .c3 { width: <?= $W4(112.9) ?>; }
    .t4 .c4 { width: <?= $W4(80.6) ?>; }
    .t4 th { background: #FFFF00; text-align: center; white-space: nowrap; height: <?= $p4(32.9 + $ADJ_ROW4) ?>; line-height: <?= $l4(32.9 + $ADJ_ROW4) ?>; }
    .t4 td.nb { border: none; }
    .t4 td.rt { text-align: right; }
    .ttl4 { margin-left: <?= $p4(51.2) ?>; width: <?= $p4(570.3) ?>; text-align: center; font-weight: bold;
            height: <?= $p4(14.55) ?>; line-height: <?= $l4(14.55) ?>; }

    /* =====================================================================
       SHEET 5 — FORMULIR   (Bookman Old Style 11, skala 79%)
       Lebar kolom (unit): B 76.7 | C 360.2 | D 85.1 | E 68.2 | F 67.8 | G 207.6  (total 865.6)
    ===================================================================== */
    .pg5 { font-size: <?= $p5(11) ?>; padding: <?= $MARGIN_TOP ?> 0 0 <?= $MARGIN_LEFT ?>; }
    .ttl5 { width: <?= $p5(865.6) ?>; text-align: center; font-weight: bold; font-size: <?= $p5(18) ?>; }
    .vt { height: <?= $p5(14.65) ?>; line-height: <?= $l5(14.65) ?>; padding-left: <?= $p5(2) ?>; }
    .t5 { width: <?= $p5(865.6) ?>; border: <?= round(1.5 * $K5, 3) ?>pt solid #000; }
    .t5 th, .t5 td {
        font-family: 'XBookman', 'XCalibri', serif;
        padding: 0 <?= $p5(2.5) ?>;
        line-height: <?= $l5(13.7) ?>;
        vertical-align: middle;
        border: <?= round(0.75 * $K5, 3) ?>pt solid #000;
        overflow: hidden;
    }
    .t5 th { font-weight: bold; text-align: center; height: <?= $p5(14.25 + $ADJ_ROW5) ?>; }
    .t5 td { height: <?= $p5(14.25 + $ADJ_ROW5) ?>; text-align: center; }
    .t5 .c1 { width: <?= $W5(76.7) ?>; }
    .t5 .c2 { width: <?= $W5(360.2) ?>; }
    .t5 .c3 { width: <?= $W5(85.1) ?>; }
    .t5 .c4 { width: <?= $W5(68.2) ?>; }
    .t5 .c5 { width: <?= $W5(67.8) ?>; }
    .t5 .c6 { width: <?= $W5(207.6) ?>; }
    .t5 .c45 { width: <?= $W5(136.0) ?>; }
    .t5 th.c1, .t5 td.c1 { font-size: <?= $p5(10) ?>; }
    .t5 td.c1 { text-align: left; }
    .t5 td.ind { text-align: justify; }

    .sg { text-align: center; page-break-inside: avoid; }
</style>
</head>
<body>

<?php /* ================= SHEET 4 — REKAPITULASI ================= */ ?>
<?php if ($format === 'sheet4'): ?>
<div class="pg4">

    <div class="ttl4" style="font-weight:normal;">&nbsp;</div>
    <div class="ttl4">REKAPITULASI HASIL PENILAIAN KEMATANGAN PENATAAN PERANGKAT DAERAH</div>
    <div class="ttl4"><?= $namaOpd ?></div>
    <div class="ttl4">KOTA BANJARBARU</div>
    <div class="ttl4" style="font-weight:normal;">&nbsp;</div>

    <table class="t4">
        <thead>
            <tr>
                <th class="c1">NO.</th>
                <th class="c2">VARIABEL</th>
                <th class="c3">SKOR</th>
                <th class="c4">BUKTI DUKUNG</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detail as $d): ?>
            <tr>
                <td class="c1 ctr"><?= esc($d['nomor_urutan']) ?></td>
                <td class="c2"><?= esc($d['nama_variabel']) ?></td>
                <td class="c3 ctr"><?= number_format($d['nilai_skor'], 0) ?></td>
                <td class="c4 ctr">Ada</td>
            </tr>
            <?php endforeach; ?>

            <!-- Total: hanya sel kolom SKOR yang berborder (tanpa label), seperti Excel -->
            <tr>
                <td class="c1 nb">&nbsp;</td>
                <td class="c2 nb">&nbsp;</td>
                <td class="c3 ctr"><?= number_format($totalSkor, 0) ?></td>
                <td class="c4 nb">&nbsp;</td>
            </tr>
            <tr>
                <td class="c1 nb">&nbsp;</td><td class="c2 nb">&nbsp;</td><td class="c3 nb">&nbsp;</td><td class="c4 nb">&nbsp;</td>
            </tr>
            <tr>
                <td class="c1 nb">&nbsp;</td>
                <td class="c2 nb rt">Hasil Akhir</td>
                <td class="c3 ctr"><?= number_format($totalSkor, 0) ?></td>
                <td class="c4 nb">&nbsp;</td>
            </tr>
            <tr>
                <td class="c1 nb">&nbsp;</td>
                <td class="c2 nb rt">Opini</td>
                <td class="c3 ctr"><?= esc(mb_strtoupper($kesimpulanText, 'UTF-8')) ?></td>
                <td class="c4 nb">&nbsp;</td>
            </tr>
        </tbody>
    </table>

    <!-- 2 baris kosong, lalu blok tanda tangan terpusat pada kolom SKOR (D) -->
    <div style="height:<?= $p4(14.55 * 2) ?>;"></div>
    <?php $ttd($p4, $l4, 14.55, 364.45); ?>

</div>
<?php endif; ?>


<?php /* ================= SHEET 5 — FORMULIR PER VARIABEL ================= */ ?>
<?php if ($format === 'sheet5'): ?>

    <?php foreach ($variabelList as $index => $v): ?>
    <?php
        $jml     = max(count($v['tingkat']), 1);
        $pindah  = ($index > 0);
    ?>
    <div class="pg5" style="<?= $pindah ? 'page-break-before: always;' : '' ?>">

        <?php if ($index === 0): ?>
            <div class="ttl5" style="height:<?= $p5(23.25) ?>; line-height:<?= $l5(23.25) ?>;">FORMULIR PENILAIAN KEMATANGAN PENATAAN PERANGKAT DAERAH KOTA BANJARBARU</div>
            <div class="ttl5" style="height:<?= $p5(18.95) ?>; line-height:<?= $l5(18.95) ?>;"><?= $namaOpd ?></div>
            <div style="height:<?= $p5(14.25) ?>;"></div>
        <?php else: ?>
            <div style="height:<?= $p5(14.25) ?>;"></div>
        <?php endif; ?>

        <div class="vt">VARIABEL <?= esc($v['nomor_urutan']) ?></div>

        <table class="t5">
            <thead>
                <tr>
                    <th class="c1" rowspan="2">Tingkat</th>
                    <th class="c2" rowspan="2">Indikator</th>
                    <th class="c3" rowspan="2">Penilaian<br>Mandiri PD</th>
                    <th class="c45" colspan="2">Bukti Dukung</th>
                    <th class="c6" rowspan="2">Keterangan</th>
                </tr>
                <tr>
                    <th class="c4">Ada</th>
                    <th class="c5">Tidak Ada</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $skor   = '';
                    $tautan = '';
                    $ada    = false;
                    foreach ($v['tingkat'] as $t) {
                        if ($v['detail'] && $v['detail']['tingkat_id'] == $t['id']) {
                            $skor   = number_format($v['detail']['nilai_skor'], 0);
                            $tautan = $v['detail']['tautan_bukti'] ?? '';
                            $ada    = true;
                        }
                    }
                ?>
                <?php foreach ($v['tingkat'] as $i => $t): ?>
                    <?php $terpilih = ($v['detail'] && $v['detail']['tingkat_id'] == $t['id']); ?>
                    <tr>
                        <td class="c1"><?= esc($t['nama_tingkat']) ?></td>
                        <td class="c2 ind"><?= $indikator($t['indikator']) ?></td>
                        <td class="c3"><?= $terpilih ? $skor : '&nbsp;' ?></td>
                        <?php if ($i === 0): ?>
                            <!-- Sel gabungan (merge) setinggi 5 baris, sama seperti Excel -->
                            <td class="c4" rowspan="<?= $jml ?>"><?= $ada ? 'Y' : '&nbsp;' ?></td>
                            <td class="c5" rowspan="<?= $jml ?>">&nbsp;</td>
                            <td class="c6" rowspan="<?= $jml ?>"><?= $ada && $tautan !== '' ? $pecah($tautan) : '&nbsp;' ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($index === count($variabelList) - 1): ?>
            <!-- 2 baris kosong, lalu tanda tangan terpusat pada kolom "Tidak Ada" (F) -->
            <div style="height:<?= $p5(14.25 * 2) ?>;"></div>
            <?php $ttd($p5, $l5, 14.25, 504.15); ?>
        <?php endif; ?>

    </div>
    <?php endforeach; ?>

<?php endif; ?>

</body>
</html>