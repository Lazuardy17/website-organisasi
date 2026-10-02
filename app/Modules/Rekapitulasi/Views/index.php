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

        /* Filter */
        .filter-card { background: #fff; border-radius: 12px; padding: 20px 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .filter-row { display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap; }
        .filter-group { display: flex; flex-direction: column; gap: 6px; }
        .filter-group label { color: #0d3b66; font-size: 13px; font-weight: 600; }
        .filter-group select {
            padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px;
            font-size: 14px; outline: none; min-width: 180px; background: #fff;
        }
        .filter-group select:focus { border-color: #0d3b66; }
        .btn-filter { background: #0d3b66; color: #fff; border: none; padding: 10px 24px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; }
        .btn-filter:hover { background: #145a8a; }
        .btn-reset { background: #fff; color: #0d3b66; border: 1px solid #0d3b66; padding: 10px 24px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-reset:hover { background: #f0f4f8; }

        /* Stats */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 20px; }
        .stat-card {
            background: #fff; border-radius: 12px; padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border-left: 6px solid #0d3b66;
        }
        .stat-card:nth-child(2) { border-left-color: #16a34a; }
        .stat-card:nth-child(3) { border-left-color: #f59e0b; }
        .stat-card:nth-child(4) { border-left-color: #60a5fa; }
        .stat-card .label { color: #0d3b66; font-size: 13px; margin-bottom: 8px; }
        .stat-card .value { color: #0d3b66; font-size: 28px; font-weight: 700; }

        /* Table */
        .card { background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .card h2 { color: #0d3b66; font-size: 18px; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th { color: #0d3b66; text-align: left; padding: 12px 8px; border-bottom: 2px solid #e5e7eb; font-size: 14px; vertical-align: top; }
        td { padding: 12px 8px; border-bottom: 1px solid #e5e7eb; font-size: 14px; color: #374151; vertical-align: top; word-wrap: break-word; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .badge-draft { background: #e5e7eb; color: #374151; }
        .badge-dikirim { background: #fef3c7; color: #92400e; }
        .badge-perlu-revisi { background: #fee2e2; color: #991b1b; }
        .badge-terverifikasi { background: #dcfce7; color: #166534; }
        .badge-verif-ulang { background: #fde68a; color: #78350f; }
        .btn { display: inline-block; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600; color: #fff; background: #0d3b66; }
        .btn:hover { background: #145a8a; }
        .empty-row { text-align: center; color: #9ca3af; padding: 40px; }
        .skor { font-weight: 700; color: #0d3b66; }
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
            <a href="<?= base_url('/admin/dashboard') ?>">📊 Dashboard</a>
            <div class="section-title">Kelola User</div>
            <a href="<?= base_url('/admin/akun-opd') ?>">👥 Manajemen Akun OPD</a>
            <div class="section-title">Penilaian</div>
            <a href="<?= base_url('/admin/verifikasi') ?>">📝 Verifikasi Penilaian</a>
            <div class="section-title">Pelaporan</div>
            <a href="<?= base_url('/admin/rekapitulasi') ?>">📈 Rekapitulasi Data</a>
            <a href="<?= base_url('/admin/laporan') ?>">📥 Ekspor Laporan</a>
            <div class="section-title">Pengaturan</div>
            <a href="<?= base_url('/ubah-password') ?>">🔒 Ubah Password</a>
            <a href="<?= base_url('/logout') ?>" class="logout">Logout</a>
        </aside>

        <main class="content">
            <h1>Rekapitulasi Data</h1>

            <!-- Filter -->
            <div class="filter-card">
                <form action="<?= base_url('/admin/rekapitulasi') ?>" method="get">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label>Periode</label>
                            <select name="periode_id">
                                <?php foreach ($periodeList as $p): ?>
                                    <option value="<?= $p['id'] ?>" <?= $p['id'] == $periodeId ? 'selected' : '' ?>>
                                        <?= esc($p['tahun']) ?> - <?= esc($p['nama']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Status Verifikasi</label>
                            <select name="status">
                                <option value="semua" <?= $statusFilter === 'semua' ? 'selected' : '' ?>>Semua Status</option>
                                <option value="DRAFT" <?= $statusFilter === 'DRAFT' ? 'selected' : '' ?>>DRAFT</option>
                                <option value="DIKIRIM" <?= $statusFilter === 'DIKIRIM' ? 'selected' : '' ?>>DIKIRIM</option>
                                <option value="PERLU_REVISI" <?= $statusFilter === 'PERLU_REVISI' ? 'selected' : '' ?>>PERLU REVISI</option>
                                <option value="TERVERIFIKASI" <?= $statusFilter === 'TERVERIFIKASI' ? 'selected' : '' ?>>TERVERIFIKASI</option>
                                <option value="PERLU_VERIFIKASI_ULANG" <?= $statusFilter === 'PERLU_VERIFIKASI_ULANG' ? 'selected' : '' ?>>PERLU VERIFIKASI ULANG</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-filter">Terapkan</button>
                        <a href="<?= base_url('/admin/rekapitulasi') ?>" class="btn-reset">Reset</a>
                    </div>
                </form>
            </div>

            <!-- Statistik Ringkasan -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="label">Total OPD Dinilai</div>
                    <div class="value"><?= $totalDinilai ?></div>
                </div>
                <div class="stat-card">
                    <div class="label">Terverifikasi</div>
                    <div class="value"><?= $jumlahTerverifikasi ?></div>
                </div>
                <div class="stat-card">
                    <div class="label">Menunggu Verifikasi</div>
                    <div class="value"><?= $jumlahMenunggu ?></div>
                </div>
                <div class="stat-card">
                    <div class="label">Rata-rata Skor</div>
                    <div class="value"><?= number_format($rataRataSkor, 0) ?></div>
                </div>
            </div>

            <!-- Tabel Rekapitulasi -->
            <div class="card">
                <h2>Rekapitulasi OPD</h2>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama OPD</th>
                            <th>Tanggal Submit</th>
                            <th>Skor</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($daftar)): ?>
                            <tr><td colspan="6" class="empty-row">Belum ada data penilaian untuk filter ini.</td></tr>
                        <?php else: ?>
                            <?php foreach ($daftar as $i => $d): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($d['nama_opd']) ?></td>
                                    <td><?= $d['diajukan_pada'] ? date('d M Y', strtotime($d['diajukan_pada'])) : '-' ?></td>
                                    <td class="skor"><?= $d['total_skor'] > 0 ? number_format($d['total_skor'], 0) : '-' ?></td>
                                    <td>
                                        <?php
                                            $badgeClass = 'badge-draft';
                                            if ($d['status'] === 'DIKIRIM') $badgeClass = 'badge-dikirim';
                                            elseif ($d['status'] === 'PERLU_REVISI') $badgeClass = 'badge-perlu-revisi';
                                            elseif ($d['status'] === 'TERVERIFIKASI') $badgeClass = 'badge-terverifikasi';
                                            elseif ($d['status'] === 'PERLU_VERIFIKASI_ULANG') $badgeClass = 'badge-verif-ulang';
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= esc($d['status']) ?></span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('/admin/verifikasi/detail/' . $d['id']) ?>" class="btn">Lihat Detail</a>
                                    </td>
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