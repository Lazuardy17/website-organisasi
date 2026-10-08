<?= $this->extend('App\Modules\Shared\Views\Layouts\Layout_opd') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h1>Ekspor Laporan</h1>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<!-- Info: Kalau tidak ada periode yang bisa dicetak -->
<?php
    $adaYangBisaCetak = false;
    foreach ($periodeList as $p) {
        if ($p['bisa_cetak']) {
            $adaYangBisaCetak = true;
            break;
        }
    }
?>

<?php if (empty($periodeList)): ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle" style="margin-right: 8px;"></i> Belum ada periode penilaian. Hubungi Admin.
    </div>
<?php elseif (!$adaYangBisaCetak): ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle" style="margin-right: 8px;"></i>
        <strong>Belum ada laporan yang bisa dicetak.</strong><br>
        Laporan hanya bisa dicetak setelah penilaian Anda diverifikasi oleh Admin.
        Silakan cek status penilaian di halaman <a href="<?= base_url('/opd/kesimpulan') ?>">Kesimpulan & Submit</a>.
    </div>
<?php endif; ?>

<!-- Card Form Ekspor -->
<div class="card card-wide">
    <h2><i class="bi bi-file-earmark-pdf" style="margin-right: 8px;"></i> Buat Laporan PDF</h2>

    <?php if ($adaYangBisaCetak): ?>
        <form action="<?= base_url('/opd/laporan/generate') ?>" method="post" target="_blank">
            <?= csrf_field() ?>

            <!-- Pilih Periode -->
            <div class="form-group">
                <label for="periode_id">Pilih Periode</label>
                <select name="periode_id" id="periode_id" class="form-control" required>
                    <option value="">-- Pilih Periode --</option>
                    <?php foreach ($periodeList as $p): ?>
                        <?php if ($p['bisa_cetak']): ?>
                            <option value="<?= $p['id'] ?>">
                                <?= esc($p['tahun']) ?> - <?= esc($p['nama']) ?> 
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <small style="color:#6b7280; display:block; margin-top:6px;">
                    Hanya periode dengan status <strong>TERVERIFIKASI</strong> yang bisa dicetak.
                </small>
            </div>

            <!-- Pilih Format -->
            <div class="form-group">
                <label>Format Laporan</label>

                <div class="radio-group">
                    <label class="radio-option">
                        <input type="radio" name="format" value="sheet4" required>
                        <div class="radio-label">
                            <strong>Rekapitulasi Hasil Penilaian Kematangan Penataan Perangkat Daerah</strong>
                        </div>
                    </label>

                    <label class="radio-option">
                        <input type="radio" name="format" value="sheet5">
                        <div class="radio-label">
                            <strong>Formulir Penilaian Kematangan Penataan Perangkat Daerah</strong>
                        </div>

                    </label>

                    <label class="radio-option">
                        <input type="radio" name="format" value="gabungan">
                        <div class="radio-label">
                            <strong>Gabungan (Rekapitulasi Hasil + Formulir)</strong>
                        </div>
                    </label>
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-download" style="margin-right: 8px;"></i> Buat & Unduh Laporan PDF
                </button>
            </div>
        </form>
    <?php else: ?>
        <p style="color:#6b7280; margin-top: 12px;">
            Tombol cetak akan muncul di sini setelah penilaian Anda diverifikasi oleh Admin.
        </p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>