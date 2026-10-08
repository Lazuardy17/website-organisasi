<?= $this->extend('App\Modules\Shared\Views\Layouts\Layout_admin') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h1>Manajemen Akun OPD</h1>
    <a href="<?= base_url('/admin/akun-opd/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle" style="margin-right: 8px;"></i>Tambah Akun OPD
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success" id="alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error" id="alert-error">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php /* [PAGINATION 1/3] nomor awal halaman ini (halaman 2 mulai dari 11, dst.) */ ?>
<?php $nomorAwal = ($pager->getCurrentPage() - 1) * $pager->getPerPage(); ?>

<div class="card card-wide">
    <div class="table-responsive">
        <table style="table-layout: fixed; width: 100%;">
            <colgroup>
                <col style="width: 4%;">    <!-- No -->
                <col style="width: 22%;">   <!-- Nama OPD -->
                <col style="width: 12%;">   <!-- Username -->
                <col style="width: 16%;">   <!-- NIP -->
                <col style="width: 16%;">   <!-- Kepala PD -->
                <col style="width: 14%;">   <!-- Pangkat/Golongan -->
                <col style="width: 8%;">    <!-- Status -->
                <col style="width: 8%;">    <!-- Aksi -->
            </colgroup>
            <thead>
                <tr>
                    <th style="text-align: center;">No</th>
                    <th style="text-align: center;">Nama OPD</th>
                    <th style="text-align: center;">Username</th>
                    <th style="text-align: center;">NIP</th>
                    <th style="text-align: center;">Kepala PD</th>
                    <th style="text-align: center;">Pangkat/Gol.</th>
                    <th style="text-align: center;">Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($akun)): ?>
                    <tr>
                        <td colspan="8" class="empty-row">
                            Belum ada akun OPD. Klik "Tambah Akun OPD" untuk membuat.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($akun as $i => $a): ?>
                        <tr>
                            <?php /* [PAGINATION 2/3] nomor urut berlanjut antar halaman */ ?>
                            <td style="text-align: center;"><?= $nomorAwal + $i + 1 ?></td>
                            <td class="col-nama"><?= esc($a['nama_opd'] ?? '-') ?></td>
                            <td><code><?= esc($a['nama_pengguna'] ?? '-') ?></code></td>
                            <td style="white-space: nowrap;"><?= esc($a['nip_kepala'] ?? '-') ?></td>
                            <td><?= esc($a['nama_kepala'] ?? '-') ?></td>
                            <td><?= esc($a['pangkat_kepala'] ?? '-') ?></td>
                            <td style="text-align: center;">
                                <span class="badge <?= ($a['status'] ?? '') === 'AKTIF' ? 'badge-terverifikasi' : 'badge-perlu-revisi' ?>">
                                    <?= esc($a['status'] ?? '-') ?>
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?= base_url('/admin/akun-opd/edit/' . $a['id']) ?>" class="btn btn-primary">Edit
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php /* [PAGINATION 3/3] teks "Menampilkan x-y dari z" + tombol halaman */ ?>
    <?= view('App\Modules\Shared\Views\Components\pagination', ['pager' => $pager]) ?>
</div>

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>

<?php if (session()->getFlashdata('akun_baru')): ?>
    <?php $akunBaru = session()->getFlashdata('akun_baru'); ?>
    <div id="popup-akun" style="position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; display:flex; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:16px; padding:40px; max-width:600px; width:90%; text-align:center; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
            <div style="margin-bottom:20px;">
                <i class="bi bi-shield-lock-fill" style="font-size:48px; color:#013D58;"></i>
                <h2 style="color:#013D58; margin-top:12px; font-size:24px;">Akun berhasil dibuat</h2>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; text-align:center; margin:24px 0;">
                <div>
                    <div style="color:#6b7280; font-size:13px; margin-bottom:4px;">Username</div>
                    <div style="color:#013D58; font-size:20px; font-weight:600;" id="popup-username"><?= esc($akunBaru['username']) ?></div>
                </div>
                <div>
                    <div style="color:#6b7280; font-size:13px; margin-bottom:4px;">Password</div>
                    <div style="color:#013D58; font-size:20px; font-weight:600;" id="popup-password"><?= esc($akunBaru['password']) ?></div>
                </div>
            </div>

            <button type="button" onclick="salinInfo()" style="display:inline-flex; align-items:center; gap:8px; padding:10px 20px; background:#fff; color:#013D58; border:1px solid #013D58; border-radius:8px; cursor:pointer; font-weight:600; font-size:14px;">
                <i class="bi bi-clipboard-check"></i> Salin info akun untuk dikirim ke user
            </button>

            <div style="margin-top:24px;">
                <button type="button" onclick="document.getElementById('popup-akun').style.display='none'" style="padding:10px 24px; background:#013D58; color:#fff; border:none; border-radius:8px; cursor:pointer; font-weight:600; font-size:14px;">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
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
<?php endif; ?>

<?= $this->endSection() ?>