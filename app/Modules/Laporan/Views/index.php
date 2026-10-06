<?= $this->extend('App\Modules\Shared\Views\Layouts\Layout_admin') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h1>Ekspor Laporan</h1>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="card card-wide">
    <form action="<?= base_url('/admin/laporan/generate') ?>" method="post" target="_blank">
        <?= csrf_field() ?>

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

        <div class="form-group">
            <label for="opd_id">Cakupan OPD</label>
            <select name="opd_id" id="opd_id" class="form-control">
                <option value="semua">Semua OPD</option>
                <?php foreach ($opdList as $o): ?>
                    <option value="<?= $o['id'] ?>"><?= esc($o['nama']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">📄 Buat & Unduh Laporan PDF</button>
    </form>

    <div class="info-box">
        <strong>ℹ️ Informasi:</strong><br>
        Laporan berisi data OPD (nama, kepala, NIP, pangkat), 11 variabel penilaian beserta tingkat dan skor,
        total skor, serta kesimpulan. File PDF akan otomatis terunduh.
    </div>
</div>

<?= $this->endSection() ?>