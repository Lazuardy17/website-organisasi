<?= $this->extend('App\Modules\Shared\Views\Layouts\Layout_opd') ?>

<?= $this->section('content') ?>

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
    <div class="alert alert-warning">
        ⚠️ <strong>Penilaian Anda sedang dalam status PERLU REVISI.</strong>
        Silakan perbaiki variabel yang ditandai, lalu submit ulang.
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
                        
                        <?php if ($terpilih && !empty($v['tautan_bukti'])): ?>
                            <div style="margin-top: 8px; font-size: 13px;">
                                <a href="<?= esc($v['tautan_bukti']) ?>" 
                                target="_blank" 
                                rel="noopener noreferrer"
                                style="color: #2563eb; text-decoration: underline;">
                                    Buka link bukti →
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </label>
            <?php endforeach; ?>

            <div class="simpan-row">
                <button type="submit" class="btn btn-primary">Simpan Variabel Ini</button>
            </div>
        </form>
    </div>
<?php endforeach; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Tab switching
    document.querySelectorAll('.tab-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.variabel-panel').forEach(p => p.classList.remove('active'));

            btn.classList.add('active');
            document.getElementById(btn.dataset.target).classList.add('active');
            window.scrollTo({ top: 200, behavior: 'smooth' });
        });
    });

    // Pilih tingkat → tampilkan field bukti
    function pilihTingkat(radio, variabelId) {
        document.querySelectorAll('#variabel-' + variabelId + ' .bukti-field').forEach(function (el) {
            el.style.display = 'none';
            const input = el.querySelector('input[name="tautan_bukti"]');
            if (input) input.disabled = true;
        });

        document.querySelectorAll('#variabel-' + variabelId + ' .tingkat-card').forEach(function (el) {
            el.classList.remove('selected');
        });

        const targetId = radio.dataset.target;
        const targetField = document.getElementById(targetId);
        targetField.style.display = 'block';
        const targetInput = targetField.querySelector('input[name="tautan_bukti"]');
        if (targetInput) targetInput.disabled = false;

        radio.closest('.tingkat-card').classList.add('selected');
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.bukti-field').forEach(function (el) {
            if (el.style.display === 'none') {
                const input = el.querySelector('input[name="tautan_bukti"]');
                if (input) input.disabled = true;
            }
        });

        const activeBtn = document.querySelector('.tab-btn.active');
        if (activeBtn) {
            activeBtn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
    });
</script>
<?= $this->endSection() ?>