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
        .content h1 { color: #0d3b66; font-size: 22px; margin-bottom: 8px; }
        .content .subtitle { color: #6b7280; font-size: 14px; margin-bottom: 24px; line-height: 1.6; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }

        .progress-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
        .progress-row strong { color: #0d3b66; font-size: 20px; }
        .progress-row span { color: #0d3b66; font-weight: 700; font-size: 18px; }
        .progress-bar { background: #e5e7eb; height: 8px; border-radius: 4px; overflow: hidden; margin-bottom: 24px; }
        .progress-bar .fill { background: #0d3b66; height: 100%; border-radius: 4px; transition: width 0.3s; }

        .tabs { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px; }
        .tab-btn {
            padding: 8px 20px; border: 1px solid #d1d5db; border-radius: 24px;
            background: #fff; color: #374151; font-size: 14px; cursor: pointer;
            display: flex; align-items: center; gap: 6px;
        }
        .tab-btn:hover { border-color: #0d3b66; }
        .tab-btn.active { background: #0d3b66; color: #fff; border-color: #0d3b66; }
        .tab-btn .dot {
            width: 14px; height: 14px; border: 2px solid #d1d5db; border-radius: 50%;
            display: inline-block; background: #fff;
        }
        .tab-btn.active .dot { border-color: #fbbf24; }
        .tab-btn.terisi .dot { background: #16a34a; border-color: #16a34a; }

        .action-row { display: flex; justify-content: flex-end; gap: 12px; margin-bottom: 24px; }
        .btn { display: inline-block; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; color: #fff; border: none; cursor: pointer; }
        .btn-primary { background: #0d3b66; }
        .btn-primary:hover { background: #145a8a; }
        .btn-outline { background: #fff; color: #0d3b66; border: 1px solid #0d3b66; }
        .btn-outline:hover { background: #f0f4f8; }

        .tingkat-card {
            background: #fff; border: 2px solid #e5e7eb; border-radius: 12px;
            padding: 20px; margin-bottom: 12px; cursor: pointer; transition: all 0.2s;
        }
        .tingkat-card:hover { border-color: #93c5fd; }
        .tingkat-card.selected { border-color: #0d3b66; background: #f0f7ff; }
        .tingkat-header { display: flex; align-items: flex-start; gap: 12px; }
        .tingkat-header input[type="radio"] { margin-top: 4px; width: 18px; height: 18px; cursor: pointer; }
        .tingkat-body { flex: 1; }
        .tingkat-title { color: #0d3b66; font-weight: 700; font-size: 16px; margin-bottom: 6px; }
        .tingkat-indikator { color: #374151; font-size: 14px; line-height: 1.6; margin-bottom: 10px; }
        .tingkat-verifikasi {
            border-top: 1px solid #e5e7eb; padding-top: 10px;
            font-size: 13px; color: #6b7280; font-style: italic;
        }
        .tingkat-verifikasi strong { color: #9ca3af; font-weight: 600; display: block; margin-bottom: 4px; font-style: normal; }
        .bukti-field {
            margin-top: 12px; padding: 12px; border: 1px dashed #93c5fd;
            border-radius: 8px; background: #f9fafb;
        }
        .bukti-field label { display: block; font-size: 13px; color: #0d3b66; font-weight: 600; margin-bottom: 6px; }
        .bukti-field input {
            width: 100%; padding: 10px 14px; border: 1px solid #d1d5db;
            border-radius: 8px; font-size: 14px; outline: none;
        }
        .bukti-field input:focus { border-color: #0d3b66; }

        .variabel-panel { display: none; }
        .variabel-panel.active { display: block; }
        .variabel-title { color: #0d3b66; font-size: 18px; font-weight: 700; margin-bottom: 16px; }
        .simpan-row { display: flex; justify-content: flex-end; margin-top: 20px; }

        .catatan-revisi-box {
            background: #fef3c7; border-left: 4px solid #f59e0b;
            padding: 12px 16px; border-radius: 8px; margin-bottom: 16px;
        }
        .catatan-revisi-box strong { color: #92400e; display: block; margin-bottom: 4px; }
        .catatan-revisi-box span { color: #78350f; font-size: 14px; }

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
            <a href="<?= base_url('/opd/akun') ?>">👤 Akun</a>
            <a href="<?= base_url('/opd/penilaian') ?>" class="active">📋 Pengisian Variabel</a>
            <div class="section-title">Pelaporan</div>
            <a href="<?= base_url('/opd/kesimpulan') ?>">📁 Kesimpulan</a>
            <div class="section-title">Pengaturan</div>
            <a href="<?= base_url('/ubah-password') ?>">🔒 Ubah Password</a>
            <a href="<?= base_url('/logout') ?>" class="logout">Logout</a>
        </aside>

        <main class="content">
            <h1>Penilaian Kematangan Kelembagaan</h1>
            <p class="subtitle">
                Penilaian kematangan dilakukan terhadap 11 variabel/indikator organisasi.<br>
                Bukti penilaiannya dapat berupa dokumen kebijakan, dokumen pelaksanaan tugas dan fungsi,
                laporan/evaluasi, hasil observasi, dan wawancara.
            </p>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if ($penilaian['status'] === 'PERLU_REVISI'): ?>
                <div class="alert" style="background:#fef3c7; color:#92400e; border-left:4px solid #f59e0b;">
                    ⚠️ <strong>Penilaian Anda sedang dalam status PERLU REVISI.</strong> Silakan perbaiki variabel yang ditandai, lalu submit ulang.
                </div>
            <?php endif; ?>

            <div class="progress-row">
                <strong>Progress Pengisian</strong>
                <span><?= $terisi ?>/<?= $totalVariabel ?></span>
            </div>
            <div class="progress-bar">
                <div class="fill" style="width: <?= ($terisi / $totalVariabel) * 100 ?>%;"></div>
            </div>

            <div class="tabs">
                <?php foreach ($variabel as $i => $v): ?>
                    <?php
                        $isAktif = ($tabAktif && $v['id'] == $tabAktif) || (!$tabAktif && $i === 0);
                        $punyaCatatan = !empty($v['catatan_revisi']);
                    ?>
                    <button type="button" 
                            class="tab-btn <?= $isAktif ? 'active' : '' ?> <?= $v['tingkat_id_terpilih'] ? 'terisi' : '' ?>"
                            style="<?= $punyaCatatan ? 'border-color: #f59e0b;' : '' ?>"
                            data-target="variabel-<?= $v['id'] ?>">
                        <span class="dot" style="<?= $punyaCatatan ? 'background: #f59e0b; border-color: #f59e0b;' : '' ?>"></span> 
                        Variabel <?= $v['nomor_urutan'] ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <div class="action-row">
                <a href="<?= base_url('/opd/penilaian') ?>" class="btn btn-primary">Simpan Draft</a>
                <a href="<?= base_url('/opd/kesimpulan') ?>" class="btn btn-outline">Kesimpulan</a>
            </div>

            <?php foreach ($variabel as $i => $v): ?>
                <?php $isAktif = ($tabAktif && $v['id'] == $tabAktif) || (!$tabAktif && $i === 0); ?>
                <div class="variabel-panel <?= $isAktif ? 'active' : '' ?>" id="variabel-<?= $v['id'] ?>">
                    <h2 class="variabel-title"><?= esc($v['nama']) ?></h2>

                    <?php if (!empty($v['catatan_revisi'])): ?>
                        <?php foreach ($v['catatan_revisi'] as $cr): ?>
                            <div class="catatan-revisi-box">
                                <strong>⚠️ Catatan Revisi dari Admin:</strong>
                                <span><?= esc($cr['catatan']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <form action="<?= base_url('/opd/penilaian/simpan/' . $v['id']) ?>" method="post">
                        <?= csrf_field() ?>

                        <?php foreach ($v['tingkat'] as $t): ?>
                            <?php $terpilih = ($v['tingkat_id_terpilih'] == $t['id']); ?>
                            <label class="tingkat-card <?= $terpilih ? 'selected' : '' ?>" style="display: block;">
                                <div class="tingkat-header">
                                    <input type="radio" 
                                           name="tingkat_id" 
                                           value="<?= $t['id'] ?>"
                                           data-target="bukti-<?= $t['id'] ?>"
                                           <?= $terpilih ? 'checked' : '' ?>
                                           onchange="pilihTingkat(this, '<?= $v['id'] ?>')">
                                    <div class="tingkat-body">
                                        <div class="tingkat-title"><?= esc($t['nama_tingkat']) ?></div>
                                        <div class="tingkat-indikator"><?= esc($t['indikator']) ?></div>
                                        <div class="tingkat-verifikasi">
                                            <strong>Verifikasi Bukti</strong>
                                            <?= esc($t['verifikasi_bukti'] ?? '-') ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bukti-field" id="bukti-<?= $t['id'] ?>" style="display: <?= $terpilih ? 'block' : 'none' ?>;">
                                    <label>🔗 Link Bukti</label>
                                    <input type="text" 
                                           name="tautan_bukti" 
                                           placeholder="https://drive.google.com/..."
                                           value="<?= $terpilih ? esc($v['tautan_bukti']) : '' ?>">
                                </div>
                            </label>
                        <?php endforeach; ?>

                        <div class="simpan-row">
                            <button type="submit" class="btn btn-primary">Simpan Variabel Ini</button>
                        </div>
                    </form>
                </div>
            <?php endforeach; ?>

        </main>
    </div>

    <div class="footer">© <?= date('Y') ?> Pemerintah Kota Banjarbaru</div>

    <script>
        document.querySelectorAll('.tab-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.variabel-panel').forEach(p => p.classList.remove('active'));
                
                btn.classList.add('active');
                document.getElementById(btn.dataset.target).classList.add('active');
                window.scrollTo({ top: 200, behavior: 'smooth' });
            });
        });

        function pilihTingkat(radio, variabelId) {
            document.querySelectorAll('#variabel-' + variabelId + ' .bukti-field').forEach(function (el) {
                el.style.display = 'none';
            });
            document.querySelectorAll('#variabel-' + variabelId + ' .tingkat-card').forEach(function (el) {
                el.classList.remove('selected');
            });

            const targetId = radio.dataset.target;
            document.getElementById(targetId).style.display = 'block';
            radio.closest('.tingkat-card').classList.add('selected');
        }

        document.addEventListener('DOMContentLoaded', function () {
            const activeBtn = document.querySelector('.tab-btn.active');
            if (activeBtn) {
                activeBtn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
        });
    </script>

</body>
</html>