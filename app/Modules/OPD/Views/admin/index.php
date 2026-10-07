<?= $this->extend('App\Modules\Shared\Views\Layouts\Layout_admin') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h1>Manajemen Akun OPD</h1>
    <a href="<?= base_url('/admin/akun-opd/create') ?>" class="btn btn-primary">
        + Tambah Akun OPD
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('akun_baru')): ?>
    <?php $baru = session()->getFlashdata('akun_baru'); ?>
    <div class="alert alert-info">
        <strong>Akun berhasil dibuat!</strong><br>
        OPD: <?= esc($baru['nama_opd']) ?><br>
        Username: <code><?= esc($baru['username']) ?></code><br>
        Password: <code><?= esc($baru['password']) ?></code><br>
        <small>Simpan informasi ini — password tidak akan ditampilkan lagi.</small>
    </div>
<?php endif; ?>

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
                            <td style="text-align: center;"><?= $i + 1 ?></td>
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
                                <a href="<?= base_url('/admin/akun-opd/edit/' . $a['id']) ?>" class="btn btn-primary">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>