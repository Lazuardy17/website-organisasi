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
        .form-control { width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; outline: none; }
        .form-control:focus { border-color: #0d3b66; }
        .input-with-icon { position: relative; }
        .input-with-icon .form-control { padding-right: 50px; }
        .input-with-icon .icon-btn {
            position: absolute; right: 8px; top: 50%; transform: translateY(-50%);
            background: #0d3b66; color: #fff; border: none; border-radius: 6px;
            padding: 6px 10px; cursor: pointer; font-size: 16px;
        }
        .input-with-icon .icon-btn:hover { background: #145a8a; }
        .btn { display: inline-block; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; color: #fff; border: none; cursor: pointer; }
        .btn-primary { background: #0d3b66; }
        .btn-primary:hover { background: #145a8a; }
        .btn-secondary { background: #6b7280; }
        .btn-group { display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
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
            <a href="<?= base_url('/admin/dashboard') ?>">📊 Dashboard</a>
            <div class="section-title">Kelola User</div>
            <a href="<?= base_url('/admin/akun-opd') ?>" class="active">👥 Manajemen Akun OPD</a>
            <div class="section-title">Penilaian</div>
            <a href="<?= base_url('/admin/verifikasi') ?>">📝 Verifikasi Penilaian</a>
            <div class="section-title">Pelaporan</div>
            <a href="#">📈 Rekapitulasi Data</a>
            <a href="#">📥 Ekspor Laporan</a>
            <div class="section-title">Pengaturan</div>
            <a href="<?= base_url('/ubah-password') ?>">🔒 Ubah Password</a>
            <a href="<?= base_url('/logout') ?>" class="logout">Logout</a>
        </aside>

        <main class="content">
            <h1>Edit Akun OPD</h1>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <div class="card">
                <form action="<?= base_url('/admin/akun-opd/update/' . $akun['id']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="nama_pengguna">Username</label>
                        <input type="text" name="nama_pengguna" id="nama_pengguna" class="form-control" value="<?= esc($akun['nama_pengguna']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="nama_opd">Nama OPD</label>
                        <input type="text" name="nama_opd" id="nama_opd" class="form-control" value="<?= esc($akun['nama_opd']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="nip_kepala">NIP</label>
                        <input type="text" name="nip_kepala" id="nip_kepala" class="form-control" value="<?= esc($akun['nip_kepala'] ?? '') ?>" placeholder="Nomor Induk Pegawai">
                    </div>

                    <div class="form-group">
                        <label for="nama_kepala">Kepala OPD</label>
                        <input type="text" name="nama_kepala" id="nama_kepala" class="form-control" value="<?= esc($akun['nama_kepala'] ?? '') ?>" placeholder="Nama lengkap Kepala OPD">
                    </div>

                    <div class="form-group">
                        <label for="pangkat_kepala">Pangkat/Golongan</label>
                        <input type="text" name="pangkat_kepala" id="pangkat_kepala" class="form-control" value="<?= esc($akun['pangkat_kepala'] ?? '') ?>" placeholder="Cth: Pembina / IV a">
                    </div>

                    <div class="form-group">
                        <label for="password">Kata Sandi Baru</label>
                        <div class="input-with-icon">
                            <input type="text" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak ingin ganti" minlength="8">
                            <button type="button" class="icon-btn" id="btn-dadu" title="Generate password random">🎲</button>
                        </div>
                        <small style="color:#6b7280; font-size:12px; display:block; margin-top:6px;">Minimal 8 karakter. Kosongkan jika tidak ingin ganti kata sandi.</small>
                    </div>

                    <div class="form-group">
                        <label for="konfirmasi">Konfirmasi Kata Sandi</label>
                        <input type="text" name="konfirmasi" id="konfirmasi" class="form-control" placeholder="Ulangi kata sandi" minlength="8">
                    </div>

                    <div class="btn-group">
                        <a href="<?= base_url('/admin/akun-opd') ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <div class="footer">© <?= date('Y') ?> Pemerintah Kota Banjarbaru</div>

    <script>
        document.getElementById('btn-dadu').addEventListener('click', function () {
            const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let pass = '';
            for (let i = 0; i < 8; i++) {
                pass += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById('password').value = pass;
            document.getElementById('konfirmasi').value = pass;
        });
    </script>

</body>
</html>