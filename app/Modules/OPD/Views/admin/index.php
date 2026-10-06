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
        <table>
            <thead>
                <tr>
                    <th style="width: 40px; text-align: center;">No</th>
                    <th style="text-align: center;">Nama OPD</th>
                    <th style="width: 130px; text-align: left;">Username</th>
                    <th style="width: 150px; text-align: center;">Kepala OPD</th>
                    <th style="width: 180px; text-align: center;">NIP</th>
                    <th style="width: 140px; text-align: center;">Pangkat/Golongan</th>
                    <th style="width: 80px;  text-align: center;">Status</th>
                    <th style="width: 140px; text-align: center;">Aksi</th>
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
                            <td><?= $i + 1 ?></td>
                            <td class="col-nama" title="<?= esc($a['nama_opd'] ?? '') ?>">
                                <?= esc($a['nama_opd'] ?? '-') ?>
                            </td>
                            <td><code><?= esc($a['nama_pengguna'] ?? '-') ?></code></td>
                            <td><?= esc($a['nama_kepala'] ?? '-') ?></td>
                            <td style="white-space: nowrap;"><?= esc($a['nip_kepala'] ?? '-') ?></td>
                            <td><?= esc($a['pangkat_kepala'] ?? '-') ?></td>
                            <td>
                                <span class="badge <?= ($a['status'] ?? '') === 'AKTIF' ? 'badge-submitted' : 'badge-verif-ulang' ?>">
                                    <?= esc($a['status'] ?? '-') ?>
                                </span>
                            </td>
                            <td class="col-aksi">
                                <div class="aksi-group">
                                    <a href="<?= base_url('/admin/akun-opd/edit/' . $a['id']) ?>" class="btn btn-secondary">Edit</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>