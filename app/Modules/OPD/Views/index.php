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
        .btn { display: inline-block; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; color: #fff; border: none; cursor: pointer; }
        .btn-primary { background: #0d3b66; }
        .btn-primary:hover { background: #145a8a; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th { color: #0d3b66; text-align: left; padding: 12px 8px; border-bottom: 2px solid #e5e7eb; font-size: 14px; vertical-align: top; }
        td { padding: 12px 8px; border-bottom: 1px solid #e5e7eb; font-size: 14px; vertical-align: top; word-wrap: break-word; white-space: normal; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .badge-aktif { background: #dcfce7; color: #166534; }
        .badge-inaktif { background: #fee2e2; color: #991b1b; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; position: relative; cursor: pointer; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .alert .close-btn { position: absolute; top: 8px; right: 12px; font-size: 18px; font-weight: 700; opacity: 0.5; cursor: pointer; }
        .alert .close-btn:hover { opacity: 1; }
        .header-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
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
            <a href="<?= base_url('/admin/rekapitulasi') ?>">📈 Rekapitulasi Data</a>
            <a href="<?= base_url('/admin/laporan') ?>">📥 Ekspor Laporan</a>
            <div class="section-title">Pengaturan</div>
            <a href="<?= base_url('/ubah-password') ?>">🔒 Ubah Password</a>
            <a href="<?= base_url('/logout') ?>" class="logout">Logout</a>
        </aside>

        <main class="content">
            <div class="header-row">
                <h1>Manajemen Akun OPD</h1>
                <a href="<?= base_url('/admin/akun-opd/create') ?>" class="btn btn-primary">+ Tambah Akun OPD</a>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success" id="alert-success" onclick="tutupAlert('alert-success')">
                    <?= session()->getFlashdata('success') ?>
                    <span class="close-btn">&times;</span>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error" id="alert-error" onclick="tutupAlert('alert-error')">
                    <?= session()->getFlashdata('error') ?>
                    <span class="close-btn">&times;</span>
                </div>
            <?php endif; ?>

            <div class="card" style="overflow-x: auto;">
                <table style="table-layout: fixed; width: 100%;">
                    <colgroup>
                        <col style="width: 22%;">   <!-- Nama OPD -->
                        <col style="width: 12%;">   <!-- Username -->
                        <col style="width: 18%;">   <!-- NIP -->
                        <col style="width: 14%;">   <!-- Kepala PD -->
                        <col style="width: 12%;">   <!-- Pangkat/Golongan -->
                        <col style="width: 8%;">   <!-- Password -->
                        <col style="width: 7%;">   <!-- Status -->
                        <col style="width: 7%;">    <!-- Aksi -->
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Nama OPD</th>
                            <th>Username</th>
                            <th>NIP</th>
                            <th>Kepala PD</th>
                            <th>Pangkat/Gol.</th>
                            <th>Password</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($akun)): ?>
                            <tr><td colspan="8" style="text-align:center; color:#6b7280;">Belum ada akun OPD.</td></tr>
                        <?php else: ?>
                            <?php foreach ($akun as $a): ?>
                                <tr>
                                    <td><?= esc($a['nama_opd']) ?></td>
                                    <td><?= esc($a['nama_pengguna']) ?></td>
                                    <td><?= esc($a['nip_kepala'] ?? '') ?></td>
                                    <td><?= esc($a['nama_kepala'] ?? '') ?></td>
                                    <td><?= esc($a['pangkat_kepala'] ?? '') ?></td>
                                    <td>••••••••</td>
                                    <td>
                                        <span class="badge <?= $a['status'] === 'AKTIF' ? 'badge-aktif' : 'badge-inaktif' ?>">
                                            <?= esc($a['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('/admin/akun-opd/edit/' . $a['id']) ?>" class="btn btn-primary btn-sm">Edit</a>
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

    <?php if (session()->getFlashdata('akun_baru')): ?>
        <?php $akunBaru = session()->getFlashdata('akun_baru'); ?>
        <div id="popup-akun" style="position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; display:flex; align-items:center; justify-content:center;">
            <div style="background:#fff; border-radius:16px; padding:40px; max-width:600px; width:90%; text-align:center; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
                <div style="margin-bottom:20px;">
                    <span style="font-size:32px;">🔐</span>
                    <h2 style="color:#0d3b66; margin-top:12px; font-size:24px;">Akun berhasil dibuat</h2>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; text-align:left; margin:24px 0;">
                    <div>
                        <div style="color:#6b7280; font-size:13px; margin-bottom:4px;">Username</div>
                        <div style="color:#0d3b66; font-size:20px; font-weight:600;" id="popup-username"><?= esc($akunBaru['username']) ?></div>
                    </div>
                    <div>
                        <div style="color:#6b7280; font-size:13px; margin-bottom:4px;">Password sementara</div>
                        <div style="color:#0d3b66; font-size:20px; font-weight:600;" id="popup-password"><?= esc($akunBaru['password']) ?></div>
                    </div>
                </div>

                <button type="button" onclick="salinInfo()" style="display:inline-flex; align-items:center; gap:8px; padding:10px 20px; background:#fff; color:#0d3b66; border:1px solid #0d3b66; border-radius:8px; cursor:pointer; font-weight:600; font-size:14px;">
                    📋 Salin info akun untuk dikirim ke user
                </button>

                <div style="margin-top:24px;">
                    <button type="button" onclick="document.getElementById('popup-akun').style.display='none'" style="padding:10px 24px; background:#0d3b66; color:#fff; border:none; border-radius:8px; cursor:pointer; font-weight:600; font-size:14px;">Tutup</button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script>
        function tutupAlert(id) {
            const el = document.getElementById(id);
            if (el) el.remove();
        }

        ['alert-success', 'alert-error'].forEach(function (id) {
            const el = document.getElementById(id);
            if (el) {
                setTimeout(function () { el.remove(); }, 4000);
            }
        });

        function salinInfo() {
            const username = document.getElementById('popup-username').textContent.trim();
            const password = document.getElementById('popup-password').textContent.trim();
            const teks = 'Username: ' + username + '\nPassword: ' + password;

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(teks).then(function () {
                    tampilkanNotif('Info akun berhasil disalin!');
                }).catch(function () {
                    salinFallback(teks);
                });
            } else {
                salinFallback(teks);
            }
        }

        function salinFallback(teks) {
            const textarea = document.createElement('textarea');
            textarea.value = teks;
            textarea.style.position = 'fixed';
            textarea.style.left = '-9999px';
            document.body.appendChild(textarea);
            textarea.select();
            textarea.setSelectionRange(0, 99999);

            try {
                const berhasil = document.execCommand('copy');
                if (berhasil) {
                    tampilkanNotif('Info akun berhasil disalin!');
                } else {
                    alert('Gagal menyalin. Silakan salin manual:\n\n' + teks);
                }
            } catch (err) {
                alert('Gagal menyalin. Silakan salin manual:\n\n' + teks);
            }

            document.body.removeChild(textarea);
        }

        function tampilkanNotif(pesan) {
            const notif = document.createElement('div');
            notif.textContent = pesan;
            notif.style.position = 'fixed';
            notif.style.top = '20px';
            notif.style.right = '20px';
            notif.style.background = '#dcfce7';
            notif.style.color = '#166534';
            notif.style.padding = '12px 20px';
            notif.style.borderRadius = '8px';
            notif.style.fontWeight = '600';
            notif.style.fontSize = '14px';
            notif.style.zIndex = '10000';
            notif.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
            notif.style.cursor = 'pointer';
            notif.title = 'Klik untuk tutup';

            notif.addEventListener('click', function () { notif.remove(); });
            document.body.appendChild(notif);

            setTimeout(function () {
                if (notif.parentNode) notif.remove();
            }, 2500);
        }
    </script>

</body>
</html>