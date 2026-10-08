<?= $this->extend('App\Modules\Shared\Views\Layouts\Layout_opd') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h1>Kesimpulan & Hasil Evaluasi</h1>
    <span class="status-badge <?= strtolower(str_replace('_', '', $penilaian['status'])) ?>">
        Status: <?= esc($penilaian['status']) ?>
    </span>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<?php if (!empty($catatanUmum)): ?>
    <?php foreach ($catatanUmum as $c): ?>
        <div class="alert alert-warning">
            ⚠️ <strong>Catatan Revisi dari Admin:</strong><br>
            <?= esc($c['catatan']) ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (!$lengkap): ?>
    <div class="alert alert-info">
        ⚠️ Anda baru mengisi <strong><?= $jumlahTerisi ?>/11</strong> variabel.
        Silakan lengkapi semua variabel terlebih dahulu sebelum submit.
    </div>
<?php endif; ?>

<!-- Card Nilai Akhir -->
<div class="card card-wide">
    <div class="nilai-akhir">
        <div class="label">Nilai Akhir</div>
        <div class="value"><?= number_format($totalSkor, 0) ?></div>
        <?php $kelasKesimpulan = 'kesimpulan-' . strtolower(str_replace(' ', '-', $kesimpulan)); ?>
        <span class="kesimpulan <?= $kelasKesimpulan ?>"><?= esc($kesimpulan) ?></span>
    </div>
</div>

<!-- Card Rincian Skor -->
<div class="card card-wide">
    <div class="table-title">Rincian Skor per Indikator</div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Indikator</th>
                    <th style="text-align: right; width: 100px;">Skor</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($detail)): ?>
                    <tr>
                        <td colspan="2" class="empty-row">
                            Belum ada variabel yang diisi.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($detail as $d): ?>
                        <tr>
                            <td><?= esc($d['nama_variabel']) ?></td>
                            <td class="skor"><?= number_format($d['nilai_skor'], 0) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Action Buttons -->
<div class="action-row" style="justify-content: center;">
    <a href="<?= base_url('/opd/penilaian') ?>" class="btn btn-outline">
                    <i class="bi bi-arrow-left" style="margin-right: 8px;"></i> Kembali ke Pengisian</a>

    <?php if ($lengkap && in_array($penilaian['status'], ['DRAFT', 'PERLU_REVISI'])): ?>
        <form action="<?= base_url('/opd/kesimpulan/submit') ?>" method="post" style="display: inline;">
            <?= csrf_field() ?>
            <?php if ($penilaian['status'] === 'PERLU_REVISI'): ?>
                <button type="submit" class="btn btn-warning"
                        onclick="return confirm('Ajukan kembali setelah perbaikan?')">
                    <i class="bi bi-arrow-clockwise" style="margin-right: 8px;"></i> Ajukan Ulang Setelah Revisi
                </button>
            <?php else: ?>
                <button type="submit" class="btn btn-success"
                        onclick="return confirm('Yakin ingin submit? Setelah submit, Anda tidak bisa mengubah lagi kecuali Admin minta revisi.')">
                    Submit ke Admin
                </button>
            <?php endif; ?>
        </form>
    <?php elseif ($penilaian['status'] === 'DIKIRIM'): ?>
        <button class="btn btn-primary" disabled>
            <i class="bi bi-send-check" style="margin-right: 8px;"></i> Sudah Dikirim ke Admin</button>
    <?php elseif ($penilaian['status'] === 'TERVERIFIKASI'): ?>
        <button class="btn btn-success" disabled>
            <i class="bi bi-check-circle" style="margin-right: 8px;"></i> Sudah Terverifikasi</button>
    <?php else: ?>
        <button class="btn" disabled>Lengkapi 11 Variabel Dulu</button>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>