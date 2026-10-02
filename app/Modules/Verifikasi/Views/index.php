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
        .card { background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th { color: #0d3b66; text-align: left; padding: 12px 8px; border-bottom: 2px solid #e5e7eb; font-size: 14px; }
        td { padding: 12px 8px; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .badge-dikirim { background: #dbeafe; color: #1e40af; }
        .badge-verif-ulang { background: #fef3c7; color: #92400e; }
        .btn { display: inline-block; padding: 6px 16px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 600; color: #fff; border: none; cursor: pointer; }
        .btn-primary { background: #0d3b66; }
        .btn-primary:hover { background: #145a8a; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .alert-info { background: #dbeafe; color: #1e40af; }
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
            <a href="<?= base_url('/admin/verifikasi') ?>" class="active">📝 Verifikasi Penilaian</a>
            <div class="section-title">Pelaporan</div>
            <a href="<?= base_url('/admin/rekapitulasi') ?>">📈 Rekapitulasi Data</a>
            <a href="#">📥 Ekspor Laporan</a>
            <div class="section-title">Pengaturan</div>
            <a href="<?= base_url('/ubah-password') ?>">🔒 Ubah Password</a>
            <a href="<?= base_url('/logout') ?>" class="logout">Logout</a>
        </aside>

        <main class="content">
            <h1>Verifikasi Penilaian</h1>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if (empty($daftar)): ?>
                <div class="alert alert-info">Belum ada penilaian yang menunggu verifikasi.</div>
            <?php else: ?>
                <div class="card">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama OPD</th>
                                <th>Periode</th>
                                <th>Tanggal Submit</th>
                                <th>Total Skor</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($daftar as $i => $d): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($d['nama_opd']) ?></td>
                                    <td><?= esc($d['tahun_periode']) ?></td>
                                    <td><?= $d['diajukan_pada'] ? date('d M Y H:i', strtotime($d['diajukan_pada'])) : '-' ?></td>
                                    <td><?= number_format($d['total_skor'], 0) ?></td>
                                    <td>
                                        <span class="badge <?= $d['status'] === 'DIKIRIM' ? 'badge-dikirim' : 'badge-verif-ulang' ?>">
                                            <?= esc($d['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('/admin/verifikasi/detail/' . $d['id']) ?>" class="btn btn-primary">Lihat Detail</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <div class="footer">© <?= date('Y') ?> Pemerintah Kota Banjarbaru</div>

</body>
</html>