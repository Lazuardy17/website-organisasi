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
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card { background: #fff; border-radius: 12px; padding: 20px; border-left: 6px solid #0d3b66; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .stat-card:nth-child(2) { border-left-color: #60a5fa; }
        .stat-card:nth-child(4) { border-left-color: #60a5fa; }
        .stat-card .label { color: #0d3b66; font-size: 14px; margin-bottom: 8px; }
        .stat-card .value { color: #0d3b66; font-size: 32px; font-weight: 700; }
        .card { background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .card h2 { color: #0d3b66; font-size: 18px; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th { color: #0d3b66; text-align: left; padding: 12px 8px; border-bottom: 2px solid #e5e7eb; font-size: 14px; }
        td { padding: 12px 8px; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .badge-submitted { background: #fef3c7; color: #92400e; }
        .btn { display: inline-block; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600; color: #fff; background: #0d3b66; }
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
            <a href="<?= base_url('/admin/dashboard') ?>" class="active">📊 Dashboard</a>
            <div class="section-title">Kelola User</div>
            <a href="<?= base_url('/admin/akun-opd') ?>">👥 Manajemen Akun OPD</a>
            <div class="section-title">Penilaian</div>
            <a href="#">📝 Verifikasi Penilaian</a>
            <div class="section-title">Pelaporan</div>
            <a href="#">📈 Rekapitulasi Data</a>
            <a href="#">📥 Ekspor Laporan</a>
            <div class="section-title">Pengaturan</div>
            <a href="<?= base_url('/ubah-password') ?>">🔒 Ubah Password</a>
            <a href="<?= base_url('/logout') ?>" class="logout">Logout</a>
        </aside>

        <main class="content">
            <h1>Dashboard Admin</h1>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="label">Total OPD Terdaftar</div>
                    <div class="value"><?= $total_opd ?></div>
                </div>
                <div class="stat-card">
                    <div class="label">Belum Submit (draft)</div>
                    <div class="value"><?= $belum_submit ?></div>
                </div>
                <div class="stat-card">
                    <div class="label">Menunggu Verifikasi</div>
                    <div class="value"><?= $menunggu_verif ?></div>
                </div>
                <div class="stat-card">
                    <div class="label">Selesai Diverifikasi</div>
                    <div class="value"><?= $terverifikasi ?></div>
                </div>
            </div>

            <div class="card">
                <h2>Antrean verifikasi utama (SUBMITTED)</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nama OPD</th>
                            <th>Tanggal</th>
                            <th>Skor</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($antrean)): ?>
                            <tr><td colspan="5" style="text-align:center; color:#6b7280;">Belum ada penilaian yang masuk.</td></tr>
                        <?php else: ?>
                            <?php foreach ($antrean as $a): ?>
                                <tr>
                                    <td><?= esc($a['nama_opd']) ?></td>
                                    <td><?= esc($a['tanggal']) ?></td>
                                    <td><?= esc($a['skor']) ?></td>
                                    <td><span class="badge badge-submitted"><?= esc($a['status']) ?></span></td>
                                    <td><a href="#" class="btn">Verifikasi</a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <div class="footer">© <?= date('Y') ?> Pemerintah Kota Banjarbaru</div>

</body>
</html>