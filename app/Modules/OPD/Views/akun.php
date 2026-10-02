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
        .card { background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .card h2 { color: #0d3b66; font-size: 18px; margin-bottom: 16px; }
        .opd-header { display: flex; justify-content: space-between; align-items: center; }
        .opd-name { display: flex; align-items: center; gap: 16px; }
        .opd-icon { width: 60px; height: 60px; background: #dbeafe; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 28px; }
        .opd-name-text { color: #0d3b66; font-size: 20px; font-weight: 700; }
        .badge-aktif { background: #0d3b66; color: #fff; padding: 8px 20px; border-radius: 20px; font-size: 13px; font-weight: 600; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; color: #0d3b66; font-weight: 600; font-size: 14px; margin-bottom: 6px; }
        .form-control { width: 100%; padding: 10px 14px; border: 1px solid #fbbf24; border-radius: 8px; font-size: 14px; outline: none; }
        .form-control:focus { border-color: #0d3b66; }
        .btn { display: inline-block; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; color: #fff; border: none; cursor: pointer; }
        .btn-primary { background: #0d3b66; }
        .btn-primary:hover { background: #145a8a; }
        .btn-group { display: flex; justify-content: flex-end; gap: 12px; margin-top: 12px; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }
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
            <a href="<?= base_url('/opd/akun') ?>" class="active">👤 Akun</a>
            <a href="<?= base_url('/opd/penilaian') ?>">📋 Pengisian Variabel</a>
            <div class="section-title">Pelaporan</div>
            <a href="<?= base_url('/opd/kesimpulan') ?>">📁 Kesimpulan</a>
            <div class="section-title">Pengaturan</div>
            <a href="<?= base_url('/ubah-password') ?>">🔒 Ubah Password</a>
            <a href="<?= base_url('/logout') ?>" class="logout">Logout</a>
        </aside>

        <main class="content">
            <h1>Akun Perangkat Daerah</h1>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <!-- Card Identitas -->
            <div class="card">
                <div class="opd-header">
                    <div class="opd-name">
                        <div class="opd-icon">🏛️</div>
                        <div class="opd-name-text"><?= esc($opd['nama']) ?></div>
                    </div>
                    <span class="badge-aktif"><?= esc($opd['status']) ?></span>
                </div>
            </div>

            <!-- Card Data Akun -->
            <div class="card">
                <h2>Data Akun & Perangkat Daerah</h2>

                <form action="<?= base_url('/opd/akun/update') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="nip_kepala">NIP</label>
                        <input type="text" name="nip_kepala" id="nip_kepala" class="form-control" value="<?= esc($opd['nip_kepala'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="nama">Perangkat Daerah</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="<?= esc($opd['nama']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="nama_kepala">Kepala PD</label>
                        <input type="text" name="nama_kepala" id="nama_kepala" class="form-control" value="<?= esc($opd['nama_kepala'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="pangkat_kepala">Pangkat/Golongan</label>
                        <input type="text" name="pangkat_kepala" id="pangkat_kepala" class="form-control" value="<?= esc($opd['pangkat_kepala'] ?? '') ?>" placeholder="Cth: Pembina / IV a" required>
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <div class="footer">© <?= date('Y') ?> Pemerintah Kota Banjarbaru</div>

</body>
</html>