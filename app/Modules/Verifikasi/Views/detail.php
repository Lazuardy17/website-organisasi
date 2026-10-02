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
        .header-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .content h1 { color: #0d3b66; font-size: 24px; }
        .card { background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px; }
        .info-item label { color: #6b7280; font-size: 12px; display: block; margin-bottom: 4px; }
        .info-item span { color: #0d3b66; font-size: 15px; font-weight: 600; }
        .section-title { color: #0d3b66; font-size: 16px; font-weight: 700; margin-bottom: 16px; }
        .variabel-item { border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; margin-bottom: 12px; }
        .variabel-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
        .variabel-name { color: #0d3b66; font-weight: 700; font-size: 15px; }
        .variabel-tingkat { background: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .variabel-skor { color: #16a34a; font-weight: 700; font-size: 15px; }
        .variabel-indikator { color: #374151; font-size: 14px; line-height: 1.6; margin-bottom: 10px; }
        .variabel-bukti { background: #f0f9ff; padding: 10px; border-radius: 6px; font-size: 13px; border-left: 3px solid #0d3b66; }
        .variabel-bukti a { color: #0d3b66; text-decoration: none; word-break: break-all; }
        .catatan-lama { background: #fef3c7; padding: 8px 12px; border-radius: 6px; font-size: 13px; color: #92400e; margin-top: 8px; border-left: 3px solid #f59e0b; }
        textarea { width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 13px; font-family: inherit; outline: none; resize: vertical; min-height: 60px; }
        textarea:focus { border-color: #0d3b66; }
        .btn { display: inline-block; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; color: #fff; border: none; cursor: pointer; }
        .btn-primary { background: #0d3b66; }
        .btn-success { background: #16a34a; }
        .btn-success:hover { background: #15803d; }
        .btn-warning { background: #f59e0b; }
        .btn-warning:hover { background: #d97706; }
        .btn-secondary { background: #6b7280; }
        .action-row { display: flex; justify-content: space-between; gap: 12px; margin-top: 16px; }
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
            <a href="<?= base_url('/admin/akun-opd') ?>">👥 Manajemen Akun OPD</a>
            <div class="section-title">Penilaian</div>
            <a href="<?= base_url('/admin/verifikasi') ?>" class="active">📝 Verifikasi Penilaian</a>
            <div class="section-title">Pelaporan</div>
            <a href="<?= base_url('/admin/rekapitulasi') ?>">📈 Rekapitulasi Data</a>
            <a href="<?= base_url('/admin/laporan') ?>">📥 Ekspor Laporan</a>
            <div class="section-title">Pengaturan</div>
            <a href="<?= base_url('/ubah-password') ?>">🔒 Ubah Password</a>
            <a href="<?= base_url('/logout') ?>" class="logout">Logout</a>
        </aside>

        <main class="content">
            <div class="header-row">
                <h1>Detail Verifikasi</h1>
                <a href="<?= base_url('/admin/verifikasi') ?>" class="btn btn-secondary">← Kembali</a>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="section-title">Informasi OPD</div>
                <div class="info-grid">
                    <div class="info-item"><label>Nama OPD</label><span><?= esc($penilaian['nama_opd']) ?></span></div>
                    <div class="info-item"><label>Periode</label><span>Tahun <?= esc($penilaian['tahun_periode']) ?></span></div>
                    <div class="info-item"><label>Kepala OPD</label><span><?= esc($penilaian['nama_kepala'] ?? '-') ?></span></div>
                    <div class="info-item"><label>NIP</label><span><?= esc($penilaian['nip_kepala'] ?? '-') ?></span></div>
                    <div class="info-item"><label>Pangkat/Golongan</label><span><?= esc($penilaian['pangkat_kepala'] ?? '-') ?></span></div>
                    <div class="info-item"><label>Total Skor</label><span style="color: #16a34a;"><?= number_format($penilaian['total_skor'], 0) ?></span></div>
                </div>
            </div>

            <div class="card">
                <div class="section-title">Rincian Penilaian (<?= count($detail) ?>/11 variabel)</div>

                <?php foreach ($detail as $d): ?>
                    <div class="variabel-item">
                        <div class="variabel-header">
                            <div>
                                <span class="variabel-name"><?= esc($d['nama_variabel']) ?></span>
                                <span class="variabel-tingkat"><?= esc($d['nama_tingkat']) ?></span>
                            </div>
                            <span class="variabel-skor">Skor: <?= number_format($d['nilai_skor'], 0) ?></span>
                        </div>

                        <div class="variabel-indikator"><?= esc($d['indikator']) ?></div>

                        <div class="variabel-bukti">
                            🔗 <strong>Bukti:</strong> 
                            <a href="<?= esc($d['tautan_bukti']) ?>" target="_blank"><?= esc($d['tautan_bukti']) ?></a>
                        </div>

                        <?php if (!empty($d['catatan_revisi'])): ?>
                            <?php foreach ($d['catatan_revisi'] as $cr): ?>
                                <div class="catatan-lama">
                                    ⚠️ <strong>Catatan Sebelumnya:</strong> <?= esc($cr['catatan']) ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <div style="margin-top: 10px;">
                            <label style="font-size: 12px; color: #6b7280; display: block; margin-bottom: 4px;">
                                Catatan untuk variabel ini (opsional):
                            </label>
                            <textarea 
                                class="catatan-per-variabel" 
                                data-detail-id="<?= $d['id'] ?>"
                                placeholder="Tulis catatan kalau ada yang perlu diperbaiki..."></textarea>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="card">
                <div class="section-title">Aksi Verifikasi</div>

                <!-- Verifikasi -->
                <form action="<?= base_url('/admin/verifikasi/verifikasi/' . $penilaian['id']) ?>" method="post" style="margin-bottom: 20px;">
                    <?= csrf_field() ?>
                    <label style="font-size: 13px; color: #6b7280; display: block; margin-bottom: 6px;">Catatan (opsional):</label>
                    <textarea name="catatan" placeholder="Catatan tambahan (opsional)..."></textarea>
                    <div class="action-row">
                        <div></div>
                        <button type="submit" class="btn btn-success" onclick="return confirm('Yakin verifikasi penilaian ini?')">
                            ✓ Verifikasi & Setujui
                        </button>
                    </div>
                </form>

                <hr style="margin: 20px 0; border: none; border-top: 1px solid #e5e7eb;">

                <!-- Revisi -->
                <form action="<?= base_url('/admin/verifikasi/revisi/' . $penilaian['id']) ?>" method="post" id="form-revisi">
                    <?= csrf_field() ?>
                    <label style="font-size: 13px; color: #6b7280; display: block; margin-bottom: 6px;">Catatan Revisi (wajib):</label>
                    <textarea name="catatan" placeholder="Jelaskan apa yang perlu diperbaiki oleh OPD..." required></textarea>

                    <!-- Container untuk catatan per variabel (diisi JavaScript) -->
                    <div id="catatan-detail-container"></div>

                    <div class="action-row">
                        <div></div>
                        <button type="submit" class="btn btn-warning" onclick="return confirm('Kembalikan penilaian untuk direvisi?')">
                            ⚠ Minta Revisi
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <div class="footer">© <?= date('Y') ?> Pemerintah Kota Banjarbaru</div>

    <script>
        // Sebelum form revisi disubmit, kumpulkan catatan per variabel
        document.getElementById('form-revisi').addEventListener('submit', function (e) {
            const container = document.getElementById('catatan-detail-container');
            container.innerHTML = ''; // bersihkan dulu

            document.querySelectorAll('.catatan-per-variabel').forEach(function (textarea) {
                const catatan = textarea.value.trim();
                const detailId = textarea.dataset.detailId;

                if (catatan !== '') {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'catatan_detail[' + detailId + ']';
                    input.value = catatan;
                    container.appendChild(input);
                }
            });
        });
    </script>

</body>
</html>