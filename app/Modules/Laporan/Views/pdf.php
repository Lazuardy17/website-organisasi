<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penilaian</title>
    <style>
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; border-bottom: 3px double #0d3b66; padding-bottom: 12px; margin-bottom: 20px; }
        .header h1 { color: #0d3b66; font-size: 16px; margin: 0; }
        .header h2 { color: #0d3b66; font-size: 14px; margin: 4px 0; }
        .header p { margin: 2px 0; font-size: 11px; color: #555; }

        .opd-info { margin-bottom: 20px; }
        .opd-info table { width: 100%; font-size: 11px; }
        .opd-info td { padding: 4px 8px; vertical-align: top; }
        .opd-info td.label { font-weight: bold; width: 130px; color: #0d3b66; }

        .opd-section { margin-bottom: 30px; page-break-inside: avoid; }
        .opd-title {
            background: #0d3b66; color: #fff; padding: 8px 12px;
            font-size: 12px; font-weight: bold; border-radius: 4px;
            margin-bottom: 10px;
        }

        table.data { width: 100%; border-collapse: collapse; margin-bottom: 12px; font-size: 10px; }
        table.data th {
            background: #e0e7ff; color: #0d3b66; padding: 6px 8px;
            border: 1px solid #c7d2fe; text-align: left; font-weight: bold;
        }
        table.data td { padding: 6px 8px; border: 1px solid #e5e7eb; vertical-align: top; }
        table.data td.center { text-align: center; }
        table.data tr.total { background: #f0f9ff; font-weight: bold; color: #0d3b66; }

        .kesimpulan-box {
            background: #dcfce7; border: 1px solid #16a34a; color: #166534;
            padding: 10px 16px; border-radius: 6px; font-size: 11px;
            font-weight: bold; display: inline-block; margin-top: 4px;
        }
        .kesimpulan-box.sangat-rendah { background: #fee2e2; color: #991b1b; border-color: #ef4444; }
        .kesimpulan-box.rendah { background: #fed7aa; color: #9a3412; border-color: #f97316; }
        .kesimpulan-box.sedang { background: #fef3c7; color: #92400e; border-color: #f59e0b; }
        .kesimpulan-box.tinggi { background: #dbeafe; color: #1e40af; border-color: #3b82f6; }
        .kesimpulan-box.sangat-tinggi { background: #dcfce7; color: #166534; border-color: #16a34a; }

        .ttd { margin-top: 40px; width: 100%; }
        .ttd table { width: 100%; }
        .ttd td { text-align: center; width: 50%; vertical-align: top; }
        .ttd .nama { margin-top: 60px; font-weight: bold; text-decoration: underline; }

        .footer { margin-top: 30px; text-align: center; font-size: 9px; color: #888; border-top: 1px solid #e5e7eb; padding-top: 8px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>PEMERINTAH KOTA BANJARBARU</h1>
        <h2>LAPORAN HASIL PENILAIAN KEMATANGAN PERANGKAT DAERAH</h2>
        <p>Periode: <?= esc($periode['tahun']) ?> - <?= esc($periode['nama']) ?></p>
        <p>Sesuai Peraturan Menteri Dalam Negeri Nomor: 99 Tahun 2018</p>
    </div>

    <!-- Loop per OPD -->
    <?php foreach ($penilaianList as $index => $p): ?>

        <div class="opd-section">
            <!-- Info OPD -->
            <div class="opd-info">
                <table>
                    <tr>
                        <td class="label">Nama OPD</td>
                        <td>: <?= esc($p['nama_opd']) ?></td>
                    </tr>
                    <tr>
                        <td class="label">Kepala PD</td>
                        <td>: <?= esc($p['nama_kepala'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="label">NIP</td>
                        <td>: <?= esc($p['nip_kepala'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="label">Pangkat/Golongan</td>
                        <td>: <?= esc($p['pangkat_kepala'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="label">Status</td>
                        <td>: <?= esc($p['status']) ?></td>
                    </tr>
                </table>
            </div>

            <!-- Tabel 11 Variabel -->
            <table class="data">
                <thead>
                    <tr>
                        <th style="width: 30px; text-align: center;">No</th>
                        <th>Variabel Penilaian</th>
                        <th style="width: 70px; text-align: center;">Tingkat</th>
                        <th style="width: 50px; text-align: center;">Skor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($p['detail'] as $d): ?>
                        <tr>
                            <td class="center"><?= $d['nomor_urutan'] ?></td>
                            <td><?= esc($d['nama_variabel']) ?></td>
                            <td class="center"><?= esc($d['nama_tingkat']) ?></td>
                            <td class="center"><strong><?= number_format($d['nilai_skor'], 0) ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="total">
                        <td colspan="3" style="text-align: right;">TOTAL SKOR</td>
                        <td class="center"><?= number_format($p['total_skor'], 0) ?></td>
                    </tr>
                </tbody>
            </table>

            <!-- Kesimpulan -->
            <div>
                <strong style="color: #0d3b66;">Kesimpulan:</strong>
                <?php
                    $kelasKesimpulan = 'kesimpulan-box ' . strtolower(str_replace(' ', '-', $p['kesimpulan'] ?? 'sangat-rendah'));
                ?>
                <span class="<?= $kelasKesimpulan ?>">
                    <?= esc($p['kesimpulan'] ?? '-') ?>
                </span>
            </div>
        </div>

        <?php if ($index < count($penilaianList) - 1): ?>
            <div class="page-break"></div>
        <?php endif; ?>

    <?php endforeach; ?>

    <!-- Tanda Tangan -->
    <div class="ttd">
        <table>
            <tr>
                <td>
                    Mengetahui,<br>
                    Kepala Perangkat Daerah<br>
                    <div class="nama"><?= esc($penilaianList[0]['nama_kepala'] ?? '...................') ?></div>
                    NIP. <?= esc($penilaianList[0]['nip_kepala'] ?? '...................') ?>
                </td>
                <td>
                    Banjarbaru, <?= date('d F Y') ?><br>
                    Admin Penilaian<br>
                    <div class="nama">..............................</div>
                    NIP. ..............................
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Dicetak dari Sistem Penilaian Kematangan Perangkat Daerah — Pemerintah Kota Banjarbaru
    </div>

</body>
</html>