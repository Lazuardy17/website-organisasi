<?= $this->extend('App\Modules\Shared\Views\Layouts\Layout_opd') ?>

<?= $this->section('content') ?>

<h1>Akun Perangkat Daerah</h1>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<!-- Card Identitas -->
<div class="card card-wide">
    <div class="opd-header">
        <div class="opd-name">
            <div class="opd-icon">🏛️</div>
            <div class="opd-name-text"><?= esc($opd['nama']) ?></div>
        </div>
        <span class="badge-aktif"><?= esc($opd['status']) ?></span>
    </div>
</div>

<!-- Card Data Akun -->
<div class="card card-wide">
    <h2>Data Akun & Perangkat Daerah</h2>

    <form action="<?= base_url('/opd/akun/update') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="nip_kepala">NIP</label>
            <input type="text" name="nip_kepala" id="nip_kepala"
                   class="form-control" value="<?= esc($opd['nip_kepala'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="nama">Perangkat Daerah</label>
            <input type="text" name="nama" id="nama"
                   class="form-control" value="<?= esc($opd['nama']) ?>" required>
        </div>

        <div class="form-group">
            <label for="nama_kepala">Kepala PD</label>
            <input type="text" name="nama_kepala" id="nama_kepala"
                   class="form-control" value="<?= esc($opd['nama_kepala'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="pangkat_kepala">Pangkat/Golongan</label>
            <input type="text" name="pangkat_kepala" id="pangkat_kepala"
                   class="form-control" value="<?= esc($opd['pangkat_kepala'] ?? '') ?>"
                   placeholder="Cth: Pembina / IV a" required>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>