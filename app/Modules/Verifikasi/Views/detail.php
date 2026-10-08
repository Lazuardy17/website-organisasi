<?= $this->extend('App\Modules\Shared\Views\Layouts\Layout_admin') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h1>Detail Verifikasi</h1>
    <a href="<?= base_url('/admin/verifikasi') ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left" style="margin-right: 8px;"></i> Kembali</a>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<!-- Card 1: Info OPD -->
<div class="card card-wide">
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

<!-- Card 2: Rincian Penilaian -->
<div class="card card-wide">
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

<!-- Card 3: Aksi Verifikasi -->
<div class="card card-wide">
    <div class="section-title">Aksi Verifikasi</div>

    <!-- Verifikasi -->
    <form action="<?= base_url('/admin/verifikasi/verifikasi/' . $penilaian['id']) ?>" method="post" style="margin-bottom: 20px;">
        <?= csrf_field() ?>
        <label style="font-size: 13px; color: #6b7280; display: block; margin-bottom: 6px;">Catatan (opsional):</label>
        <textarea name="catatan" placeholder="Catatan tambahan (opsional)..."></textarea>
        <div class="action-row">
            <div></div>
            <button type="submit" class="btn btn-success" onclick="return confirm('Yakin verifikasi penilaian ini?')">
                <i class="bi bi-check-circle" style="margin-right: 8px;"></i> Verifikasi & Setujui
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
                <i class="bi bi-exclamation-triangle" style="margin-right: 8px;"></i> Minta Revisi
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.getElementById('form-revisi').addEventListener('submit', function (e) {
        const container = document.getElementById('catatan-detail-container');
        container.innerHTML = '';

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
<?= $this->endSection() ?>