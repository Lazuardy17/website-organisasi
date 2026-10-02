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
        .content h1 { color: #0d3b66; font-size: 24px; margin-bottom: 8px; }
        .content .subtitle { color: #6b7280; font-size: 14px; margin-bottom: 24px; }
        .card { background: #fff; border-radius: 12px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); max-width: 600px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; color: #0d3b66; font-weight: 600; font-size: 14px; margin-bottom: 8px; }
        .form-control { width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; outline: none; }
        .form-control:focus { border-color: #0d3b66; }
        .btn { display: inline-block; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; color: #fff; border: none; cursor: pointer; }
        .btn-primary { background: #0d3b66; }
        .btn-primary:hover { background: #145a8a; }
        .btn-secondary { background: #6b7280; }
        .btn-group { display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }

        /* Icon toggle password */
        .input-with-icon { position: relative; }
        .input-with-icon .form-control { padding-right: 45px; }
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            opacity: 0.6;
        }
        .toggle-password:hover { opacity: 1; }
        .toggle-password.aktif svg { stroke: #dc2626; }

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

            <?php if (session()->get('peran_id') == 1): ?>
                <a href="<?= base_url('/admin/dashboard') ?>">📊 Dashboard</a>
                <div class="section-title">Kelola User</div>
                <a href="<?= base_url('/admin/akun-opd') ?>">👥 Manajemen Akun OPD</a>
                <div class="section-title">Penilaian</div>
                <a href="<?= base_url('/admin/verifikasi') ?>">📝 Verifikasi Penilaian</a>
                <div class="section-title">Pelaporan</div>
                <a href="<?= base_url('/admin/rekapitulasi') ?>">📈 Rekapitulasi Data</a>
                <a href="#">📥 Ekspor Laporan</a>
            <?php else: ?>
                <a href="<?= base_url('/opd/dashboard') ?>">📊 Dashboard</a>
                <div class="section-title">Akun & Evaluasi</div>
                <a href="<?= base_url('/opd/akun') ?>">👤 Akun</a>
                <a href="#">📋 Pengisian Variabel</a>
                <div class="section-title">Pelaporan</div>
                <a href="#">📁 Kesimpulan</a>
            <?php endif; ?>

            <div class="section-title">Pengaturan</div>
            <a href="<?= base_url('/ubah-password') ?>" class="active">🔒 Ubah Password</a>

            <a href="<?= base_url('/logout') ?>" class="logout">Logout</a>
        </aside>

        <main class="content">
            <h1>Ganti Password Akun</h1>
            <p class="subtitle">Isi form berikut untuk mengganti password akun anda.</p>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <div class="card">
                <form action="<?= base_url('/ubah-password/simpan') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="password_lama">Password Lama</label>
                        <div class="input-with-icon">
                            <input type="password" name="password_lama" id="password_lama" class="form-control" placeholder="Masukkan password lama" required>
                            <button type="button" class="toggle-password" onclick="togglePassword('password_lama', this)" title="Lihat password">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0d3b66" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_baru">Password Baru</label>
                        <div class="input-with-icon">
                            <input type="password" name="password_baru" id="password_baru" class="form-control" placeholder="Minimal 8 karakter" required minlength="8">
                            <button type="button" class="toggle-password" onclick="togglePassword('password_baru', this)" title="Lihat password">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0d3b66" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="konfirmasi">Konfirmasi Password</label>
                        <div class="input-with-icon">
                            <input type="password" name="konfirmasi" id="konfirmasi" class="form-control" placeholder="Ulangi password baru" required minlength="8">
                            <button type="button" class="toggle-password" onclick="togglePassword('konfirmasi', this)" title="Lihat password">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0d3b66" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="btn-group">
                        <a href="<?= session()->get('peran_id') == 1 ? base_url('/admin/dashboard') : base_url('/opd/dashboard') ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <div class="footer">© <?= date('Y') ?> Pemerintah Kota Banjarbaru</div>

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                button.classList.add('aktif');
                button.title = 'Sembunyikan password';
            } else {
                input.type = 'password';
                button.classList.remove('aktif');
                button.title = 'Lihat password';
            }
        }
    </script>

</body>
</html>