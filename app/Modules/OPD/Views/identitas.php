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
        .sidebar a.disabled {
            color: #6b7280 !important;
            cursor: not-allowed;
            opacity: 0.5;
        }
        .sidebar a.disabled:hover {
            background: transparent;
            border-left: none;
        }
        .sidebar .logout { margin: 20px; padding: 10px 20px; border: 1px solid #fff; border-radius: 8px; text-align: center; font-weight: 600; }
        .content { flex: 1; padding: 24px 32px; }
        .content h1 { color: #0d3b66; font-size: 24px; text-align: center; margin-bottom: 8px; }
        .content .subtitle { color: #3b82f6; text-align: center; font-size: 14px; margin-bottom: 32px; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; max-width: 700px; margin-left: auto; margin-right: auto; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .alert-info { background: #fef3c7; color: #92400e; border: 1px solid #fbbf24; text-align: center; }
        .card { background: #fff; border-radius: 12px; padding: 40px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); max-width: 700px; margin: 0 auto; }
        .form-group { margin-bottom: 24px; }
        .form-group label { display: block; color: #0d3b66; font-weight: 700; font-size: 18px; margin-bottom: 8px; }
        .form-control { width: 100%; padding: 12px 16px; border: 2px solid #fbbf24; border-radius: 24px; font-size: 14px; outline: none; }
        .form-control:focus { border-color: #0d3b66; }
        .form-control[readonly] { background: #f3f4f6; border-color: #d1d5db; cursor: not-allowed; }
        .btn { display: inline-block; padding: 12px 48px; border-radius: 8px; text-decoration: none; font-size: 16px; font-weight: 700; color: #fff; border: none; cursor: pointer; }
        .btn-primary { background: #0d3b66; }
        .btn-primary:hover { background: #145a8a; }
        .btn-group { text-align: center; margin-top: 32px; }
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

            <!-- Menu yang dikunci (belum bisa diakses) -->
            <a href="#" class="disabled" onclick="return false;">📊 Dashboard</a>

            <div class="section-title">Akun & Evaluasi</div>
            <a href="#" class="disabled" onclick="return false;">👤 Akun</a>
            <a href="#" class="disabled" onclick="return false;">📋 Pengisian Variabel</a>

            <div class="section-title">Pelaporan</div>
            <a href="#" class="disabled" onclick="return false;">📁 Kesimpulan</a>

            <div class="section-title">Pengaturan</div>
            <a href="#" class="disabled" onclick="return false;">🔒 Ubah Password</a>

            <a href="<?= base_url('/logout') ?>" class="logout">Logout</a>
        </aside>

        <main class="content">
            <div class="alert alert-info">
                🔔 Silahkan mengisi Form Evaluasi Kematangan Kelembagaan terlebih dahulu!
            </div>

            <h1>Evaluasi Kematangan Kelembagaan</h1>
            <p class="subtitle">Sesuai Peraturan Menteri Dalam Negeri Nomor: 99 Tahun 2018</p>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <div class="card">
                <form action="<?= base_url('/opd/identitas/simpan') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label>PD</label>
                        <input type="text" class="form-control" value="<?= esc($opd['nama']) ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="nama_kepala">Kepala PD</label>
                        <input type="text" name="nama_kepala" id="nama_kepala" class="form-control" placeholder="Nama Kepala Perangkat Daerah" value="<?= esc($opd['nama_kepala'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="pangkat_kepala">Pangkat/Golongan</label>
                        <input type="text" name="pangkat_kepala" id="pangkat_kepala" class="form-control" placeholder="Cth: Pembina / IV a" value="<?= esc($opd['pangkat_kepala'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="nip_kepala">NIP</label>
                        <input type="text" name="nip_kepala" id="nip_kepala" class="form-control" placeholder="Nomor Induk Pegawai" value="<?= esc($opd['nip_kepala'] ?? '') ?>" required>
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">Masuk</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <div class="footer">© <?= date('Y') ?> Pemerintah Kota Banjarbaru</div>

</body>
</html>