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
        .content h1 { color: #0d3b66; font-size: 24px; margin-bottom: 20px; }

        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
        .alert-info { background: #fef3c7; color: #92400e; border-left: 4px solid #fbbf24; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .alert-warning { background: #fef3c7; color: #92400e; border-left: 4px solid #f59e0b; }

        /* Stat cards */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card {
            background: #fff; border-radius: 12px; padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border-left: 6px solid #0d3b66;
        }
        .stat-card:nth-child(2) { border-left-color: #60a5fa; }
        .stat-card:nth-child(3) { border-left-color: #f59e0b; }
        .stat-card:nth-child(4) { border-left-color: #16a34a; }
        .stat-card .label { color: #0d3b66; font-size: 14px; margin-bottom: 8px; }
        .stat-card .value { color: #0d3b66; font-size: 32px; font-weight: 700; }

        .card { background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .card h2 { color: #0d3b66; font-size: 18px; margin-bottom: 16px; }

        /* Progress steps */
        .steps { display: flex; justify-content: space-between; position: relative; margin-top: 20px; }
        .steps::before { content: ''; position: absolute; top: 20px; left: 12%; right: 12%; height: 2px; background: #e5e7eb; z-index: 0; }
        .step { position: relative; z-index: 1; text-align: center; flex: 1; }
        .step .circle {
            width: 40px; height: 40px; border-radius: 50%;
            background: #e5e7eb; color: #6b7280;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 8px; font-weight: 700; font-size: 16px;
        }
        .step.aktif .circle { background: #0d3b66; color: #fff; }
        .step.selesai .circle { background: #16a34a; color: #fff; }
        .step .title { font-size: 14px; font-weight: 700; color: #6b7280; }
        .step.aktif .title { color: #0d3b66; }
        .step.selesai .title { color: #16a34a; }
        .step .desc { font-size: 12px; color: #9ca3af; margin-top: 4px; }

        .btn { display: inline-block; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; color: #fff; border: none; cursor: pointer; }
        .btn-primary { background: #0d3b66; }
        .btn-primary:hover { background: #145a8a; }
        .btn-warning { background: #f59e0b; }
        .btn-warning:hover { background: #d97706; }
        .action-buttons { display: flex; gap: 12px; margin-top: 20px; }
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
            <a href="<?= base_url('/opd/dashboard') ?>" class="active">📊 Dashboard</a>
            <div class="section-title">Akun & Evaluasi</div>
            <a href="<?= base_url('/opd/akun') ?>">👤 Akun</a>
            <a href="<?= base_url('/opd/penilaian') ?>">📋 Pengisian Variabel</a>
            <div class="section-title">Pelaporan</div>
            <a href="<?= base_url('/opd/kesimpulan') ?>">📁 Kesimpulan</a>
            <div class="section-title">Pengaturan</div>
            <a href="<?= base_url('/ubah-password') ?>">🔒 Ubah Password</a>
            <a href="<?= base_url('/logout') ?>" class="logout">Logout</a>
        </aside>

        <main class="content">
            <h1>Dashboard OPD</h1>
            <p style="color:#6b7280; margin-bottom: 20px;">Selamat datang, <strong><?= esc($opd['nama']) ?></strong>!</p>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-info"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <?php if (!empty($catatan_admin)): ?>
                <div class="alert alert-warning">
                    ⚠️ <strong>Ada catatan revisi dari Admin:</strong> Silakan perbaiki penilaian Anda.<br>
                    <a href="<?= base_url('/opd/penilaian') ?>" style="color: #92400e; font-weight: 700;">Lihat & perbaiki sekarang →</a>
                </div>
            <?php endif; ?>

            <?php if (!$periode): ?>
                <div class="alert alert-error">Belum ada periode penilaian yang aktif. Hubungi Admin.</div>
            <?php else: ?>

                <!-- Statistik -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="label">Total Variabel</div>
                        <div class="value"><?= $total_variabel ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="label">Belum Diisi</div>
                        <div class="value"><?= $belum_diisi ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="label">Status</div>
                        <div class="value" style="font-size: 20px;"><?= esc($status) ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="label">Skor</div>
                        <div class="value"><?= $skor !== null ? number_format($skor, 0) : '—' ?></div>
                    </div>
                </div>

                <!-- Progress Pengisian -->
                <div class="card">
                    <h2>Progress Pengisian Variabel</h2>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="color: #6b7280;">Variabel yang sudah diisi</span>
                        <strong style="color: #0d3b66;"><?= $terisi ?>/<?= $total_variabel ?></strong>
                    </div>
                    <div style="background: #e5e7eb; height: 10px; border-radius: 5px; overflow: hidden; margin-bottom: 20px;">
                        <div style="background: #0d3b66; height: 100%; width: <?= ($terisi / $total_variabel) * 100 ?>%;"></div>
                    </div>

                    <?php if ($terisi < 11): ?>
                        <a href="<?= base_url('/opd/penilaian') ?>" class="btn btn-primary">Lanjutkan Pengisian →</a>
                    <?php else: ?>
                        <a href="<?= base_url('/opd/kesimpulan') ?>" class="btn btn-primary">Lihat Kesimpulan →</a>
                    <?php endif; ?>
                </div>

                <!-- Status Pengerjaan -->
                <div class="card">
                    <h2>Status Pengerjaan</h2>
                    <div class="steps">
                        <?php
                            $tahap1 = ($terisi > 0) ? 'selesai' : 'aktif';
                            $tahap2 = ($terisi >= 11) ? 'selesai' : (($terisi > 0) ? 'aktif' : '');
                            $tahap3 = (in_array($status, ['DIKIRIM', 'PERLU_VERIFIKASI_ULANG', 'TERVERIFIKASI'])) ? 'selesai' : (($terisi >= 11) ? 'aktif' : '');
                            $tahap4 = ($status === 'TERVERIFIKASI') ? 'selesai' : (($status === 'DIKIRIM') ? 'aktif' : '');
                        ?>
                        <div class="step <?= $tahap1 ?>">
                            <div class="circle">1</div>
                            <div class="title">Pengisian</div>
                            <div class="desc">Isi seluruh variabel penilaian</div>
                        </div>
                        <div class="step <?= $tahap2 ?>">
                            <div class="circle">2</div>
                            <div class="title">Kalkulasi</div>
                            <div class="desc">Sistem menghitung skor</div>
                        </div>
                        <div class="step <?= $tahap3 ?>">
                            <div class="circle">3</div>
                            <div class="title">Verifikasi</div>
                            <div class="desc">Menunggu verifikasi Admin</div>
                        </div>
                        <div class="step <?= $tahap4 ?>">
                            <div class="circle">4</div>
                            <div class="title">Selesai</div>
                            <div class="desc">Nilai akhir sudah fix</div>
                        </div>
                    </div>
                </div>

            <?php endif; ?>
        </main>
    </div>

    <div class="footer">© <?= date('Y') ?> Pemerintah Kota Banjarbaru</div>

</body>
</html>