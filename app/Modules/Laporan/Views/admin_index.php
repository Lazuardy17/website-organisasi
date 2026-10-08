<?= $this->extend('App\Modules\Shared\Views\Layouts\Layout_admin') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h1>Ekspor Laporan</h1>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="card card-wide">
    <h2><i class="bi bi-file-earmark-pdf" style="margin-right: 8px;"></i> Buat Laporan PDF</h2>

    <form action="<?= base_url('/admin/laporan/generate') ?>" method="post" target="_blank">
        <?= csrf_field() ?>

        <!-- Periode -->
        <div class="form-group">
            <label for="periode_id">Periode</label>
            <select name="periode_id" id="periode_id" class="form-control" required>
                <option value="">-- Pilih Periode --</option>
                <?php foreach ($periodeList as $p): ?>
                    <option value="<?= $p['id'] ?>">
                        <?= esc($p['tahun']) ?> - <?= esc($p['nama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Cakupan OPD -->
        <div class="form-group">
            <label for="opd_id">Cakupan OPD</label>
            <select name="opd_id" id="opd_id" class="form-control" onchange="toggleFormat()" required>
                <option value="semua">Semua OPD</option>
                <?php foreach ($opdList as $o): ?>
                    <option value="<?= $o['id'] ?>">
                        <?= esc($o['nama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <small style="color:#6b7280; display:block; margin-top:6px;">
            </small>
        </div>

        <!-- Format (muncul kalau pilih OPD tertentu) -->
        <div class="form-group" id="grup-format" style="display: none;">
            <label>Format Laporan</label>

            <div class="radio-group">
                <label class="radio-option">
                    <input type="radio" name="format" value="sheet4">
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
</div>

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
function toggleFormat() {
    const opd = document.getElementById('opd_id').value;
    const grupFormat = document.getElementById('grup-format');

    if (opd === 'semua') {
        grupFormat.style.display = 'none';
    } else {
        grupFormat.style.display = 'block';
    }
}

// Jalankan saat halaman pertama kali dimuat
document.addEventListener('DOMContentLoaded', toggleFormat);
</script>
<?= $this->endSection() ?>