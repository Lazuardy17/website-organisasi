<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Semua OPD</title>
<style>
    @page { size: letter portrait; margin: 0; }
    html, body { margin: 0; padding: 0; }
    body { font-family: 'XCalibri', sans-serif; color: #000; font-size: 9pt; }
    .pg {
        padding: 40pt 40pt 40pt 40pt;   /* atas kanan bawah kiri — semua 40pt */
    }
    .ttl {
        text-align: center;
        font-weight: bold;
        line-height: 14pt;
        margin-bottom: 16pt;
    }
    .ttl h1 { font-size: 11pt; margin: 0; }
    .ttl h2 { font-size: 11pt; margin: 4pt 0; }
    .ttl .periode { font-size: 10pt; margin-top: 8pt; font-weight: normal; }
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
    .footer {
        margin-top: 24pt;
        text-align: center;
        font-size: 8pt;
        color: #555;
        border-top: 0.5pt solid #ccc;
        padding-top: 8pt;
    }
</style>
</head>
<body>

<div class="pg">
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
            <?php foreach ($penilaianList as $i => $p): ?>
                <tr>
                    <td class="ctr"><?= $i + 1 ?></td>
                    <td><?= esc($p['nama_opd']) ?></td>
                    <td class="ctr"><?= number_format($p['total_skor'], 0) ?></td>
                    <td class="ctr"><?= esc($p['kesimpulan'] ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>