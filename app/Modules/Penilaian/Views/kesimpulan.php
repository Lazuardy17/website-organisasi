<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: #f3f4f6; }
        .topbar { background: #0d3b66; color: #fff; padding: 10px 24px; display: flex; justify-content: space-between; font-size: 13px; }
        .layout { display: flex; min-height: calc(100vh - 40px); }
        .sidebar { width: 260px; background: #0d3b66; color: #fff; padding: 20px 0; flex-shrink: 0; }
        .sidebar .brand { padding: 0 20px 20px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .sidebar .brand img { width: 40px; height: 40px; }
        .sidebar .brand strong { color: #fbbf24; font-size: 14px; display: block; }
        .sidebar .brand span { color: #fff; font-size: 12px; }
        .sidebar .section-title { color: #fbbf24; font-size: 12px; font-weight: 700; padding: 12px 20px 6px; text-transform: uppercase; }
        .sidebar a { display: block; color: #fff; text-decoration: none; padding: 10px 20px; font-size: 14px; }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.1); border-left: 3px solid #fbbf24; }
        .sidebar .logout { margin: 20px; padding: 10px 20px; border: 1px solid #fff; border-radius: 8px; text-align: center; font-weight: 600; }
        .content { flex: 1; padding: 24px 32px; }
        .header-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .content h1 { color: #0d3b66; font-size: 24px; }
        .status-badge { background: #fef3c7; color: #92400e; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; }
        .status-badge.dikirim { background: #dbeafe; color: #1e40af; }
        .status-badge.terverifikasi { background: #dcfce7; color: #166534; }
        .status-badge.perlurevisi { background: #fee2e2; color: #991b1b; }
        .card { background: #fff; border-radius: 12px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .nilai-akhir { text-align: center; padding: 32px 0; }
        .nilai-akhir .label { color: #6b7280; font-size: 16px; margin-bottom: 8px; }
        .nilai-akhir .value { color: #0d3b66; font-size: 72px; font-weight: 700; line-height: 1; }
        .nilai-akhir .kesimpulan { display: inline-block; padding: 8px 24px; border-radius: 20px; font-size: 16px; font-weight: 700; margin-top: 16px; }
        .kesimpulan-sangat-rendah { background: #fee2e2; color: #991b1b; }
        .kesimpulan-rendah { background: #fed7aa; color: #9a3412; }
        .kesimpulan-sedang { background: #fef3c7; color: #92400e; }
        .kesimpulan-tinggi { background: #dbeafe; color: #1e40af; }
        .kesimpulan-sangat-tinggi { background: #dcfce7; color: #166534; }
        .table-title { color: #0d3b66; font-size: 16px; font-weight: 700; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th { color: #6b7280; font-size: 13px; text-align: left; padding: 10px 8px; border-bottom: 2px solid #e5e7eb; text-transform: uppercase; }
        td { padding: 12px 8px; border-bottom: 1px solid #e5e7eb; font-size: 14px; color: #374151; }
        td.skor { text-align: right; font-weight: 600; color: #0d3b66; width: 80px; }
        .action-row { display: flex; justify-content: center; gap: 12px; margin-top: 24px; }
        .btn { display: inline-block; padding: 12px 32px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; color: #fff; border: none; cursor: pointer; }
        .btn-primary { background: #0d3b66; }
        .btn-primary:hover { background: #145a8a; }
        .btn-outline { background: #fff; color: #0d3b66; border: 1px solid #0d3b66; }
        .btn-outline:hover { background: #f0f4f8; }
        .btn-success { background: #16a34a; }
        .btn-success:hover { background: #15803d; }
        .btn-warning { background: #f59e0b; }
        .btn-warning:hover { background: #d97706; }
        .btn:disabled { background: #9ca3af; cursor: not-allowed; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .alert-info { background: #dbeafe; color: #1e40af; }
        .alert-warning { background: #fef3c7; color: #92400e; border-left: 4px solid #f59e0b; }
        .footer { text-align: center; color: #6b7280; font-size: 12px; padding: 16px; }
    </style>
</head>
<body>

    <div class="topbar">
        <div>📧 kelembagaan.kotabanjarbaru@gmail.com</div>
        <div>🏛️ Sekretariat Daerah Kota Banjarbaru Jl. Panglima Batur No. 1</div>
    </div>

    <div class="layout">
        <aside class="sidebar">
            <div class="brand">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/Lambang_Kota_Banjarbaru.png/200px-Lambang_Kota_Banjarbaru.png" alt="Logo">
                <div>
                    <strong>Pemerintah</strong>
                    <span>Kota Banjarbaru</span>
                </div>
            </div>
            <a href="<?= base_url('/opd/dashboard') ?>">📊 Dashboard</a>
            <div class="section-title">Akun & Evaluasi</div>
            <a href="#">👤 Akun</a>
            <a href="<?= base_url('/opd/penilaian') ?>">📋 Pengisian Variabel</a>
            <div class="section-title">Pelaporan</div>
            <a href="<?= base_url('/opd/kesimpulan') ?>" class="active">📁 Kesimpulan</a>
            <div class="section-title">Pengaturan</div>
            <a href="<?= base_url('/ubah-password') ?>">🔒 Ubah Password</a>
            <a href="<?= base_url('/logout') ?>" class="logout">Logout</a>
        </aside>

        <main class="content">
            <div class="header-row">
                <h1>Kesimpulan & Hasil Evaluasi</h1>
                <span class="status-badge <?= strtolower(str_replace('_', '', $penilaian['status'])) ?>">
                    Status: <?= esc($penilaian['status']) ?>
                </span>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if (!empty($catatanUmum)): ?>
                <?php foreach ($catatanUmum as $c): ?>
                    <div class="alert alert-warning">
                        ⚠️ <strong>Catatan Revisi dari Admin:</strong><br>
                        <?= esc($c['catatan']) ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!$lengkap): ?>
                <div class="alert alert-info">
                    ⚠️ Anda baru mengisi <strong><?= $jumlahTerisi ?>/11</strong> variabel.
                    Silakan lengkapi semua variabel terlebih dahulu sebelum submit.
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="nilai-akhir">
                    <div class="label">Nilai Akhir</div>
                    <div class="value"><?= number_format($totalSkor, 0) ?></div>
                    <?php $kelasKesimpulan = 'kesimpulan-' . strtolower(str_replace(' ', '-', $kesimpulan)); ?>
                    <span class="kesimpulan <?= $kelasKesimpulan ?>"><?= esc($kesimpulan) ?></span>
                </div>
            </div>

            <div class="card">
                <div class="table-title">Rincian Skor per Indikator</div>
                <table>
                    <thead>
                        <tr>
                            <th>Indikator</th>
                            <th style="text-align: right;">Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($detail)): ?>
                            <tr><td colspan="2" style="text-align: center; color: #9ca3af;">Belum ada variabel yang diisi.</td></tr>
                        <?php else: ?>
                            <?php foreach ($detail as $d): ?>
                                <tr>
                                    <td><?= esc($d['nama_variabel']) ?></td>
                                    <td class="skor"><?= number_format($d['nilai_skor'], 0) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="action-row">
                <a href="<?= base_url('/opd/penilaian') ?>" class="btn btn-outline">← Kembali ke Pengisian</a>
                
                <?php if ($lengkap && in_array($penilaian['status'], ['DRAFT', 'PERLU_REVISI'])): ?>
                    <form action="<?= base_url('/opd/kesimpulan/submit') ?>" method="post" style="display: inline;">
                        <?= csrf_field() ?>
                        <?php if ($penilaian['status'] === 'PERLU_REVISI'): ?>
                            <button type="submit" class="btn btn-warning" onclick="return confirm('Ajukan kembali setelah perbaikan?')">
                                🔄 Ajukan Ulang Setelah Revisi
                            </button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-success" onclick="return confirm('Yakin ingin submit? Setelah submit, Anda tidak bisa mengubah lagi kecuali Admin minta revisi.')">
                                Submit ke Admin
                            </button>
                        <?php endif; ?>
                    </form>
                <?php elseif ($penilaian['status'] === 'DIKIRIM'): ?>
                    <button class="btn btn-primary" disabled>✓ Sudah Dikirim ke Admin</button>
                <?php elseif ($penilaian['status'] === 'TERVERIFIKASI'): ?>
                    <button class="btn btn-success" disabled>✓ Sudah Terverifikasi</button>
                <?php else: ?>
                    <button class="btn" disabled>Lengkapi 11 Variabel Dulu</button>
                <?php endif; ?>
            </div>

        </main>
    </div>

    <div class="footer">© <?= date('Y') ?> Pemerintah Kota Banjarbaru</div>

</body>
</html>