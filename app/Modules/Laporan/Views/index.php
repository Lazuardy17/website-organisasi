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
        .card { background: #fff; border-radius: 12px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); max-width: 700px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; color: #0d3b66; font-weight: 600; font-size: 14px; margin-bottom: 8px; }
        .form-control { width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; outline: none; background: #fff; }
        .form-control:focus { border-color: #0d3b66; }
        .btn { display: inline-block; padding: 12px 32px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 700; color: #fff; border: none; cursor: pointer; }
        .btn-primary { background: #0d3b66; }
        .btn-primary:hover { background: #145a8a; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .info-box { background: #f0f9ff; border-left: 4px solid #0d3b66; padding: 12px 16px; border-radius: 6px; font-size: 13px; color: #1e40af; margin-top: 20px; }
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
            <h1>Ekspor Laporan</h1>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <div class="card">
                <form action="<?= base_url('/admin/laporan/generate') ?>" method="post" target="_blank">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="periode_id">Periode</label>
                        <select name="periode_id" id="periode_id" class="form-control" required>
                            <option value="">-- Pilih Periode --</option>
                            <?php foreach ($periodeList as $p): ?>
                                <option value="<?= $p['id'] ?>"><?= esc($p['tahun']) ?> - <?= esc($p['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="opd_id">Cakupan OPD</label>
                        <select name="opd_id" id="opd_id" class="form-control">
                            <option value="semua">Semua OPD</option>
                            <?php foreach ($opdList as $o): ?>
                                <option value="<?= $o['id'] ?>"><?= esc($o['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">📄 Buat & Unduh Laporan PDF</button>
                </form>

                <div class="info-box">
                    <strong>ℹ️ Informasi:</strong><br>
                    Laporan berisi data OPD (nama, kepala, NIP, pangkat), 11 variabel penilaian beserta tingkat dan skor,
                    total skor, serta kesimpulan. File PDF akan otomatis terunduh.
                </div>
            </div>
        </main>
    </div>

    <div class="footer">© <?= date('Y') ?> Pemerintah Kota Banjarbaru</div>

</body>
</html>